<?php

namespace Database\Factories;

use App\Models\Seed;
use App\Models\SeedType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Seed>
 */
class SeedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nameOfSeed' => fake()->unique()->word(),
            'type_id' => SeedType::factory(),
            'category' => fake()->randomElement(['bosque', 'frutal', 'ornamental']),
            'description' => fake()->sentence(),
            //
        ];
    }
}
