<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{WishlistItem, User, Product, ProductVariant};
use Illuminate\Support\Str;

class WishlistItemFactory extends Factory
{
    protected $model = WishlistItem::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $variant = $product->variants()->inRandomOrder()->first();

        return [
            'user_id' => $this->faker->boolean(70)
                ? (User::inRandomOrder()->first()?->id ?? User::factory()->create()->id)
                : null,
            'token' => $this->faker->boolean(30) ? Str::uuid()->toString() : null,
            'product_id' => $product->id,
            'variant_id' => $variant?->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
