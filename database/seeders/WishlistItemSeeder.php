<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WishlistItem;

class WishlistItemSeeder extends Seeder
{
    public function run(): void
    {
        // Create 30 wishlist items (mix of registered users & guests)
        WishlistItem::factory()->count(30)->create();

        $this->command->info('💖 Wishlist items seeded successfully.');
    }
}
