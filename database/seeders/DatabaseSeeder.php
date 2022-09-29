<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'name' => 'Undefined',
                'description' => 'Chưa phân loại',
                'color' => '',
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'name' => 'SBD South',
                'description' => '',
                'color' => '#3D800C',
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'mame' => 'SBD Solution',
                'description' => '',
                'color' => '#2692FF',
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'mame' => 'SBD QI',
                'description' => '',
                'color' => '#FF8000',
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'mame' => 'SBD Telecom',
                'description' => '',
                'color' => '#9326FF',
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
        ]);

        DB::table('groups')->insert([
            [
                'name' => 'Undefined',
                'technician' => 0,
                'level' => 0,
                'description' => 'Chưa phân loại'
            ],
            [
                'name' => 'Collab',
                'technician' => 1,
                'level' => 0,
                'description' => ''
            ],
            [
                'name' => 'Network',
                'technician' => 1,
                'level' => 0,
                'description' => ''
            ],
            [
                'name' => 'Hạ tầng',
                'technician' => 1,
                'level' => 0,
                'description' => ''
            ],
            [
                'name' => 'Security',
                'technician' => 1,
                'level' => 0,
                'description' => ''
            ],
            [
                'name' => 'System',
                'technician' => 1,
                'level' => 0,
                'description' => ''
            ],
            [
                'name' => 'Tích hợp',
                'technician' => 1,
                'level' => 0,
                'description' => ''
            ],
            [
                'name' => 'M&E',
                'technician' => 1,
                'level' => 0,
                'description' => ''
            ]
        ]);


        DB::table('categories')->insert([
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'General',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Desktop Hardware',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Internet',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Network',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Operating System',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Printers',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Routers',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Security',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Services',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Software',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Switches',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'Telephone',
                'description' => ''
            ],
            [
                'type' => 'Default',
                'parent_id' => 0,
                'name' => 'User Administration',
                'description' => ''
            ]
        ]);

        DB::table('users')->insert([
            [
                'admin' => 1,
                'role_id' => 4,
                'company_id' => 2,
                'region' => 'MT',
                'department_id' => 2,
                'groups' => '[]',
                'name' => 'System Admin',
                'job_title' => 'Quản trị hệ thống',
                'email' => 'admin@saobacdau.vn',
                'password' => bcrypt('Hic@1234'),
                'image' => '',
                'phone' => '0123456789',
                'options' => '[]',
                'notes' => '',
                'disable' => 0,
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'admin' => 0,
                'role_id' => 4,
                'company_id' => 10,
                'region' => 'MT',
                'department_id' => 2,
                'groups' => '["2"]',
                'name' => 'Xuan Hung Nguyen',
                'job_title' => '',
                'email' => 'hungnx@saobacdau.vn',
                'password' => bcrypt('Hic@1234'),
                'image' => '',
                'phone' => '0123456789',
                'options' => '[]',
                'notes' => '',
                'disable' => 0,
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'admin' => 0,
                'role_id' => 10,
                'company_id' => 10,
                'region' => 'MB',
                'department_id' => 2,
                'groups' => '["6", "12"]',
                'name' => 'Dang An Nam',
                'job_title' => 'Kỹ Thuật',
                'email' => 'namda@saobacdau.vn',
                'password' => bcrypt('Hic@1234'),
                'image' => '',
                'phone' => '0123456789',
                'options' => '[]',
                'notes' => '',
                'disable' => 0,
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'admin' => 0,
                'role_id' => 4,
                'company_id' => 6,
                'region' => 'MB',
                'department_id' => 2,
                'groups' => '[]',
                'name' => 'Huong Dang Minh',
                'job_title' => 'Service Development Staff',
                'email' => 'huongdm@saobacdau.vn',
                'password' => bcrypt('Hic@1234'),
                'image' => '',
                'phone' => '0898263885',
                'options' => '[]',
                'notes' => '',
                'disable' => 0,
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'admin' => 0,
                'role_id' => 10,
                'company_id' => 10,
                'region' => 'MB',
                'department_id' => 2,
                'groups' => '[]',
                'name' => 'Tinh Le Trung',
                'job_title' => 'Cloud Engineer',
                'email' => 'tinhlt@saobacdau.vn',
                'password' => bcrypt('Hic@1234'),
                'image' => '',
                'phone' => '0988649930',
                'options' => '[]',
                'notes' => '',
                'disable' => 0,
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'admin' => 0,
                'role_id' => 6,
                'company_id' => 10,
                'region' => 'MB',
                'department_id' => 2,
                'groups' => '[]',
                'name' => 'Anh Nguyen Quynh',
                'job_title' => 'Nhan vien quan ly chat luong',
                'email' => 'anhnq@saobacdau.vn',
                'password' => bcrypt('Hic@1234'),
                'image' => '',
                'phone' => '84986810493',
                'options' => '[]',
                'notes' => '',
                'disable' => 0,
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],
            [
                'admin' => 0,
                'role_id' => 6,
                'company_id' => 6,
                'region' => 'MB',
                'department_id' => 2,
                'groups' => '[]',
                'name' => 'Trang Le Thi Thao',
                'job_title' => 'Hỗ Trợ Dịch Vụ Kỹ Thuật',
                'email' => 'trangltt@saobacdau.vn',
                'password' => bcrypt('Hic@1234'),
                'image' => '',
                'phone' => '0353598004',
                'options' => '[]',
                'notes' => '',
                'disable' => 0,
                'created_at' => '2020-01-01 00:00:00',
                'updated_at' => '2020-01-01 00:00:00'
            ],

//            [
//                'admin' => 0,
//                'role_id' => 6,
//                'company_id' => 4,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '[]',
//                'name' => 'Nguyễn Kim Linh',
//                'job_title' => 'SD',
//                'email' => 'inknk2@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 6,
//                'company_id' => 8,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '[]',
//                'name' => 'Triệu Minh Quân',
//                'job_title' => 'SD',
//                'email' => 'quantm@qi.com.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//
//            [
//                'admin' => 0,
//                'role_id' => 10,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '[]',
//                'name' => 'Đoàn Hữu Hiệp',
//                'job_title' => 'Trưởng phòng tích hợp',
//                'email' => 'hiephh@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["4"]',
//                'name' => 'Trần Xuân Quý',
//                'job_title' => '',
//                'email' => 'quytx@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["4"]',
//                'name' => 'Nguyễn Ngọc Anh',
//                'job_title' => '',
//                'email' => 'anhnn1@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//
//            [
//                'admin' => 0,
//                'role_id' => 10,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["8"]',
//                'name' => 'Nguyễn Văn Khoản',
//                'job_title' => 'Trưởng Nhóm hạ tầng',
//                'email' => 'khoannv@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["8"]',
//                'name' => 'Nguyễn Văn Tuấn',
//                'job_title' => 'Kỹ sư hạ tầng',
//                'email' => 'tuannv@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["8"]',
//                'name' => 'Nguyễn Văn Tuyền',
//                'job_title' => 'Kỹ sư hạ tầng',
//                'email' => 'tuyennv@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//
//            [
//                'admin' => 0,
//                'role_id' => 10,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["10"]',
//                'name' => 'Phạm Hoàng Đạt',
//                'job_title' => 'Trưởng nhóm triển khai bảo mật',
//                'email' => 'datph@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["10"]',
//                'name' => 'Nguyễn Hải Đăng',
//                'job_title' => 'Kĩ sư triển khai',
//                'email' => 'dangnh@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["10"]',
//                'name' => 'Hà Văn Hùng',
//                'job_title' => 'Kĩ sư triển khai',
//                'email' => 'hunghv@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["10"]',
//                'name' => 'Đặng Tiến Tùng',
//                'job_title' => 'Kĩ sư triển khai',
//                'email' => 'tungdt@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["10"]',
//                'name' => 'Nguyễn Đình Nam',
//                'job_title' => 'Kĩ sư triển khai',
//                'email' => 'namnd@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//
//            [
//                'admin' => 0,
//                'role_id' => 10,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["6"]',
//                'name' => 'Phạm Văn Thành',
//                'job_title' => 'Kĩ sư triển khai',
//                'email' => 'thanhpv@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["6"]',
//                'name' => 'Nguyễn Mạnh Tài',
//                'job_title' => 'Kĩ sư triển khai',
//                'email' => 'tainm@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["6"]',
//                'name' => 'Chu Mạnh Tùng',
//                'job_title' => 'Kĩ sư triển khai',
//                'email' => 'tungcm@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["6"]',
//                'name' => 'Nguyễn Tiến Dũng',
//                'job_title' => 'Kĩ sư triển khai',
//                'email' => 'dungnt3@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 10,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["6"]',
//                'name' => 'Nguyễn Đức Du',
//                'job_title' => 'Kĩ sư giải pháp',
//                'email' => 'dunt@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//
//            [
//                'admin' => 0,
//                'role_id' => 10,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["12"]',
//                'name' => 'Phạm Quốc Cường',
//                'job_title' => 'Trưởng nhóm triển khai System',
//                'email' => 'cuongpq@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["12"]',
//                'name' => 'Đặng Thanh Bình',
//                'job_title' => 'Kỹ sư triển khai',
//                'email' => 'binhdt@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 6,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["12"]',
//                'name' => 'Nguyễn Văn Công',
//                'job_title' => '',
//                'email' => 'congnv@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 4,
//                'region' => 'MN',
//                'department_id' => 2,
//                'groups' => '["6"]',
//                'name' => 'Phan Hoàng Anh Khôi',
//                'job_title' => '',
//                'email' => 'khoipha@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 10,
//                'company_id' => 4,
//                'region' => 'MN',
//                'department_id' => 2,
//                'groups' => '["6"]',
//                'name' => 'Đặng Đình Đức',
//                'job_title' => '',
//                'email' => 'ducdd@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 4,
//                'region' => 'MN',
//                'department_id' => 2,
//                'groups' => '["12"]',
//                'name' => 'Nguyễn Trí Viễn',
//                'job_title' => '',
//                'email' => 'viennt@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 4,
//                'region' => 'MN',
//                'department_id' => 2,
//                'groups' => '["16"]',
//                'name' => 'Nguyễn Hòa Thọ',
//                'job_title' => '',
//                'email' => 'thonh@saobacdau.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 8,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["6"]',
//                'name' => 'Trương Đoàn Trọng Phúc',
//                'job_title' => '',
//                'email' => 'phuctdt@qi.com.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ],
//            [
//                'admin' => 0,
//                'role_id' => 8,
//                'company_id' => 8,
//                'region' => 'MB',
//                'department_id' => 2,
//                'groups' => '["6"]',
//                'name' => 'Đỗ Duy Tuấn',
//                'job_title' => '',
//                'email' => 'tuandt@qi.com.vn',
//                'password' => bcrypt('Hic@1234'),
//                'image' => '',
//                'phone' => '',
//                'options' => '[]',
//                'notes' => '',
//                'disable' => 0,
//                'created_at' => '2020-01-01 00:00:00',
//                'updated_at' => '2020-01-01 00:00:00'
//            ]
        ]);

        DB::table('roles')->insert([
            ['type' => 'Nomanl', 'level' => 1, 'name' => 'Only view', 'capabilities' => '[]'],
            ['type' => 'Nomanl', 'level' => 100, 'name' => 'Manager', 'capabilities' => '["view-request","edit-request","delete-request","reply-request","view-problem","edit-problem","delete-problem","reply-problem","view-solution","edit-solution","delete-solution","view-sla","edit-sla","delete-sla","view-priority","edit-priority","delete-priority","view-company","edit-company","delete-company","view-category","edit-category","delete-category","view-user","edit-user","delete-user","view-group","edit-group","upload","view-customer","edit-customer","delete-customer","view-role","edit-role","view-changes","view-email-template","edit-email-template","view-email-history","view-report"]'],
            ['type' => 'ServiceDesk', 'level' => 3, 'name' => 'Service desk', 'capabilities' => '["view-request","edit-request","delete-request","reply-request","view-problem","edit-problem","delete-problem","reply-problem","view-solution","edit-solution","delete-solution","view-sla","edit-sla","delete-sla","view-priority","edit-priority","delete-priority","view-company","edit-company","delete-company","view-category","edit-category","delete-category","view-user","edit-user","delete-user","view-group","edit-group","upload","view-customer","edit-customer","delete-customer","view-role","edit-role","view-changes","view-email-template","edit-email-template","view-email-history","view-report"]'],
            ['type' => 'TechnicianL1', 'level' => 4, 'name' => 'Technical L1', 'capabilities' => '["view-request","edit-request","delete-request","reply-request","view-problem","edit-problem","delete-problem","reply-problem","view-solution","edit-solution","delete-solution","view-sla","edit-sla","delete-sla","view-priority","edit-priority","delete-priority","view-company","edit-company","delete-company","view-category","edit-category","delete-category","view-user","edit-user","delete-user","view-group","edit-group","upload","view-customer","edit-customer","delete-customer","view-role","edit-role","view-changes","view-email-template","edit-email-template","view-email-history","view-report"]'],
            ['type' => 'TechnicianL2', 'level' => 5, 'name' => 'Technical L2', 'capabilities' => '["view-request","edit-request","delete-request","reply-request","view-problem","edit-problem","delete-problem","reply-problem","view-solution","edit-solution","delete-solution","view-sla","edit-sla","delete-sla","view-priority","edit-priority","delete-priority","view-company","edit-company","delete-company","view-category","edit-category","delete-category","view-user","edit-user","delete-user","view-group","edit-group","upload","view-customer","edit-customer","delete-customer","view-role","edit-role","view-changes","view-email-template","edit-email-template","view-email-history","view-report"]'],
        ]);

        DB::table('sla')->insert([
            [
                'priority_id' => 0,
                'name' => 'Unknown',
                'description' => 'Chưa phân loại',
                'max_response_time' => 0,
                'max_resolve_time' => 0,
                'enable_levels' => '[3]',
                'time_to_l2' => 0,
                'time_to_l3' => 0,
                'time_to_l4' => 0,
                'response_data' => '[]',
                'l2_data' => '[]',
                'l3_data' => '[]',
                'l4_data' => '[]'
            ],
            [
                'priority_id' => 4,
                'name' => '2h',
                'description' => '',
                'max_response_time' => 20,
                'max_resolve_time' => 120,
                'enable_levels' => '[3]',
                'time_to_l2' => 0,
                'time_to_l3' => 0,
                'time_to_l4' => 0,
                'response_data' => '[]',
                'l2_data' => '[]',
                'l3_data' => '[]',
                'l4_data' => '[]'
            ],
            [
                'priority_id' => 4,
                'name' => '3h',
                'description' => '',
                'max_response_time' => 20,
                'max_resolve_time' => 180,
                'enable_levels' => '[3]',
                'time_to_l2' => 0,
                'time_to_l3' => 0,
                'time_to_l4' => 0,
                'response_data' => '[]',
                'l2_data' => '[]',
                'l3_data' => '[]',
                'l4_data' => '[]'
            ],
            [
                'priority_id' => 4,
                'name' => '4h',
                'description' => '',
                'max_response_time' => 20,
                'max_resolve_time' => 240,
                'enable_levels' => '[3]',
                'time_to_l2' => 0,
                'time_to_l3' => 0,
                'time_to_l4' => 0,
                'response_data' => '[]',
                'l2_data' => '[]',
                'l3_data' => '[]',
                'l4_data' => '[]'
            ],
            [
                'priority_id' => 6,
                'name' => '6h',
                'description' => '',
                'max_response_time' => 20,
                'max_resolve_time' => 360,
                'enable_levels' => '[2,3]',
                'time_to_l2' => 60,
                'time_to_l3' => 120,
                'time_to_l4' => 0,
                'response_data' => '[]',
                'l2_data' => '[]',
                'l3_data' => '[]',
                'l4_data' => '[]'
            ],
            [
                'priority_id' => 6,
                'name' => '8h',
                'description' => '',
                'max_response_time' => 20,
                'max_resolve_time' => 480,
                'enable_levels' => '[2,3]',
                'time_to_l2' => 90,
                'time_to_l3' => 180,
                'time_to_l4' => 0,
                'response_data' => '[]',
                'l2_data' => '[]',
                'l3_data' => '[]',
                'l4_data' => '[]'
            ],
            [
                'priority_id' => 6,
                'name' => '24h',
                'description' => '',
                'max_response_time' => 20,
                'max_resolve_time' => 1440,
                'enable_levels' => '[2,3]',
                'time_to_l2' => 240,
                'time_to_l3' => 480,
                'time_to_l4' => 0,
                'response_data' => '{"202105040249295332":{"level":1,"time_type":"After","difference_time":"15","action":"Notification","email_type":"ResponseReminderEmail","role_type":"TechnicianL1","cc":["hungnx@saobacdau.vn"]}}',
                'l2_data' => '{"202104191510385932":{"level":2,"time_type":"Equal","difference_time":0,"action":"Notification","email_type":"EscalateEmail","role_type":"TechnicianL2","cc":["hungnx@saobacdau.vn"]},"202104191518065952":{"level":2,"time_type":"Before","difference_time":"115","action":"Notification","email_type":"ResponseLateEmail","role_type":"TechnicianL2","cc":["hungnx@saobacdau.vn"]}}',
                'l3_data' => '{"202104191511105266":{"level":3,"time_type":"Equal","difference_time":0,"action":"Notification","email_type":"EscalateEmail","role_type":"TechnicianL3","cc":["hungnx@saobacdau.vn"]},"202104191514105289":{"level":3,"time_type":"After","difference_time":"970","action":"Notification","email_type":"ResolveLateEmail","role_type":"TechnicianL3","cc":["hungnx@saobacdau.vn"]}}',
                'l4_data' => '[]'
            ],
            [
                'priority_id' => 8,
                'name' => '72h',
                'description' => '',
                'max_response_time' => 60,
                'max_resolve_time' => 4320,
                'enable_levels' => '[2,3]',
                'time_to_l2' => 1680,
                'time_to_l3' => 3210,
                'time_to_l4' => 0,
                'response_data' => '[]',
                'l2_data' => '[]',
                'l3_data' => '[]',
                'l4_data' => '[]'
            ],
            [
                'priority_id' => 10,
                'name' => '108h',
                'description' => '',
                'max_response_time' => 20,
                'max_resolve_time' => 6480,
                'enable_levels' => '[2,3]',
                'time_to_l2' => 2880,
                'time_to_l3' => 5040,
                'time_to_l4' => 0,
                'response_data' => '[]',
                'l2_data' => '[]',
                'l3_data' => '[]',
                'l4_data' => '[]'
            ],
        ]);

        DB::table('priorities')->insert([
            [
                'name' => 'Undefined',
                'description' => 'Chưa phân loại',
                'level' => 0
            ],
            [
                'name' => 'P1',
                'description' => '',
                'level' => 4
            ],
            [
                'name' => 'P2',
                'description' => '',
                'level' => 3
            ],
            [
                'name' => 'P3',
                'description' => '',
                'level' => 2
            ],
            [
                'name' => 'P4',
                'description' => '',
                'level' => 1
            ],
        ]);

        DB::table('requests')->insert([
            [
                'uuid' => Str::uuid()->toString(),
                'rel_id' => '',
                'type' => 'Incident',
                'mode' => 'WebForm',
                'site' => 'MB',
                'so' => '401696',
                'tac' => '',
                'flag' => 0,
                'technician_id' => 4,
                'client_id' => 0,
                'invoice_id' => 0,
                'category_id' => 2,
                'company_id' => 2,
                'group_id' => 2,
                'client_email' => 'hungnx92@gmail.com',
                'request_by' => 2,
                'sla_id' => 2,
                'priority_id' => 2,
                'status' => 'Draft',
                'name' => 'Con sóc nhỏ trên cành cây cao',
                'content' => 'Con sóc nào, Con sóc nào, Con sóc nào',
                'attachments' => '[]',
                'hidden' => 0,
                'created_at' => '2021-01-26 05:03:39',
                'updated_at' => '2021-01-26 05:03:39'
            ],
            [
                'uuid' => Str::uuid()->toString(),
                'rel_id' => '',
                'type' => 'Incident',
                'mode' => 'EMail',
                'site' => 'MB',
                'so' => '401696',
                'tac' => '',
                'flag' => 0,
                'technician_id' => 4,
                'client_id' => 0,
                'invoice_id' => 0,
                'category_id' => 2,
                'company_id' => 2,
                'group_id' => 2,
                'client_email' => 'hungnx92@gmail.com',
                'request_by' => 2,
                'sla_id' => 2,
                'priority_id' => 2,
                'status' => 'Draft',
                'name' => 'Cái này phải làm sao, làm sao',
                'content' => 'Chán nhỉ, Chán nhỉ, Chán nhỉ',
                'attachments' => '[]',
                'hidden' => 0,
                'created_at' => '2021-01-26 05:03:39',
                'updated_at' => '2021-01-26 05:03:39'
            ]
        ]);

        DB::table('problems')->insert([
            [
                'site' => 'MB',
                'flag' => 0,
                'requests' => '[]',
                'solutions' => '[]',
                'company_id' => 2,
                'technician_id' => 4,
                'category_id' => 2,
                'group_id' => 2,
                'request_by' => 2,
                'sla_id' => 2,
                'priority_id' => 2,
                'status' => 'Open',
                'name' => 'Con sóc con bờ rô bờ lem',
                'content' => 'Con sóc con bờ rô bờ lem này',
                'attachments' => '[]',
                'hidden' => 0,
                'created_at' => '2021-01-26 05:03:39',
                'updated_at' => '2021-01-26 05:03:39'
            ]
        ]);

        DB::table('solutions')->insert([
            [
                'user_id' => 2,
                'category_id' => 2,
                'flag' => 0,
                'name' => 'Cách bắt con sóc trên cây nhanh nhất',
                'content' => 'Cách bắt con sóc trên cây nhanh nhất này',
                'created_at' => '2021-01-26 05:03:39',
                'updated_at' => '2021-01-26 05:03:39'
            ],
            [
                'user_id' => 2,
                'category_id' => 2,
                'flag' => 0,
                'name' => 'Làm sao để sửa máy tính khi bị cháy',
                'content' => 'Làm sao để sửa máy tính khi bị cháy',
                'created_at' => '2021-01-26 05:03:39',
                'updated_at' => '2021-01-26 05:03:39'
            ]
        ]);

        DB::table('clients')->insert([
            [
                'type' => 'Normal',
                'email' => 'hungnx92@gmail.com',
                'name' => 'Khách Rất Xộp',
                'phone' => '0123456456',
                'postcode' => '100000',
                'tax_code' => '',
                'identification_number' => '',
                'country' => 'VN',
                'city' => 'Hà Nội',
                'state' => 'Hà Đông',
                'address' => '22 Ngô Quyền, Hà Đông, Hà Nội',
                'notes' => 'Khách mất dạy',
                'disable' => 0
            ]
        ]);

        DB::table('departments')->insert([
            ['name' => 'ADM'],
            ['name' => 'ACC.hn'],
            ['name' => 'ACC.hcm']
        ]);

        DB::table('status')->insert([
            [
                'status_name' => 'Open',
                'sort' => 0
            ],
            [
                'status_name' => 'ReOpen',
                'sort' => 1
            ],
            [
                'status_name' => 'CustomerReply',
                'sort' => 2
            ],
            [

                'status_name' => 'Answered',
                'sort' => 3
            ],
            [
                'status_name' => 'Pending',
                'sort' => 4
            ],
            [
                'status_name' => 'Closed',
                'sort' => 5
            ],
            [
                'status_name' => 'Cancelled',
                'sort' => 6
            ]
        ]);

        DB::table('configurations')->insert([
            [
                'key' => 'office_hours',
                'data_type' => 'Json',
                'data' => '["08:00-17:00"]'
            ],
            [
                'key' => 'workdays',
                'data_type' => 'Json',
                'data' => '["1","2","3","4","5"]'
            ],
            [
                'key' => 'weekday_auto_report',
                'data_type' => 'Text',
                'data' => 5
            ],
            [
                'key' => 'time_auto_report',
                'data_type' => 'Text',
                'data' => '08:00'
            ],
            [
                'key' => 'auto_report_to_emails',
                'data_type' => 'Json',
                'data' => '["hungnx@saobacdau.vn"]'
            ]

        ]);

        DB::table('duty_lists')->insert([
            [
                'data' => '[]',
            ]
        ]);

        DB::table('email_templates')->insert([
            [
                'type' => 'Signature',
                'name' => 'Mẫu chữ ký',
                'subject' => 'Email signature',
                'content' => '<p><span>Thanks And Best Regards,</span>' .
                    '</p>' .
                    '<p><span>SaoBacDau ServiceDesk </span>' .
                    '</p>' .
                    '<p><span>----------------------------------------------------------------------------</span>' .
                    '</p>' .
                    '<p><b><span>SAO BAC DAU TECHNOLOGIES CORPORATION</span></b>' .
                    '</p>' .
                    '<p><span>Tel: (+84.28) 3770 0968 | Fax: (+84.28) 3770 0969</span>' .
                    '</p>' .
                    '<p><span>24/7 Toll free hotline: 1800 1780 | Email: <a href="mailto:servicedesk@saobacdau.vn" target="_blank" style="color: rgb(138, 184, 255);"><span style="color: rgb(222, 152, 255);">servicedesk@saobacdau.vn</span></a></span>' .
                    '</p>' .
                    '<p><span>Head office: Block U.14b - 16a, Road 22, Tan Thuan EPZ, Tan Thuan Dong Ward, Dist.7, HCM</span>' .
                    '</p>' .
                    '<p><span>Hanoi Branch: 3rd Fl., CT1A-B, VOV Me Tri Plaza, Luong The Vinh Road, Me Tri Ward, Nam Tu Liem Dist., HN</span>' .
                    '</p>' .
                    '<p style="margin-bottom:3.0pt"><span>Danang Branch: Suite E - 11st Floor, 02 Quang Trung St., Hai Chau Dist., DN</span>' .
                    '</p>' .
                    '<p><span><img src="' . env('APP_URL') . '/images/sbdm.png" width="627" height="132" id="x__x0000_i1025" style="width: 6.5312in; height: 1.375in; cursor: pointer;" crossorigin="use-credentials"></span>' .
                    '</p>'
            ],
            [
                'type' => 'EmailReference',
                'name' => 'Mẫu email tự động gửi Reference number cho khách hàng',
                'subject' => 'Email reference number [[reference_id]]',
                'content' => '<p><b><span>Dear Dear Customer, </span></b></p>' .
                    '<p><span>Email reference number: [[reference_id]].</span></p>' .
                    '<p><span>We\'ve received your email for help and we will get back to you shortly.</span></p>'
            ],
            [
                'type' => 'OpenTicket',
                'name' => 'Mẫu email mở ticket',
                'subject' => 'SBD##[[ticket_id]]## [[ticket_name]]',
                'content' => '<p><b><span>Dear Anh/Chị [[customer_name]], </span></b></p>' .
                    '<p><span>SaoBacDau Servicedesk đã nhận được yêu cầu của Anh/Chị [[customer_name]], số yêu cầu: SBD##[[ticket_id]]##<br>Kỹ sư sẽ liên hệ Anh/Chị [[customer_name]] để kiểm tra và hỗ trợ ạ. </span></p>' .
                    '<p style="margin-top: 20px"><b><span>Dear Anh/Chị [[technician_name]], </span></b></p>' .
                    '<p><span>Anh/Chị [[technician_name]] nhận case này và xử lý giúp SD nhé. </span></p>' .
                    '<p style="margin-top: 20px"><b><span>Dear Anh/Chị [[sd_name]],</span></b></p>' .
                    '<p><span>Anh/chị [[sd_name]] follow tiếp giúp SD nhé. </span></p>'
            ],
            [
                'type' => 'CloseTicket',
                'name' => 'Mẫu email đóng ticket và khảo sát đánh giá chất lượng dịch vụ',
                'subject' => 'SBD##[[ticket_id]]## Khảo sát đánh giá chất lượng dịch vụ',
                'content' => '<p><b><span>Dear Anh/Chị [[customer_name]], </span></b></p>' .
                    '<p><span style="font-size: 12pt">Vừa qua kỹ sư SBĐ đã thực hiện việc hỗ trợ …KHÁCH HÀNG…thực hiện/xử lý …CÔNG VIỆC HỖ TRỢ KH…, số ticket: SBD##[[ticket_id]]##.</span></p>' .
                    '<p><span>Bằng email này, Công Ty Cồ Phần Công Nghệ Sao Bắc Đẩu rất mong nhận được ý kiến phản hồi
của Anh về chất lượng công việc hỗ trợ kỹ thuật vừa qua nhằm giúp SBĐ nâng cao hơn nữa chất
lượng dịch vụ và phục vụ Quý khách hàng ngày càng tốt hơn!</span></p>' .
                    '<p><span>Anh/Chị [[customer_name]] vui lòng giúp đánh giá về chất lượng công việc “[[ticket_name]]” với các
tiêu chí sau nhé</span></p>' .
                    '<p style="margin-top: 30px; margin-bottom: 30px"><a href="[[report_url]]" style="background: #FFAC51; color: white; padding: 10px 20px" target="_blank">Vui lòng bấm vào liên kết đánh giá này</a></p>' .
                    '<p><span>Chân thành Cám ơn Anh/Chị đã hỗ trợ và tạo điều kiện để các Kỹ sư hoàn thành nhiệm vụ của
mình và mong nhận được ý kiến đóng góp của Anh/Chị.</span></p>' .
                    '<p><span style="font-size: 12pt">Trân trọng!</span></p>'
            ],
            [
                'type' => 'NewRequestEMailNotify',
                'name' => 'Mẫu email thông báo có yêu cầu mới tới Điều phối viên',
                'subject' => 'New Request #[[request_id]]',
                'content' =>
                    '<p><span>Có yêu cầu mới từ khách hàng: <a href="[[request_url]]">Request #[[request_id]]</a>.</span></p>'
            ],
            [
                'type' => 'TicketNotify',
                'name' => 'Mẫu email thông báo xử lý Ticket',
                'subject' => 'SBD##[[ticket_id]]##',
                'content' =>
                    '<p><span>Bạn được gán với yêu cầu: <a href="[[ticket_url]]">SBD##[[ticket_id]]##</a>.</span></p>'
            ],
            [
                'type' => 'ProblemNotify',
                'name' => 'Mẫu email thông báo xử lý Problem',
                'subject' => 'Problem #[[problem_id]]',
                'content' =>
                    '<p><span>Bạn được gán với yêu cầu: <a href="[[problem_url]]">Problem #[[ticket_id]]</a>.</span></p>'
            ],
            [
                'type' => 'ReplyTicketEmail',
                'name' => 'Mẫu email trả lời',
                'subject' => 'SBD##[[ticket_id]]## [[ticket_name]]',
                'content' => '<p><b><span>Dear Anh/Chị [[customer_name]], </span></b></p>' .
                    '<p>[[reply_content]]</p>'
            ],
            [
                'type' => 'CloseTicketNotifyToAdmin',
                'name' => 'Mẫu email thông báo xử lý Ticket thành công cho SD',
                'subject' => 'SBD##[[ticket_id]]## Successfully',
                'content' =>
                    '<p><span>Ticket: <a href="[[ticket_url]]">SBD##[[ticket_id]]##</a>. đã được xử lý thành công</span></p>'
            ],
            [
                'type' => 'OpenTicketNotifyToAdmin',
                'name' => 'Mẫu email thông bá Ticket được tạo cho SD',
                'subject' => 'SBD##[[ticket_id]]## Opened',
                'content' =>
                    '<p><span>Ticket: <a href="[[ticket_url]]">SBD##[[ticket_id]]##</a>. đã được tạo</span></p>'
            ],
            [
                'type' => 'PeriodicReport',
                'name' => 'Mẫu email gửi báo các định kỳ',
                'subject' => 'SD Auto Report',
                'content' =>
                    '<p><span>Dưới đây là báo cáo từ [[start_date]] đến [[end_date]]: <br><a href="[[file_link]]">Tải báo cáo</a>. đã được tạo</span></p>'
            ],
            [
                'type' => 'AutoContent',
                'name' => 'Mẫu Mail Nội dung tự động',
                'subject' => '[[mail_subject]]',
                'content' => '[[mail_content]]'
            ],
            [
                'type' => 'EscalateEmail',
                'name' => 'Mẫu email tăng level kỹ sư',
                'subject' => 'SBD##[[ticket_id]]## được chuyển cấp kỹ thuật',
                'content' => '<p><b><span>Dear Mr [[technician_name]], </span></b></p>' .
                    '<p><span>The request SBD##[[ticket_id]]## is getting overdue at  [[ticket_due_by_date]].</span></p>' .
                    '<p><span>And then, the request will escalate to you - Next Level Technician at [[ticket_due_by_date]] for next action.</span></p>' .
                    '<p><span>Please kindly help to check and support!</span></p>' .
                    '<p><span>Requester : [[sd_name]]</span></p>' .
                    '<p><span>Ticket number: [[ticket_id]]</span></p>' .
                    '<p><span>Title : [[ticket_name]]</span></p>' .
                    '<p><span>Click for details : [[ticket_url]]</span></p>'
            ],
            [
                'type' => 'BeforeEscalateEmail',
                'name' => 'Mẫu Mail trước khi tăng level kỹ sư',
                'subject' => 'SBD##[[ticket_id]]## sắp được chuyển cấp kỹ thuật',
                'content' => '<p><span>Request SBD##[[ticket_id]]## sắp được tăng cấp độ, kỹ sư [[technician_name]] hãy nhanh chóng xử lý.</span></p>'
            ],
            [
                'type' => 'AfterEscalateEmail',
                'name' => 'Mẫu Mail sau khi tăng level kỹ sư',
                'subject' => 'SBD##[[ticket_id]]## đã được chuyển cấp kỹ thuật',
                'content' => '<p><span>Request SBD##[[ticket_id]]## Đã được tăng cấp độ, yêu cầu đã được gán cho kỹ sư [[technician_name]] tiếp tục xử lý.</span></p>'
            ],
            [
                'type' => 'ResponseReminderEmail',
                'name' => 'Mẫu Mail nhắc nhở sắp hết hạn phản hồi',
                'subject' => 'SBD##[[ticket_id]]## sắp hết hạn phản hồi',
                'content' => '<p><span>Request SBD##[[ticket_id]]## sắp hết hạn phản hồi, kỹ sư [[technician_name]] hãy nhanh chóng phản hồi khách hàng.</span></p>'
            ],
            [
                'type' => 'ResponseLateEmail',
                'name' => 'Mẫu Mail thông báo quá hạn phản hồi',
                'subject' => 'SBD##[[ticket_id]]## đã quá hạn phản hồi',
                'content' => '<p><span>Request SBD##[[ticket_id]]## đã quá hạn phản hồi, kỹ sư [[technician_name]] hãy nhanh chóng phản hồi khách hàng.</span></p>'
            ],
            [
                'type' => 'ResolveReminderEmail',
                'name' => 'Mẫu Mail thông báo sắp hết hạn xử lý',
                'subject' => 'SBD##[[ticket_id]]## sắp hết hạn xử lý',
                'content' => '<p><span>Request SBD##[[ticket_id]]## sắp hết hạn xử lý, kỹ sư [[technician_name]] hãy nhanh chóng xử lý yêu cầu của khách hàng.</span></p>'
            ],
            [
                'type' => 'ResolveLateEmail',
                'name' => 'Mẫu Mail thông báo đã quá hạn xử lý',
                'subject' => 'SBD##[[ticket_id]]## đã quá hạn xử lý',
                'content' => '<p><span>Request SBD##[[ticket_id]]## đã quá hạn xử lý, kỹ sư [[technician_name]] hãy nhanh chóng xử lý yêu cầu của khách hàng.</span></p>'
            ],

            [
                'type' => 'NewReplyNotifyEmail',
                'name' => 'Mẫu Mail thông báo có phản hồi mới',
                'subject' => 'SBD##[[ticket_id]]## có phản hồi mới',
                'content' => '<p><span>Có phản hồi mới tới Request <a href="[[ticket_url]]">SBD##[[ticket_id]]##</a>.</span></p>'
            ],
        ]);
    }
}
