 
<?php

use Illuminate\Database\Seeder;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('positions')->truncate();
        DB::table('positions')->insert([
            [
                'id' => '1',
                'name' => 'Project manager',
            ],
            [
                'id' => '2',
                'name' => 'Tech leader',
            ],
            [
                'id' => '3',
                'name' => 'Developer',
            ],
            [
                'id' => '4',
                'name' => 'Tester',
            ],
            [
                'id' => '5',
                'name' => 'Comter',
            ],
        ]);
    }
}
