 
<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
        ],
        [
          "name" => "user1",
          "full_name" => "User 1",
          "email" => "user1@gmail.com",
          "password" => bcrypt('123456'),
          "role" => 1
        ],
        [
          "name" => "user2",
          "full_name" => "User 2",
          "email" => "user2@gmail.com",
          "password" => bcrypt('123456'),
          "role" => 1
        ]
      ]);
    }
}
