<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku' => 'PROD-' . $this->faker->unique()->numerify('####'),
            'slug' => $this->faker->unique()->slug(),
            'name' => ['en' => $this->faker->words(3, true)],
            'description' => ['en' => $this->faker->paragraph()],
            'short_description' => ['en' => $this->faker->sentence()],
            'material' => ['en' => $this->faker->words(2, true)],
            'care_instructions' => ['en' => $this->faker->sentence()],
            'meta_title' => ['en' => $this->faker->sentence()],
            'meta_description' => ['en' => $this->faker->paragraph()],
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'sale_price' => $this->faker->optional(0.3)->randomFloat(2, 5, 900),
            'compare_at_price' => $this->faker->optional()->randomFloat(2, 1000, 1500),
            'cost_price' => $this->faker->optional()->randomFloat(2, 5, 500),
            'is_active' => $this->faker->boolean(80),
            'is_featured' => $this->faker->boolean(20),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'low_stock_threshold' => 5,
            'weight' => $this->faker->optional()->randomFloat(2, 100, 5000),
            'width' => $this->faker->optional()->randomFloat(2, 10, 100),
            'height' => $this->faker->optional()->randomFloat(2, 10, 100),
            'depth' => $this->faker->optional()->randomFloat(2, 10, 100),
        ];
    }
}
