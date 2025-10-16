<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $variant = $product?->variants()->inRandomOrder()->first();

        return [
            'user_id' => User::factory(),
            'product_id' => $product->id,
            'session_id' => fake()->uuid(),
            'product_variant_id' => $variant?->id,
            'quantity' => fake()->numberBetween(1, 5),
        ];
    }
}
