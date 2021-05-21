<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // foreach (['investor','company'] as $account){
        //     User::create([
        //         'user_name' => $account,
        //         'full_name' => $account,
        //         'password' => Hash::make('password'),
        //         'date_of_birth' => Carbon::today(),
        //         'email' => $account.'@mail.com',
        //         'phone_number' => '01236579'.rand(0,1000),
        //     ]);
        // }

        // foreach (['admin'] as $account){
        //     Admin::create([
        //         'user_name' => $account,
        //         'full_name' => $account,
        //         'password' => Hash::make('password'),
        //         'email' => $account.'@mail.com',
        //         'phone_number' => '01236579'.rand(0,1000),
        //     ]);
        // }

        // DB::table('roles')->insert(
        //     [
        //         'id' => 1,
        //         'name' => 'Admin',
        //         'guard_name' => 'admin',
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'Member',
        //         'guard_name' => 'member',
        //     ]
        // );

        // DB::table('permissions')->insert(
        //     [
        //         'id' => 1,
        //         'name' => 'Danh sách admin',
        //         'guard_name' => 'manage-admin.index',
        //     ],
        //     [
        //         'id' => 2,
        //         'name' => 'Thêm admin',
        //         'guard_name' => 'manage-admin.store',
        //     ],
        //     [
        //         'id' => 3,
        //         'name' => 'Sửa admin',
        //         'guard_name' => 'manage-admin.update',
        //     ],
        //     [
        //         'id' => 4,
        //         'name' => 'Xóa admin',
        //         'guard_name' => 'manage-admin.destroy',
        //     ],
        //     [
        //         'id' => 5,
        //         'name' => 'Xem admin',
        //         'guard_name' => 'manage-admin.show',
        //     ],
        //     [
        //         'id' => 6,
        //         'name' => 'Cập nhật ảnh admin',
        //         'guard_name' => 'manage-admin.upload-image',
        //     ],
        // );

        // DB::table('role_has_permissions')->insert(
        //     [
        //         'permission_id' => 1,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'permission_id' => 2,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'permission_id' => 3,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'permission_id' => 4,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'permission_id' => 5,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'permission_id' => 6,
        //         'role_id' => 1,
        //     ],
        //     [
        //         'permission_id' => 5,
        //         'role_id' => 2,
        //     ],
        //     [
        //         'permission_id' => 6,
        //         'role_id' => 2,
        //     ],
        // );
    }
}
