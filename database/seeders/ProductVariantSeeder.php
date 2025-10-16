<?php

namespace Database\Seeders;

use App\Models\ProductVariant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = \App\Models\Product::take(20)->get();

        foreach ($products as $product) {
            ProductVariant::factory()->count(rand(2, 5))->create([
                'product_id' => $product->id,
            ]);
        }
    }
}
