<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@office.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
            
        ]);

        // Regular users
        User::factory(10)->create();
    }
}