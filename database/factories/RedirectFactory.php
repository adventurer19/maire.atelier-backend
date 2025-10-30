<?php

namespace Database\Factories;

use App\Models\Redirect;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectFactory extends Factory
{
    protected $model = Redirect::class;

    public function definition(): array
    {
        return [
            // Example: "/old-page-123"
            'from_url' => '/' . $this->faker->unique()->slug(),

            // Example: "/new-page-123"
            'to_url' => '/' . $this->faker->slug(),

            // 301 = permanent, 302 = temporary
            'status_code' => $this->faker->randomElement([301, 302]),

            // Randomly activate/deactivate some redirects
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
