<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $media = Media::all();
        if ($media->isEmpty()) {
            $this->command->warn('No media found. Skipping product media seeding.');
            return;
        }

        foreach ($products as $product) {
            $count = min(rand(1, 4), $media->count());
            $productMedia = $media->random($count);

            foreach ($productMedia as $index => $mediaItem) {
                ProductMedia::create([
                    'product_id' => $product->id,
                    'media_id' => $mediaItem->id,
                    'sort_order' => $index,
                    'is_primary' => $index === 0,
                ]);
            }
        }
    }
}
