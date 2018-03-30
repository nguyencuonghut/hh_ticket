<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'name' => 'Admin',
                    'email' => 'hongha-dev@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            1 =>
                array (
                    'id' => 2,
                    'name' => 'Tạ Văn Toại',
                    'email' => 'tavantoai@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            2 =>
                array (
                    'id' => 3,
                    'name' => 'Nguyễn Văn Cường',
                    'email' => 'nguyenvancuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            3 =>
                array (
                    'id' => 4,
                    'name' => 'Lê Văn Khoa',
                    'email' => 'levankhoa@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            4 =>
                array (
                    'id' => 5,
                    'name' => 'Tony Nguyen',
                    'email' => 'nguyencuonghut55@gmail.com',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            5 =>
                array (
                    'id' => 6,
                    'name' => 'Phạm Thành Thứ',
                    'email' => 'phamthanhthu@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            6 =>
                array (
                    'id' => 7,
                    'name' => 'Nguyễn Thị Miến',
                    'email' => 'nguyenthimien@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            7 =>
                array (
                    'id' => 8,
                    'name' => 'Trần Tiến Dũng',
                    'email' => 'trantiendung@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            8 =>
                array (
                    'id' => 9,
                    'name' => 'Đỗ Thị Thu Hương',
                    'email' => 'dothithuhuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            9 =>
                array (
                    'id' => 10,
                    'name' => 'Hoàng Liên Sơn',
                    'email' => 'hoanglienson@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            10 =>
                array (
                    'id' => 11,
                    'name' => 'Nguyễn Hương Nga',
                    'email' => 'nguyenhuongnga@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            11 =>
                array (
                    'id' => 12,
                    'name' => 'Phạm Thị Trang',
                    'email' => 'phamthitrang@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            12 =>
                array (
                    'id' => 13,
                    'name' => 'Hà Thị Lê',
                    'email' => 'hathile@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            13 =>
                array (
                    'id' => 14,
                    'name' => 'Nguyễn Thị Hằng',
                    'email' => 'nguyenthihang@longhaigroup.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            14 =>
                array (
                    'id' => 15,
                    'name' => 'Phạm Thị Thái Hà',
                    'email' => 'phamthithaiha@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            15 =>
                array (
                    'id' => 16,
                    'name' => 'Bùi Thị Nga',
                    'email' => 'buithingga@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            16 =>
                array (
                    'id' => 17,
                    'name' => 'Đỗ Minh Vương',
                    'email' => 'dominhvuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            17 =>
                array (
                    'id' => 18,
                    'name' => 'Dương Xuân Sơn',
                    'email' => 'duongxuanson@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            18 =>
                array (
                    'id' => 19,
                    'name' => 'Nguyễn Văn Lâm',
                    'email' => 'nguyenvanlam@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            19 =>
                array (
                    'id' => 20,
                    'name' => 'Hoàng Thị Ngọc Ánh',
                    'email' => 'hoangthingocanh@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            20 =>
                array (
                    'id' => 21,
                    'name' => 'Nguyễn Thị Bích Ngọc',
                    'email' => 'nguyenthibichngoc@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            21 =>
                array (
                    'id' => 22,
                    'name' => 'Hoàng Ngọc Hà',
                    'email' => 'hoangngocha@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            22 =>
                array (
                    'id' => 23,
                    'name' => 'Lê Thị Mến',
                    'email' => 'lethimen@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            23 =>
                array (
                    'id' => 24,
                    'name' => 'Đặng Việt Hoàn',
                    'email' => 'dangviethoan@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            24 =>
                array (
                    'id' => 25,
                    'name' => 'Trần Thị Thu Huyền',
                    'email' => 'tranthithuhuyen@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            25 =>
                array (
                    'id' => 26,
                    'name' => 'Nguyễn Thị Thanh Huyền',
                    'email' => 'nguyenthithanhuyen@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
            26 =>
                array (
                    'id' => 27,
                    'name' => 'Lê Thị Sương',
                    'email' => 'lethisuong@honghafeed.com.vn',
                    'password' => bcrypt('Hongha@123'),
                    'address' => '',
                    'work_number' => 0,
                    'personal_number' => 0,
                    'image_path' => '',
                    'remember_token' => null,
                    'created_at' => '2016-06-04 13:42:19',
                    'updated_at' => '2016-06-04 13:42:19',
                ),
        ));
    }
}