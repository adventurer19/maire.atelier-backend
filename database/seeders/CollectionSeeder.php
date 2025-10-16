<?php

namespace Database\Seeders;

use App\Models\Collection;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = Collection::factory()->count(5)->create();

        $products = Product::all();

        foreach ($collections as $collection) {
            $collection->products()->attach(
                $products->random(rand(5, 15))->pluck('id')->toArray()
            );
        }
    }
}
