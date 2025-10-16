<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => 'ORD-' . fake()->unique()->numerify('####-####'),
            'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'refunded']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'payment_method' => fake()->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'subtotal' => $subtotal = fake()->randomFloat(2, 50, 500),
            'shipping_cost' => $shipping = fake()->randomFloat(2, 5, 25), // Change from 'shipping'
            'tax' => $tax = $subtotal * 0.10,
            'discount' => $discount = fake()->optional(0.3)->randomFloat(2, 5, 50) ?? 0,
            'total' => $subtotal + $shipping + $tax - $discount,
            'currency' => 'BGN',
            'notes' => fake()->optional()->sentence(),
            'customer_ip' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }
}
