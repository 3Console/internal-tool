 
<?php

use Illuminate\Database\Seeder;

class UserProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('user_projects')->truncate();
        DB::table('user_projects')->insert([
            [
                'id' => '1',
                'user_id' => 2,
                'project_id' => 1,
                'position_id' => 1,
            ],
            [
              'id' => '2',
              'user_id' => 2,
              'project_id' => 2,
              'position_id' => 3,
          ],
        ]);
    }
}
