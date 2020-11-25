<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([[
          "name" => "admin",
          "full_name" => "admin",
          "email" => "admin@gmail.com",
          "password" => bcrypt('123456'),
          "role" => 2
        ],[
          "name" => "user1",
          "full_name" => "User 1",
          "email" => "user1@gmail.com",
          "password" => bcrypt('123456'),
          "role" => 1
        ]]);
        DB::table('buckets')->truncate();
        DB::table('buckets')->insert([
          [
            "user_id" => 2
          ]
        ]);
        DB::table('categories')->truncate();
        DB::table('categories')->insert([
         [
          "title" => "Phrase",
          "cover" => "https://pbs.twimg.com/profile_images/972055567035883520/8uCAWl8v.jpg",
          "bucket_id" => 1,
          "is_visible" => false,
          "slug" => "phrase"
         ], [
          "title" => "Fruit",
          "cover" => "https://i.pinimg.com/600x315/00/02/73/000273215edf92b43dce81039da97cf4.jpg",
          "bucket_id" => 1,
          "is_visible" => true,
          "slug" => "fruit"
         ]
        ]);
        DB::table('words')->truncate();
        DB::table('words')->insert([[
          "category_id" => 2,
          "word" => "hello",
          "meaning" => "Chào",
          "image" => "https://upload.wikimedia.org/wikipedia/en/0/05/Hello_kitty_character_portrait.png"
        ],[
          "category_id" => 2,
          "word" => "orange",
          "meaning" => "Cam",
          "image" => "https://pngimg.com/uploads/orange/orange_PNG791.png"
        ],[
          "category_id" => 2,
          "word" => "apple",
          "meaning" => "Táo",
          "image" => "https://purepng.com/public/uploads/large/purepng.com-fresh-applefoodsweettastyhealthyfruitappleleaf-981524677946vfurf.png"
        ],[
          "category_id" => 2,
          "word" => "jack fruit",
          "meaning" => "Mít",
          "image" => "https://cdn.i-scmp.com/sites/default/files/d8/images/methode/2020/02/02/188907e2-4327-11ea-9fd9-ecfbb38a9743_image_hires_075147.jpg"
        ],[
          "category_id" => 2,
          "word" => "dragon fruit",
          "meaning" => "Thanh long",
          "image" => "https://savingdinner.com/wp-content/uploads/2020/02/Dragon-Fruit.jpg"
        ],[
          "category_id" => 2,
          "word" => "lemon",
          "meaning" => "Chanh",
          "image" => "https://natashaskitchen.com/wp-content/uploads/2019/06/What-To-Do-With-Lemons.jpg"
        ],[
          "category_id" => 2,
          "word" => "grapes",
          "meaning" => "Nho",
          "image" => "https://cdn-b.medlife.com/2019/02/grapes-health-benefits.png"
        ],[
          "category_id" => 2,
          "word" => "pineapple",
          "meaning" => "Dứa",
          "image" => "https://i5.walmartimages.ca/images/Enlarge/198/506/6000200198506.jpg"
        ],[
          "category_id" => 2,
          "word" => "coconut",
          "meaning" => "Dừa",
          "image" => "https://www.plantgrower.org/uploads/6/5/5/4/65545169/published/coconut-white-balsamic-condimento.jpg"
        ],[
          "category_id" => 2,
          "word" => "guava",
          "meaning" => "Ổi",
          "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/Guava_ID.jpg/1200px-Guava_ID.jpg"
        ]]);

        DB::table('words')->insert([
        [
          "category_id" => 1,
          "word" => "raining cats and dogs",
          "meaning" => "Mưa nặng hạt",
          "hint" => "Rain heavily",
          "image" => "https://image.shutterstock.com/image-photo/heavy-rain-tree-parking-260nw-676963948.jpg"
        ],[
          "category_id" => 1,
          "word" => "CHALK AND CHEESE",
          "meaning" => "rất khác nhau",
          "hint" => "very different from each other",
          "image" => "https://christianmomthoughts.com//wp-content/uploads/christianencouragementsecularencouragement.jpg"
        ],[
          "category_id" => 1,
          "word" => "HERE AND THERE",
          "meaning" => "Ở mọi nơi",
          "hint" => "Everywhere",
          "image" => "https://images-na.ssl-images-amazon.com/images/I/81zNzaSAW+L.jpg"
        ],[
          "category_id" => 1,
          "word" => " A HOT POTATO",
          "meaning" => "vấn đề nan giải",
          "hint" => "something that is difficulut or dangerous to deal with",
          "image" => "https://previews.123rf.com/images/capeman29/capeman292003/capeman29200300003/142420788-a-hot-potato-cartoon-character-screaming-while-burning-with-hot-fire.jpg"
        ]]);

        $this->call(AbsenceTypesTableSeeder::class);
        $this->call(PositionsTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(UserProjectsTableSeeder::class);
    }
}
