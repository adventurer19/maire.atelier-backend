<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => \App\Models\Product::factory(),
            'user_id' => \App\Models\User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'title' => $this->faker->optional()->sentence(),
            'comment' => $this->faker->paragraph(),
            'is_approved' => $this->faker->boolean(80),
            'approved_at' => $this->faker->optional()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
