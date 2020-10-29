<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'bucket_id' => 1,
                'title' => 'Phrase',
                'cover' => 'https://pbs.twimg.com/profile_images/972055567035883520/8uCAWl8v.jpg',
                'is_visible' => 0,
                'created_at' => NULL,
                'updated_at' => NULL,
                'slug' => 'phrase',
            ),
            1 => 
            array (
                'id' => 2,
                'bucket_id' => 1,
                'title' => 'Fruit',
                'cover' => 'https://i.pinimg.com/600x315/00/02/73/000273215edf92b43dce81039da97cf4.jpg',
                'is_visible' => 1,
                'created_at' => NULL,
                'updated_at' => NULL,
                'slug' => 'fruit',
            ),
            2 => 
            array (
                'id' => 3,
                'bucket_id' => 1,
                'title' => 'Subject',
                'cover' => 'http://localhost:8000/storage/images/1599387061.jpg',
                'is_visible' => 1,
                'created_at' => '2020-09-06 10:11:07',
                'updated_at' => '2020-09-06 10:11:07',
                'slug' => 'subject',
            ),
            3 => 
            array (
                'id' => 4,
                'bucket_id' => 1,
                'title' => 'IT',
                'cover' => 'http://localhost:8000/storage/images/1599487474.png',
                'is_visible' => 1,
                'created_at' => '2020-09-07 14:04:35',
                'updated_at' => '2020-09-07 14:04:35',
                'slug' => 'it',
            ),
            4 => 
            array (
                'id' => 6,
                'bucket_id' => 1,
                'title' => 'Weather',
                'cover' => 'http://localhost:8000/storage/images/1599495068.jpg',
                'is_visible' => 1,
                'created_at' => '2020-09-07 16:11:11',
                'updated_at' => '2020-09-07 16:11:11',
                'slug' => 'weather',
            ),
            5 => 
            array (
                'id' => 7,
                'bucket_id' => 2,
                'title' => 'Phrase',
                'cover' => NULL,
                'is_visible' => 0,
                'created_at' => '2020-09-07 16:15:52',
                'updated_at' => '2020-09-07 16:15:52',
                'slug' => NULL,
            ),
            6 => 
            array (
                'id' => 8,
                'bucket_id' => 2,
                'title' => 'Study',
                'cover' => 'http://localhost:8000/storage/images/1599552803.jpg',
                'is_visible' => 1,
                'created_at' => '2020-09-08 08:13:24',
                'updated_at' => '2020-09-08 08:13:24',
                'slug' => 'study',
            ),
        ));
        
        
    }
}