<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CartItem;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;

class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $variant = $product->variants()->inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(1, 3);

        return [
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'product_id' => $product->id,
            'variant_id' => $variant?->id,
            'quantity' => $quantity,
            'created_at' => $this->faker->dateTimeBetween('-15 days', 'now'),
        ];
    }
}
