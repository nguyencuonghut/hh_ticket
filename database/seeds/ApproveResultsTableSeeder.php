<?php

use Illuminate\Database\Seeder;

class ApproveResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('approve_results')->delete();

        \DB::table('approve_results')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Đồng ý',
                    'color' => 'blue',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Từ chối',
                    'color' => 'red',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Chưa duyệt',
                    'color' => 'orange',
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
        ));
    }
}
