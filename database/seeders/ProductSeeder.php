<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Product, ProductVariant, Category, Collection,
    Attribute, AttributeOption
};

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🧱 Seeding products, categories, variants, and media...');

        // Ensure storage link exists
        if (!Storage::exists('public')) {
            \Artisan::call('storage:link');
        }

        // ======== BASE ATTRIBUTES ========
        $color = Attribute::firstOrCreate(['slug' => 'color'], [
            'name' => ['en' => 'Color', 'bg' => 'Цвят'],
            'type' => 'swatch',
            'is_filterable' => true,
            'is_visible' => true,
        ]);

        $size = Attribute::firstOrCreate(['slug' => 'size'], [
            'name' => ['en' => 'Size', 'bg' => 'Размер'],
            'type' => 'select',
            'is_filterable' => true,
            'is_visible' => true,
        ]);

        $colors = [
            ['slug' => 'red', 'value' => ['en' => 'Red', 'bg' => 'Червен'], 'hex_color' => '#FF0000'],
            ['slug' => 'green', 'value' => ['en' => 'Green', 'bg' => 'Зелен'], 'hex_color' => '#00FF00'],
            ['slug' => 'blue', 'value' => ['en' => 'Blue', 'bg' => 'Син'], 'hex_color' => '#0000FF'],
            ['slug' => 'black', 'value' => ['en' => 'Black', 'bg' => 'Черен'], 'hex_color' => '#000000'],
            ['slug' => 'white', 'value' => ['en' => 'White', 'bg' => 'Бял'], 'hex_color' => '#FFFFFF'],
        ];

        $sizes = ['S', 'M', 'L', 'XL'];

        foreach ($colors as $c) {
            AttributeOption::firstOrCreate(
                ['slug' => $c['slug'], 'attribute_id' => $color->id],
                array_merge($c, ['position' => 1])
            );
        }

        foreach ($sizes as $s) {
            AttributeOption::firstOrCreate(
                ['slug' => strtolower($s), 'attribute_id' => $size->id],
                ['value' => ['en' => $s, 'bg' => $s], 'position' => 1]
            );
        }

        // ======== CATEGORIES & COLLECTIONS ========
        $categories = \App\Models\Category::factory()->count(5)->create();
        $collections = \App\Models\Collection::factory()->count(3)->create();

        // ======== PRODUCTS ========
        Product::factory()->count(15)->create()->each(function ($product) use ($categories, $collections, $color, $size) {
            // Attach to random category & maybe collection
            $product->categories()->attach($categories->random(1)->pluck('id'));
            if (rand(0, 1)) {
                $product->collections()->attach($collections->random(1)->pluck('id'));
            }

            // Attach random product images (using Picsum)
            for ($i = 0; $i < rand(2, 4); $i++) {
                $product
                    ->addMediaFromUrl("https://picsum.photos/seed/" . uniqid() . "/800/800")
                    ->toMediaCollection('images');
            }

            // ======== VARIANTS ========
            $colorOptions = $color->options()->inRandomOrder()->take(2)->get();
            $sizeOptions = $size->options()->inRandomOrder()->take(2)->get();

            foreach ($colorOptions as $c) {
                foreach ($sizeOptions as $s) {
                    $variant = \App\Models\ProductVariant::factory()->create([
                        'product_id' => $product->id,
                        'sku' => strtoupper($product->sku . '-' . $c->slug . '-' . $s->slug),
                        'price' => $product->price + rand(0, 15),
                    ]);

                    $variant->attributeOptions()->sync([$c->id, $s->id]);

                    // Add random variant image
                    $variant
                        ->addMediaFromUrl("https://picsum.photos/seed/" . uniqid() . "/600/600")
                        ->toMediaCollection('images');
                }
            }
        });

        $this->command->info('✅ Products, variants, and images seeded successfully.');
    }
}
