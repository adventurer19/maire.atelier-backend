<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Review;
use App\Models\Product;
use App\Models\User;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        $approved = $this->faker->boolean(80); // 80% са одобрени
        $verified = $this->faker->boolean(60); // 60% са проверени покупки

        return [
            'product_id' => Product::inRandomOrder()->value('id') ?? Product::factory(),
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'title' => ucfirst($this->faker->words(3, true)),
            'comment' => $this->faker->paragraph(),
            'is_verified_purchase' => $verified,
            'is_approved' => $approved,
            'helpful_count' => $this->faker->numberBetween(0, 25),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
        ];
    }
}
