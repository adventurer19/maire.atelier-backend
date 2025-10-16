<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;

class ProductVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::take(20)->get();
        foreach ($products as $product) {
            ProductVariant::factory()
                ->for($product)
                ->create();
        }
    }
}
