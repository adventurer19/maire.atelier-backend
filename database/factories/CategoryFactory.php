<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = ucfirst($this->faker->unique()->word());
        return [
            'name' => [
                'en' => $name,
                'bg' => $name,
            ],
            'slug' => Str::slug($name),
            'description' => [
                'en' => $this->faker->sentence(),
                'bg' => $this->faker->sentence(),
            ],
            'meta_title' => [
                'en' => $name,
                'bg' => $name,
            ],
            'meta_description' => [
                'en' => $this->faker->sentence(),
                'bg' => $this->faker->sentence(),
            ],
            'is_active' => true,
            'is_featured' => $this->faker->boolean(30),
            'show_in_menu' => $this->faker->boolean(80),
            'position' => $this->faker->numberBetween(1, 100),
        ];
    }
}
