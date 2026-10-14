<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\Vaccination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vaccination>
 */
class VaccinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'animal_id' => Animal::factory(),
            'vaccine_name' => fake()->randomElement(['Foot-and-mouth', 'Brucellosis', 'Clostridial', 'Rabies']),
            'administered_on' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'next_due_date' => fake()->dateTimeBetween('+1 month', '+1 year')->format('Y-m-d'),
            'veterinarian' => fake()->name(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
