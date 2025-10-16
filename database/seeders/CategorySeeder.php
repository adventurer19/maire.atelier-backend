<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
   {
       Category::factory()->count(10)->create();
       $parents = Category::take(3)->get();
       foreach ($parents as $parent) {
           Category::factory()->count(3)->create([
               'parent_id' => $parent->id,
           ]);
       }
   }
}
