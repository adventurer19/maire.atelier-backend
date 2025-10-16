<?php

namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = \App\Models\User::all();
        $products = \App\Models\Product::all();

        foreach ($users->take(10) as $user) {
            CartItem::factory()->count(rand(1, 5))->create([
                'user_id' => $user->id,
                'product_id' => $products->random()->id,
            ]);
        }
    }
}
