<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Breed;
use App\Models\Farm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $farms = collect([
            ['name' => 'Batangas Livestock Farm', 'location' => 'Batangas, Philippines', 'manager_name' => 'Kris Paul', 'phone' => '+63 917 555 0142'],
            ['name' => 'Pampanga Livestock Farm', 'location' => 'Pampanga, Philippines', 'manager_name' => 'Marian Ramos', 'phone' => '+63 918 555 0276'],
        ])->map(fn (array $farm): Farm => Farm::create($farm));

        $breeds = collect([
            ['name' => 'Holstein', 'species' => 'Cattle'],
            ['name' => 'Angus', 'species' => 'Cattle'],
            ['name' => 'Boer', 'species' => 'Goat'],
            ['name' => 'Dorper', 'species' => 'Sheep'],
        ])->map(fn (array $breed): Breed => Breed::create($breed));

        $animals = collect([
            ['tag_number' => 'LV-1001', 'name' => 'Daisy', 'sex' => 'Female', 'breed' => 0, 'farm' => 0],
            ['tag_number' => 'LV-1002', 'name' => 'Buster', 'sex' => 'Male', 'breed' => 1, 'farm' => 0],
            ['tag_number' => 'LV-1003', 'name' => 'Clover', 'sex' => 'Female', 'breed' => 0, 'farm' => 1],
            ['tag_number' => 'LV-1004', 'name' => 'Milo', 'sex' => 'Male', 'breed' => 2, 'farm' => 1],
            ['tag_number' => 'LV-1005', 'name' => 'Willow', 'sex' => 'Female', 'breed' => 3, 'farm' => 0],
            ['tag_number' => 'LV-1006', 'name' => 'Fern', 'sex' => 'Female', 'breed' => 2, 'farm' => 1],
        ])->map(fn (array $animal): Animal => Animal::create([
            'tag_number' => $animal['tag_number'],
            'name' => $animal['name'],
            'sex' => $animal['sex'],
            'birth_date' => fake()->dateTimeBetween('-5 years', '-6 months')->format('Y-m-d'),
            'status' => 'active',
            'breed_id' => $breeds[$animal['breed']]->id,
            'farm_id' => $farms[$animal['farm']]->id,
        ]));

        foreach ($animals as $animal) {
            $animal->vaccinations()->create([
                'vaccine_name' => fake()->randomElement(['Foot-and-mouth', 'Clostridial', 'Brucellosis']),
                'administered_on' => now()->subMonths(fake()->numberBetween(1, 6))->toDateString(),
                'next_due_date' => now()->addMonths(fake()->numberBetween(1, 6))->toDateString(),
                'veterinarian' => fake()->name(),
            ]);

            $animal->feedingRecords()->create([
                'feed_type' => fake()->randomElement(['Pasture grass', 'Hay', 'Silage', 'Grain mix']),
                'quantity_kg' => fake()->randomFloat(2, 2, 15),
                'fed_at' => now()->subHours(fake()->numberBetween(1, 72)),
            ]);
        }
    }
}
