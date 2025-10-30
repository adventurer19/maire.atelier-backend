<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Address;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('👥 Seeding users with addresses...');

        // Create admin
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        // Add address to admin
        Address::factory()->count(2)->create([
            'user_id' => $admin->id,
        ]);

        // Create demo user
        $niki = User::create([
            'name' => 'Niki',
            'email' => 'niki@example.com',
            'password' => Hash::make('admin'),
            'email_verified_at' => now(),
        ]);

        // Add addresses to Niki
        Address::factory()->count(2)->create([
            'user_id' => $niki->id,
        ]);

        // Create some regular users
        $users = User::factory(15)->create();

        // Give each of them 1–3 addresses
        $users->each(function ($user) {
            Address::factory()->count(rand(1, 3))->create([
                'user_id' => $user->id,
            ]);
        });

        $this->command->info('Users and addresses seeded successfully.');
    }
}
