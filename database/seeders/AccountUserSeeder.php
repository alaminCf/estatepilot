<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@londonabd.com',
            'phone' => '01712345678',
            'password' => Hash::make('@Admin#2026'),
            'role' => 'admin',
            'permissions' => array_keys(User::PERMISSIONS),
            'email_verified_at' => now(),
        ]);

        // Create Agent
        User::create([
            'name' => 'Agent User',
            'email' => 'agent@londonabd.com',
            'phone' => '01812345678',
            'password' => Hash::make('password'),
            'role' => 'agent',
            'commission_rate' => 10.0,
            'referral_code' => 'test',
            'email_verified_at' => now(),
        ]);

        // Create Regular User/Customer
        User::create([
            'name' => 'Customer User',
            'email' => 'user@londonabd.com',
            'phone' => '01912345678',
            'password' => Hash::make('password'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
}
