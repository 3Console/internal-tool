 
<?php

use Illuminate\Database\Seeder;

class AbsenceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('absence_types')->truncate();
        DB::table('absence_types')->insert([
            [
                'id' => '1',
                'name' => 'Nghỉ không lương',
            ],
            [
                'id' => '2',
                'name' => 'Xin làm remote ở nhà',
            ],
            [
                'id' => '3',
                'name' => 'Nghỉ Thai Sản',
            ],
            [
                'id' => '4',
                'name' => 'Nghỉ Hiếu Hỷ',
            ],
            [
                'id' => '5',
                'name' => 'Khác',
            ],
        ]);
    }
}
