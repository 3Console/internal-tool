<?php

namespace App\Http\Services;

use App\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Bucket;

class BucketService
{
    public function initBucketUser($userId)
    {
        $newBucket = Bucket::create([
            'user_id' => $userId
        ]);

        Category::create([
            'title' => 'Phrase',
            'bucket_id' => $newBucket->id,
            'is_visible' => false
        ]);
        // return Bucket::where('user_id', $userId)->first()->categories()->get();
    }

}
