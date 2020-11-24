 
<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('projects')->truncate();
        DB::table('projects')->insert([
            [
                'id' => '1',
                'name' => 'Project alpha',
            ],
            [
                'id' => '2',
                'name' => 'Project beta',
            ],
            [
                'id' => '3',
                'name' => 'Project omega',
            ],
        ]);
    }
}
