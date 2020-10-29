<?php

use Illuminate\Database\Seeder;

class WordsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('words')->delete();
        
        \DB::table('words')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => 2,
                'word' => 'hello',
                'meaning' => 'Chào',
                'hint' => 'Khi moi ga',
                'image' => 'https://upload.wikimedia.org/wikipedia/en/0/05/Hello_kitty_character_portrait.png',
                'is_important' => 1,
                'priority' => -5,
                'created_at' => NULL,
                'updated_at' => '2020-09-09 01:48:52',
            ),
            1 => 
            array (
                'id' => 2,
                'category_id' => 2,
                'word' => 'orange',
                'meaning' => 'Cam',
                'hint' => NULL,
                'image' => 'https://pngimg.com/uploads/orange/orange_PNG791.png',
                'is_important' => 1,
                'priority' => -3,
                'created_at' => NULL,
                'updated_at' => '2020-09-07 15:15:01',
            ),
            2 => 
            array (
                'id' => 3,
                'category_id' => 2,
                'word' => 'apple',
                'meaning' => 'Táo',
                'hint' => NULL,
                'image' => 'https://purepng.com/public/uploads/large/purepng.com-fresh-applefoodsweettastyhealthyfruitappleleaf-981524677946vfurf.png',
                'is_important' => 1,
                'priority' => -2,
                'created_at' => NULL,
                'updated_at' => '2020-09-07 15:15:02',
            ),
            3 => 
            array (
                'id' => 4,
                'category_id' => 2,
                'word' => 'jack fruit',
                'meaning' => 'Mít',
                'hint' => NULL,
                'image' => 'https://cdn.i-scmp.com/sites/default/files/d8/images/methode/2020/02/02/188907e2-4327-11ea-9fd9-ecfbb38a9743_image_hires_075147.jpg',
                'is_important' => 1,
                'priority' => -3,
                'created_at' => NULL,
                'updated_at' => '2020-09-08 01:54:43',
            ),
            4 => 
            array (
                'id' => 5,
                'category_id' => 2,
                'word' => 'dragon fruit',
                'meaning' => 'Thanh long',
                'hint' => NULL,
                'image' => 'https://savingdinner.com/wp-content/uploads/2020/02/Dragon-Fruit.jpg',
                'is_important' => 0,
                'priority' => -2,
                'created_at' => NULL,
                'updated_at' => '2020-09-06 16:29:56',
            ),
            5 => 
            array (
                'id' => 6,
                'category_id' => 2,
                'word' => 'lemon',
                'meaning' => 'Chanh',
                'hint' => NULL,
                'image' => 'https://natashaskitchen.com/wp-content/uploads/2019/06/What-To-Do-With-Lemons.jpg',
                'is_important' => 0,
                'priority' => -2,
                'created_at' => NULL,
                'updated_at' => '2020-09-06 16:29:56',
            ),
            6 => 
            array (
                'id' => 7,
                'category_id' => 2,
                'word' => 'grapes',
                'meaning' => 'Nho',
                'hint' => NULL,
                'image' => 'https://cdn-b.medlife.com/2019/02/grapes-health-benefits.png',
                'is_important' => 0,
                'priority' => -1,
                'created_at' => NULL,
                'updated_at' => '2020-09-07 11:17:19',
            ),
            7 => 
            array (
                'id' => 8,
                'category_id' => 2,
                'word' => 'pineapple',
                'meaning' => 'Dứa',
                'hint' => NULL,
                'image' => 'https://i5.walmartimages.ca/images/Enlarge/198/506/6000200198506.jpg',
                'is_important' => 0,
                'priority' => -3,
                'created_at' => NULL,
                'updated_at' => '2020-09-07 11:17:47',
            ),
            8 => 
            array (
                'id' => 9,
                'category_id' => 2,
                'word' => 'coconut',
                'meaning' => 'Dừa',
                'hint' => NULL,
                'image' => 'https://www.plantgrower.org/uploads/6/5/5/4/65545169/published/coconut-white-balsamic-condimento.jpg',
                'is_important' => 0,
                'priority' => -3,
                'created_at' => NULL,
                'updated_at' => '2020-09-06 16:29:56',
            ),
            9 => 
            array (
                'id' => 10,
                'category_id' => 2,
                'word' => 'guava',
                'meaning' => 'Ổi',
                'hint' => NULL,
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/0/02/Guava_ID.jpg/1200px-Guava_ID.jpg',
                'is_important' => 0,
                'priority' => 0,
                'created_at' => NULL,
                'updated_at' => '2020-09-07 11:17:28',
            ),
            10 => 
            array (
                'id' => 11,
                'category_id' => 1,
                'word' => 'raining cats and dogs',
                'meaning' => 'Mưa nặng hạt',
                'hint' => 'Rain heavily',
                'image' => 'https://image.shutterstock.com/image-photo/heavy-rain-tree-parking-260nw-676963948.jpg',
                'is_important' => 1,
                'priority' => 0,
                'created_at' => NULL,
                'updated_at' => '2020-09-09 01:38:42',
            ),
            11 => 
            array (
                'id' => 12,
                'category_id' => 1,
                'word' => 'CHALK AND CHEESE',
                'meaning' => 'rất khác nhau',
                'hint' => 'very different from each other',
                'image' => 'https://christianmomthoughts.com//wp-content/uploads/christianencouragementsecularencouragement.jpg',
                'is_important' => 1,
                'priority' => -1,
                'created_at' => NULL,
                'updated_at' => '2020-09-09 06:37:16',
            ),
            12 => 
            array (
                'id' => 13,
                'category_id' => 1,
                'word' => 'HERE AND THERE',
                'meaning' => 'Ở mọi nơi',
                'hint' => 'Everywhere',
                'image' => 'https://images-na.ssl-images-amazon.com/images/I/81zNzaSAW+L.jpg',
                'is_important' => 0,
                'priority' => -1,
                'created_at' => NULL,
                'updated_at' => '2020-09-09 06:36:54',
            ),
            13 => 
            array (
                'id' => 14,
                'category_id' => 1,
                'word' => ' A HOT POTATO',
                'meaning' => 'vấn đề nan giải',
                'hint' => 'something that is difficulut or dangerous to deal with',
                'image' => 'https://previews.123rf.com/images/capeman29/capeman292003/capeman29200300003/142420788-a-hot-potato-cartoon-character-screaming-while-burning-with-hot-fire.jpg',
                'is_important' => 0,
                'priority' => -1,
                'created_at' => NULL,
                'updated_at' => '2020-09-09 15:19:44',
            ),
            14 => 
            array (
                'id' => 15,
                'category_id' => 3,
                'word' => 'Math',
                'meaning' => 'Môn Toán',
                'hint' => 'Có hình học và số học',
                'image' => 'http://localhost:8000/storage/images/1599387104.jpg',
                'is_important' => 1,
                'priority' => -2,
                'created_at' => '2020-09-06 10:11:54',
                'updated_at' => '2020-09-09 01:47:41',
            ),
            15 => 
            array (
                'id' => 16,
                'category_id' => 3,
                'word' => 'literature',
                'meaning' => 'Môn văn',
                'hint' => 'blabal',
                'image' => 'http://localhost:8000/storage/images/1599387219.webp',
                'is_important' => 1,
                'priority' => -2,
                'created_at' => '2020-09-06 10:13:41',
                'updated_at' => '2020-09-09 01:48:13',
            ),
            16 => 
            array (
                'id' => 17,
                'category_id' => 3,
                'word' => 'History',
                'meaning' => 'Lịch sử',
                'hint' => 'goi y test',
                'image' => 'http://localhost:8000/storage/images/1599387249.jpg',
                'is_important' => 1,
                'priority' => -2,
                'created_at' => '2020-09-06 10:14:15',
                'updated_at' => '2020-09-09 01:48:32',
            ),
            17 => 
            array (
                'id' => 18,
                'category_id' => 3,
                'word' => 'Informatics',
                'meaning' => 'Tin học',
                'hint' => NULL,
                'image' => 'http://localhost:8000/storage/images/1599387279.jpg',
                'is_important' => 0,
                'priority' => -3,
                'created_at' => '2020-09-06 10:15:16',
                'updated_at' => '2020-09-07 16:19:31',
            ),
            18 => 
            array (
                'id' => 19,
                'category_id' => 3,
                'word' => 'Chemistry',
                'meaning' => 'Hóa học',
                'hint' => NULL,
                'image' => 'http://localhost:8000/storage/images/1599387358.jpg',
                'is_important' => 0,
                'priority' => -2,
                'created_at' => '2020-09-06 10:16:06',
                'updated_at' => '2020-09-07 16:19:09',
            ),
            19 => 
            array (
                'id' => 24,
                'category_id' => 4,
                'word' => 'Computer',
                'meaning' => 'Máy vi tính',
                'hint' => 'PC',
                'image' => 'http://localhost:8000/storage/images/1599489314.png',
                'is_important' => 0,
                'priority' => -1,
                'created_at' => '2020-09-07 14:35:15',
                'updated_at' => '2020-09-07 14:52:30',
            ),
            20 => 
            array (
                'id' => 27,
                'category_id' => 6,
                'word' => 'Sunny',
                'meaning' => 'Nắng',
                'hint' => 'Thời tiết nóng',
                'image' => 'http://localhost:8000/storage/images/1599528924.jpg',
                'is_important' => 0,
                'priority' => 0,
                'created_at' => '2020-09-08 01:35:26',
                'updated_at' => '2020-09-08 01:42:23',
            ),
            21 => 
            array (
                'id' => 28,
                'category_id' => 8,
                'word' => 'Ruler',
                'meaning' => 'Cái thước',
                'hint' => 'ii',
                'image' => 'http://localhost:8000/storage/images/1599552836.webp',
                'is_important' => 0,
                'priority' => 0,
                'created_at' => '2020-09-08 08:13:57',
                'updated_at' => '2020-09-08 08:54:22',
            ),
            22 => 
            array (
                'id' => 29,
                'category_id' => 1,
                'word' => 'fdf',
                'meaning' => 'dsfdf',
                'hint' => 'dsfsdf',
                'image' => 'http://localhost:8000/storage/images/1599630172.png',
                'is_important' => 1,
                'priority' => -1,
                'created_at' => '2020-09-09 05:33:15',
                'updated_at' => '2020-09-09 06:36:28',
            ),
            23 => 
            array (
                'id' => 30,
                'category_id' => 1,
                'word' => 'fdsf',
                'meaning' => 'eee faa',
                'hint' => 'fffff ds d',
                'image' => NULL,
                'is_important' => 1,
                'priority' => -2,
                'created_at' => '2020-09-09 05:43:18',
                'updated_at' => '2020-09-09 15:19:30',
            ),
        ));
        
        
    }
}