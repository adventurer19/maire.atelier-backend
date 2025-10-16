<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttributeOption>
 */
class AttributeOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attribute_id' => Attribute::factory(),
            'slug' => $this->faker->unique()->slug(),
            'value' => ['en' => $this->faker->word()],
            'label' => ['en' => $this->faker->words(2, true)],
            'hex_color' => $this->faker->optional()->hexColor(),
            'position' => $this->faker->numberBetween(0, 100),
        ];
    }
}
