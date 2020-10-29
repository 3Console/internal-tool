<?php

namespace App\Http\Services;

use App\User;
use App\Models\Word;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Bucket;

class WordService
{
    public function getWords($params)
    {
        $limit = array_get($params, 'limit', 10);
        return Word::where('role', 1)->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
            $search = array_get($params, 'search');
            return $query->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('full_name', 'like', "%$search%");
        })->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function increasePriority($ids) {
        foreach($ids as $id) {
            $word = Word::find($id);
            $word->priority ++;
            $word->update();
        }
    }

    public function decreasePriority($ids) {
        foreach($ids as $id) {
            $word = Word::find($id);
            $word->priority --;
            $word->update();
        }
    }


    public function getRandomWord() {
        return Word::inRandomOrder()->limit(8)->get();;
    }

    public function getAllPhrases($userId) {
        $phraseId = Bucket::where('user_id', $userId)->first()->categories()->where('title', 'Phrase')->first()->id;
        return [
            'id' => $phraseId,
            'data' => Word::where('category_id', $phraseId)->get()
        ];
    }

    public function updateImage(Word $word, $imageUrl) {
        $word->update([
            'image' => $imageUrl
        ]);
        return $word;
    }

    public function changeImportant(Word $word) {
        $word->update([
            'is_important' => !$word->is_important
        ]);
        return $word;
    }

    public function storeWord($params)
    {
        $word = Word::create([
            'category_id' => array_get($params, 'category_id'),
            'word' => array_get($params, 'word'),
            'hint' => array_get($params, 'hint'),
            'meaning' => array_get($params, 'meaning'),
            'image' => array_get($params, 'image'),
            'is_important' => array_get($params, 'is_important')
        ]);

        return $this->getOneWord($word);
    }

    public function updateWord(Word $word, $params)
    {
        $word->update([
          'meaning' => array_get($params, 'meaning'),
          'hint' => array_get($params, 'hint'),
        ]);
        return $word;
    }

    public function getOneWord(Word $word)
    {
        return $word;
    }

    public function deleteOneWord(Word $word)
    {
        $word->delete();

        return 'ok';
    }

    public function deleteManyWord($params)
    {
        $wordIds = array_get($params, 'ids', []);
        if (count($wordIds) > 0) {
            User::whereIn('id', $wordIds)->delete();
        }
        return 'ok';
    }
}
