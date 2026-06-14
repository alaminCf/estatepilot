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
            'permissions' => User::allPermissions(),
            'email_verified_at' => now(),
        ]);

        // Create the commission user hierarchy (E.D → G.M → AGM → Manager → Ast. Manager).
        // Each picks the immediate upline above it; percentages come from the chart defaults.
        // Login: <type>@londonabd.com  /  password
        $phone = 18000000001;
        $parent = null;

        foreach (config('commission.types') as $type => $meta) {
            $parent = User::create([
                'name' => $meta['label'] . ' User',
                'email' => $type . '@londonabd.com',
                'phone' => '0' . $phone++,
                'password' => Hash::make('password'),
                'role' => 'agent',
                'status' => 'active',
                'commission_type' => $type,
                'parent_id' => $parent?->id,
                'booking_pct' => $meta['defaults']['booking'],
                'down_pct' => $meta['defaults']['down'],
                'instalment_pct' => $meta['defaults']['instalment'],
                'referral_code' => strtoupper($type),
                'email_verified_at' => now(),
            ]);
        }

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
