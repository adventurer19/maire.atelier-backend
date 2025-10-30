<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $variant = $product->variants()->inRandomOrder()->first();

        $quantity = $this->faker->numberBetween(1, 3);
        $price = $variant->price ?? $product->price;
        $total = $price * $quantity;

        return [
            'order_id' => Order::factory(),
            'product_id' => $product->id,
            'variant_id' => $variant?->id,
            'sku' => $variant?->sku ?? $product->sku,
            'name' => $product->name['en'] ?? 'Product',
            'quantity' => $quantity,
            'price' => $price,
            'total' => $total,
        ];
    }
}
