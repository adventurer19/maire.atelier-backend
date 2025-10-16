<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class MediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
  public function run(): void
  {
      $products = Product::all();
      $products->each(function ($product) {
          for ($i = 0; $i < rand(1, 3); $i++) {
              $product->addMediaFromUrl('https://via.placeholder.com/640x480.png')
                  ->toMediaCollection();
          }
      });
  }
}
