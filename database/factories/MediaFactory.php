<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
    {
        return [
            'mediable_type' => null,
            'mediable_id' => null,
            'name' => $this->faker->word(),
            'file_name' => $this->faker->word() . '.jpg',
            'mime_type' => 'image/jpeg',
            'path' => $this->faker->filePath(),
            'disk' => 'public',
            'size' => $this->faker->numberBetween(1000, 5000000),
            'alt_text' => $this->faker->optional()->sentence(),
            'sort_order' => $this->faker->numberBetween(0, 100),
        ];
    }}
