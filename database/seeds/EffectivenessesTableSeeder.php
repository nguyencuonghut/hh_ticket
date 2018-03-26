<?php

use Illuminate\Database\Seeder;

class EffectivenessesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('effectivenesses')->delete();

        \DB::table('effectivenesses')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Cao',
                    'color' => 'green',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Trung bình',
                    'color' => 'orange',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Thấp',
                    'color' => 'red',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
        ));
    }
}
