<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            [
                'name'=>'mohammad',
                'email'=>'mohammad@gmail.com',
                'role_id'=>1,
                'password'=>Hash::make('password')
            ],
            [
                'name'=>'admin',
                'email'=>'admin@gmail.com',
                'role_id'=>1,
                'password'=>Hash::make('password')
            ],
        ];

        User::insert($users);
    }
}
