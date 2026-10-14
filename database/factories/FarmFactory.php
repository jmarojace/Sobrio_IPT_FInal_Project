<?php

namespace Database\Factories;

use App\Models\Farm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Farm>
 */
class FarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company().' Farm',
            'location' => fake()->city(),
            'manager_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
