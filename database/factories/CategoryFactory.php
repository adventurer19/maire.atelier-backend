<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => ['en' => $this->faker->unique()->words(2, true)],
            'slug' => $this->faker->unique()->slug(),
            'description' => ['en' => $this->faker->optional()->paragraph()],
            'parent_id' => null,
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => $this->faker->boolean(90),
            'meta_title' => ['en' => $this->faker->optional()->sentence()],
            'meta_description' => ['en' => $this->faker->optional()->text(160)],
        ];
    }

}
