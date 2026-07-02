<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InitialUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@smk.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );
    }
}
