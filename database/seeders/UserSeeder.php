<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // For generating random tokens
use Illuminate\Support\Facades\Hash; // For hashing passwords

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('lms_g41_users')->insert([
            [
                'name' => 'Test User 1',
                'email' => 'test1@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'), // Securely hashed password
                'role' => 'procurement', // Or any other role you need
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Add more test users as needed
        ]);
    }
}
