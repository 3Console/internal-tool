<?php

namespace App\Http\Services;

use App\User;
use App\Models\Category;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Bucket;
use App\Models\Word;

class GameService
{
    public function getGame3Resource($categoryIds, $userId)
    {  
     
       $bucketId = Bucket::where('user_id', $userId)->first()->id;

       $categories = Category::where('bucket_id', $bucketId)
       ->whereIn('id', $categoryIds)->get();

       $words = $categories->map(function ($category) {
           return Word::where('category_id', $category->id)->inRandomOrder()->get();
       })->flatten()->shuffle()->take(8);

       return $words;
    }

    public function getGame2Resource($categoryIds, $userId)
    {  
     
       $bucketId = Bucket::where('user_id', $userId)->first()->id;

       $categories = Category::where('bucket_id', $bucketId)
       ->whereIn('id', $categoryIds)->get();

       $words = $categories->map(function ($category) {
           return Word::where('category_id', $category->id)->inRandomOrder()->get();
       })->flatten()->sortByDesc('priority')->filter(function ($word) {
            return strlen($word->word) <= 16;
       });

       if($words->count() >=5) {
           return $words->take(5)->shuffle();
       }

       return $words->all()->shuffle();
    }

    public function getGame1Resource($categoryIds, $userId)
    {  
     
       $bucketId = Bucket::where('user_id', $userId)->first()->id;

       $categories = Category::where('bucket_id', $bucketId)
       ->whereIn('id', $categoryIds)->get();
       $words = $categories->map(function ($category) {
           return Word::where('category_id', $category->id)->inRandomOrder()->get();
       })->flatten()->sortByDesc('priority');

       return $words->map(function ($word) use ($words) {
        
          $randomWords = self::getRandomWord($words, $word->word)->map(function($word) {
              return [
                  'content' => $word->word,
                  'correct' => false
              ];
          })->push([
            'content' => $word->word,
            'correct' => true
        ]);
        
          return [
              'content' => $word->meaning,
              'options' => $randomWords
          ];


       });




       return self::getRandomWord($words, 'CHALK AND CHEESE');
    }

    private static function getRandomWord($words, $ignoreWord) {
        return $words->filter(function($word) use ($ignoreWord) {
            return $word->word != $ignoreWord;
        })->shuffle()->take(3);
    }

}
