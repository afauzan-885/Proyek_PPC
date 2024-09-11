<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // User 1: Tester Admin
        User::create([
            'name' => 'Tester Admin',
            'email' => 'testeradmin@tester.com',
            'password' => Hash::make('123456789'), // Hash password untuk keamanan
            'role' => 'admin',
            'is_active' => true, // Akun admin langsung aktif
        ]);

        // User 2: Tester
        User::create([
            'name' => 'Tester',
            'email' => 'tester@tester.com',
            'password' => Hash::make('123456789'),
            'role' => 'member',
            'is_active' => false, // Akun member menunggu aktivasi
        ]);

        // User 3: Bebas (contoh: Manager)
        User::create([
            'name' => 'Manager',
            'email' => 'manager@tester.com',
            'password' => Hash::make('manager123'),
            'role' => 'member',
            'is_active' => true, 
        ]);
    }
}