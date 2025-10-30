<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 20, 200);
        $compare = $this->faker->boolean(40) ? $price + $this->faker->numberBetween(5, 50) : null;

        return [
            'sku' => strtoupper($this->faker->bothify('SKU-#####')),
            'slug' => $this->faker->unique()->slug(),
            'name' => [
                'en' => ucfirst($this->faker->words(3, true)),
                'bg' => ucfirst($this->faker->words(3, true)),
            ],
            'description' => [
                'en' => $this->faker->paragraph(),
                'bg' => $this->faker->paragraph(),
            ],
            'short_description' => [
                'en' => $this->faker->sentence(),
                'bg' => $this->faker->sentence(),
            ],
            'material' => [
                'en' => $this->faker->word(),
                'bg' => $this->faker->word(),
            ],
            'care_instructions' => [
                'en' => 'Hand wash only. Do not bleach.',
                'bg' => 'Само ръчно пране. Без избелване.',
            ],
            'price' => $price,
            'compare_at_price' => $compare,
            'cost_price' => $price * 0.6,
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(20),
            'stock_quantity' => $this->faker->numberBetween(0, 40),
            'low_stock_threshold' => 3,
            'stock_status' => 'in_stock',
            'is_taxable' => true,
            'requires_shipping' => true,
            'weight' => $this->faker->randomFloat(2, 0.2, 3),
            'width' => $this->faker->randomFloat(2, 5, 40),
            'height' => $this->faker->randomFloat(2, 5, 60),
            'depth' => $this->faker->randomFloat(2, 5, 40),
        ];
    }
}
