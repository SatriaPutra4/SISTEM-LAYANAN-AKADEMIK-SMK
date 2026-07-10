<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Hash;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure admin user exists for all tests
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@smk.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }
    }
}
