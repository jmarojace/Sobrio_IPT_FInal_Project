<?php

namespace Database\Factories;

use App\Models\Animal;
use App\Models\FeedingRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FeedingRecord>
 */
class FeedingRecordFactory extends Factory
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
            'feed_type' => fake()->randomElement(['Pasture grass', 'Hay', 'Silage', 'Grain mix']),
            'quantity_kg' => fake()->randomFloat(2, 0.5, 25),
            'fed_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
