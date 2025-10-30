<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
     {
         return [
             'user_id' => User::factory(),
             'type' => $this->faker->randomElement(['shipping', 'billing']),
             'first_name' => $this->faker->firstName(),
             'last_name' => $this->faker->lastName(),
             'company' => $this->faker->optional()->company(),
             'address_line1' => $this->faker->streetAddress(), // ✅ без "_"
             'address_line2' => $this->faker->optional()->secondaryAddress(),
             'city' => $this->faker->city(),
             'state' => $this->faker->state(),
             'postal_code' => $this->faker->postcode(),
             'country' => $this->faker->countryCode(),
             'phone' => $this->faker->phoneNumber(),
             'is_default' => $this->faker->boolean(20),
         ];

     }
}
