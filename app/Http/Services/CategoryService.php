<?php

namespace App\Http\Services;

use App\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Word;
use App\Models\Bucket;

class CategoryService
{
    public function getCategories($userId)
    {
        return Bucket::where('user_id', $userId)->first()->categories()->get();
    }

    public function getAllWordsByCategory($categoryId) {
        return Word::where('category_id', $categoryId)->get();
    }

    public function getTotalWordByCategories($ids) {
        return Category::whereIn('id', $ids)->get()->reduce(function($carry, $item){
            return $carry + $item["total_word"];
        }, 0);
    }

    public function getIdBySlug($userId, $slug) {
        $bucketId = Bucket::where('user_id', $userId)->firstOrFail()->id;
        return Category::where([
            'bucket_id' => $bucketId,
            'slug' => $slug
        ])->first()->id;
    }

    public function storeCategory($userId, $params)
    {
        $bucket = Bucket::where('user_id', $userId)->first();
        $category = Category::create([
            'title' => array_get($params, 'title'),
            'slug' =>  str_slug(array_get($params, 'title')),
            'cover' => array_get($params, 'cover'),
            'is_visible' => array_get($params, 'is_visible'),
            'bucket_id' => $bucket->id
        ]);

        return $this->getOneCategory($category);
    }

    public function updateCategory(User $category, $params)
    {
        $category->update([
          'full_name' => array_get($params, 'full_name'),
          'name' => array_get($params, 'name'),
          'email' => array_get($params, 'email'),
        ]);
        if(array_get($params, 'passcategory')) {
          $category->update(['passcategory' => bcrypt(array_get($params, 'passcategory'))]);
        }
        return $category;
    }

    public function getOneCategory(Category $category)
    {
        return $category;
    }

    public function deleteOneCategory(Category $category)
    {
        $category->delete();

        return 'ok';
    }

    public function deleteManyCategory($params)
    {
        $categoryIds = array_get($params, 'ids', []);
        if (count($categoryIds) > 0) {
            User::whereIn('id', $categoryIds)->delete();
        }
        return 'ok';
    }
}
