 
<?php

use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('notifications')->truncate();
        DB::table('notifications')->insert([
            [
                'id' => '1',
                'sender_id' => 1,
                'receiver_id' => 2,
                'title' => 'Welcome to Internal tool',
                'content' => 'Test message'
            ],
            [
                'id' => '2',
                'sender_id' => 1,
                'receiver_id' => 3,
                'title' => 'Welcome to Internal tool',
                'content' => 'Test message'
            ],
        ]);
    }
}
