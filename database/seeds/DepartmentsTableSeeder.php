<?php

use Illuminate\Database\Seeder;

use App\Models\Department;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createDep = new Department;
        $createDep->id = '1';
        $createDep->name = 'Phòng HCNS';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '2';
        $createDep->name = 'BP Kinh Doanh';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '3';
        $createDep->name = 'Phòng Kế Toán';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '4';
        $createDep->name = 'Phòng KSNB';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '5';
        $createDep->name = 'Phòng Bảo Trì';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '6';
        $createDep->name = 'Phòng Sản Xuất';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '7';
        $createDep->name = 'Phòng Thu Mua';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '8';
        $createDep->name = 'Phòng Kỹ Thuật';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '9';
        $createDep->name = 'Phòng QLCL';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '10';
        $createDep->name = 'BP Kho';
        $createDep->save();

        $createDep = new Department;
        $createDep->id = '11';
        $createDep->name = 'BP Pháp Chế';
        $createDep->save();


        \DB::table('department_user')->insert([
            'department_id' => 1,
            'user_id' => 1
        ]);
        /*
        \DB::table('department_user')->insert([
            'department_id' => 4,
            'user_id' => 2
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 1,
            'user_id' => 3
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 4,
            'user_id' => 4
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 1,
            'user_id' => 5
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 9,
            'user_id' => 6
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 9,
            'user_id' => 7
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 9,
            'user_id' => 8
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 9,
            'user_id' => 9
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 6,
            'user_id' => 10
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 3,
            'user_id' => 11
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 2,
            'user_id' => 12
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 2,
            'user_id' => 13
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 1,
            'user_id' => 14
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 1,
            'user_id' => 15
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 3,
            'user_id' => 16
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 3,
            'user_id' => 17
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 5,
            'user_id' => 18
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 5,
            'user_id' => 19
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 10,
            'user_id' => 20
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 10,
            'user_id' => 21
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 6,
            'user_id' => 22
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 6,
            'user_id' => 23
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 7,
            'user_id' => 24
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 7,
            'user_id' => 25
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 8,
            'user_id' => 26
        ]);
        \DB::table('department_user')->insert([
            'department_id' => 8,
            'user_id' => 27
        ]);
        */
    }
}
