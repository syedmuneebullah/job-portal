<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@swiftai.com',
            'password' => Hash::make('password123'),
            'user_type' => 'admin',
            'status' => 'active',
        ]);

        
    }
}
