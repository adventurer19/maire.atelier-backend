<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('COUPON-####'),
            'type' => $this->faker->randomElement(['percentage', 'fixed']),
            'value' => $this->faker->randomFloat(2, 5, 50),
            'min_purchase_amount' => $this->faker->optional()->randomFloat(2, 20, 100),
            'max_discount_amount' => $this->faker->optional()->randomFloat(2, 10, 100),
            'usage_limit' => $this->faker->optional()->numberBetween(1, 100),
            'usage_count' => 0,
            'starts_at' => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'expires_at' => $this->faker->optional()->dateTimeBetween('now', '+6 months'),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
