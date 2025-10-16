<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WishlistItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        $products = \App\Models\Product::all();

        foreach ($users->random(10) as $user) {
            foreach ($products->random(rand(1, 5)) as $product) {
                \App\Models\WishlistItem::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'variant_id' => $product->variants()->inRandomOrder()->first()?->id,
                ]);
            }
        }
    }
}
