<?php

namespace Database\Seeders;
use Carbon\Carbon;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Jim',
                'last_name' => 'Bai',
                'password' => Hash::make('taiho'),
                'email' => 'jimbai850@gmail.com',
            ],
            [
                'first_name' => 'XX',
                'last_name' => 'YY',
                'password' => Hash::make('taiho'),
                'email' => 'abc@qq.com',
            ]
        ];

        foreach ($users as $user) {
            $user['register_at'] = Carbon::now();
            User::create($user);
        }
    }
}
