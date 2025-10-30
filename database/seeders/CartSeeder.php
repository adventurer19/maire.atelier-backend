<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\CartItem;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('⚠️ No users found. Skipping cart items.');
            return;
        }

        $users->each(function ($user) {
            CartItem::factory(rand(1, 10))->create([
                'user_id' => $user->id,
            ]);
        });

        $this->command->info('🛒 Cart items seeded successfully.');
    }
}
