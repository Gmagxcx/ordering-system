<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Admin
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'access' => 'admin', 
        ]);

        // Employee 
        User::create([
            'first_name' => 'Employee',
            'last_name' => 'User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'access' => 'employee', 
        ]);

        // Regular
        User::create([
            'first_name' => 'Gmag',
            'last_name' => 'ooo',
            'email' => 'magooo.xyz@gmail.com',
            'password' => Hash::make('password'),
            'access' => 'user', 
        ]);
    }
}
