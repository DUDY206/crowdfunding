<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['investor','company'] as $account){
            User::create([
                'user_name' => $account,
                'full_name' => $account,
                'password' => Hash::make('password'),
                'date_of_birth' => Carbon::today(),
                'email' => $account.'@mail.com',
                'phone_number' => '01236579'.rand(0,1000),
            ]);
        }

        foreach (['admin'] as $account){
            Admin::create([
                'user_name' => $account,
                'full_name' => $account,
                'password' => Hash::make('password'),
                'email' => $account.'@mail.com',
                'phone_number' => '01236579'.rand(0,1000),
            ]);
        }
    }
}
