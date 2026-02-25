<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@undangan.com'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('admin'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@undangan.com'],
            [
                'name'              => 'User Demo',
                'password'          => Hash::make('user'),
                'role'              => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}
