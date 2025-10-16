<?php

namespace Database\Factories;

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
            'user_id' => \App\Models\User::factory(),
            'order_number' => $this->faker->unique()->bothify('ORD-####-####'),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'subtotal' => $this->faker->randomFloat(2, 20, 500),
            'tax' => $this->faker->randomFloat(2, 2, 50),
            'shipping' => $this->faker->randomFloat(2, 5, 30),
            'discount' => $this->faker->optional()->randomFloat(2, 0, 50),
            'total' => $this->faker->randomFloat(2, 30, 600),
            'notes' => $this->faker->optional()->paragraph(),
            'placed_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
