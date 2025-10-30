<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('⚠️ No products found. Skipping reviews.');
            return;
        }

        $products->each(function ($product) {
            // Between 3–8 reviews per product
            Review::factory(rand(3, 8))->create([
                'product_id' => $product->id,
            ]);
        });

        $this->command->info('✅ Reviews seeded successfully.');
    }
}
