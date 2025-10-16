<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Redirect>
 */
class RedirectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from_url' => '/' . $this->faker->unique()->slug(),
            'to_url' => '/' . $this->faker->slug(),
            'status_code' => $this->faker->randomElement([301, 302]),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
