<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = \App\Models\Product::all();
        $media = \App\Models\Media::all();

        foreach ($products as $product) {
            $productMedia = $media->random(rand(1, 4));

            foreach ($productMedia as $index => $mediaItem) {
                \App\Models\ProductMedia::create([
                    'product_id' => $product->id,
                    'media_id' => $mediaItem->id,
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }
        }
    }
}
