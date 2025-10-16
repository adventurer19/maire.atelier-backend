<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
 public function definition(): array
 {
     return [
         'name' => ['en' => $this->faker->word()],
         'slug' => $this->faker->unique()->slug(),
         'type' => $this->faker->randomElement(['text', 'select', 'multiselect', 'color', 'image']),
         'is_filterable' => $this->faker->boolean(),
         'is_visible' => $this->faker->boolean(80),
         'position' => $this->faker->numberBetween(0, 100),
     ];
 }

}
