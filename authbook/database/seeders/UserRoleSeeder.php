<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name'     => 'Admin User',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // Akun Staff
        User::updateOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name'     => 'Staff User',
                'password' => Hash::make('password'),
                'role'     => 'staff',
            ]
        );

        // Akun Viewer
        User::updateOrCreate(
            ['email' => 'viewer@example.com'],
            [
                'name'     => 'Viewer User',
                'password' => Hash::make('password'),
                'role'     => 'viewer',
            ]
        );
    }
}