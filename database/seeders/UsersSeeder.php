<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'name' => 'Manager User',
                'username' => 'manager',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ],
            [
                'name' => 'Budi Santoso',
                'username' => 'operator1',
                'password' => Hash::make('password'),
                'role' => 'operator',
            ],
            [
                'name' => 'Andi Wijaya',
                'username' => 'operator2',
                'password' => Hash::make('password'),
                'role' => 'operator',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'username' => 'operator3',
                'password' => Hash::make('password'),
                'role' => 'operator',
            ],
            [
                'name' => 'Dedi Kurniawan',
                'username' => 'mekanik1',
                'password' => Hash::make('password'),
                'role' => 'mekanik',
            ],
            [
                'name' => 'Agus Setiawan',
                'username' => 'mekanik2',
                'password' => Hash::make('password'),
                'role' => 'mekanik',
            ],
            [
                'name' => 'Rizki Pratama',
                'username' => 'mekanik3',
                'password' => Hash::make('password'),
                'role' => 'mekanik',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
