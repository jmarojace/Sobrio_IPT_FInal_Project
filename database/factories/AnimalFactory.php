<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Farm;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'farm_id' => Farm::factory(),
            'breed_id' => Breed::factory(),
            'tag_number' => fake()->unique()->bothify('LV-####'),
            'name' => fake()->firstName(),
            'sex' => fake()->randomElement(['Female', 'Male']),
            'birth_date' => fake()->dateTimeBetween('-8 years', 'now')->format('Y-m-d'),
            'status' => 'active',
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
