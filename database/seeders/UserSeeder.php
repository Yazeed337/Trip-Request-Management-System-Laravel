<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'مسؤول النظام',
            'email' => 'admin@sawwah.com',
            'password' => Hash::make('admin123'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Regular User
        User::create([
            'name' => 'أحمد محمد',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        // Additional test users
        User::create([
            'name' => 'فاطمة عبدالله',
            'email' => 'fatima@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'خالد سعيد',
            'email' => 'khalid@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'سارة عبدالرحمن',
            'email' => 'sarah@example.com',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'email_verified_at' => now(),
        ]);
    }
}