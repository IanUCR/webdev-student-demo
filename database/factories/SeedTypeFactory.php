<?php

namespace Database\Factories;

use App\Models\SeedType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SeedType>
 */
class SeedTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
 public function definition(): array
{
    return [
        'typeOfSeed' => 'normal',
        'care_per_level' => 5,
        'harvest_reward_in_coins' => 10,
    ];
}

public function special(): static
{
    return $this->state(fn (array $attributes) => [
        'typeOfSeed' => 'special',
        'care_per_level' => 3,
        'harvest_reward_in_coins' => 7,
    ]);
}
}
