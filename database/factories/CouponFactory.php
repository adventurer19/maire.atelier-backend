<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Coupon;

class CouponFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement([Coupon::TYPE_PERCENTAGE, Coupon::TYPE_FIXED]);
        $value = $type === Coupon::TYPE_PERCENTAGE
            ? $this->faker->numberBetween(5, 30)
            : $this->faker->randomFloat(2, 5, 50);

        return [
            'code' => strtoupper(Str::random(8)),
            'description' => $this->faker->sentence(),
            'type' => $type,
            'value' => $value,
            'min_purchase_amount' => $this->faker->randomFloat(2, 20, 200),
            'max_discount_amount' => $this->faker->randomFloat(2, 20, 100),
            'usage_limit' => $this->faker->optional()->numberBetween(5, 100),
            'usage_count' => 0,
            'valid_from' => now()->subDays(rand(0, 10)),
            'valid_to' => now()->addDays(rand(10, 60)),
            'applies_to' => $this->faker->randomElement(['all', 'category', 'product']),
            'is_active' => true,
        ];
    }
}
