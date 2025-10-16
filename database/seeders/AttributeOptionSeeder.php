<?php

namespace Database\Seeders;

use App\Models\AttributeOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttributeOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $attributes = \App\Models\Attribute::all();

        foreach ($attributes as $attribute) {
            AttributeOption::factory()->count(5)->create([
                'attribute_id' => $attribute->id,
            ]);
        }
    }
}
