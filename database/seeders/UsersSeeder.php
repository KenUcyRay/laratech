<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin User',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ],
            [
                'name' => 'Operator User',
                'username' => 'operator',
                'password' => Hash::make('password'),
                'role' => 'operator',
            ],
            [
                'name' => 'Mechanic User',
                'username' => 'mechanic',
                'password' => Hash::make('password'),
                'role' => 'mechanic',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
