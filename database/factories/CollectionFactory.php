<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Collection;

class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition(): array
    {
        $nameEn = ucfirst($this->faker->words(2, true));
        $nameBg = ucfirst($this->faker->words(2, true)) . ' (BG)';

        return [
            'slug' => Str::slug($nameEn . '-' . uniqid()),
            'name' => [
                'en' => $nameEn,
                'bg' => $nameBg,
            ],
            'description' => [
                'en' => $this->faker->sentence(),
                'bg' => $this->faker->sentence() . ' (BG)',
            ],
            'meta_title' => [
                'en' => $this->faker->sentence(3),
                'bg' => $this->faker->sentence(3) . ' (BG)',
            ],
            'meta_description' => [
                'en' => $this->faker->sentence(8),
                'bg' => $this->faker->sentence(8) . ' (BG)',
            ],
            'type' => $this->faker->randomElement(['manual', 'auto']),
            'is_active' => $this->faker->boolean(90),
            'is_featured' => $this->faker->boolean(20),
            'position' => $this->faker->numberBetween(1, 10),
            'image' => null,
            'conditions' => null,
        ];
    }
}
