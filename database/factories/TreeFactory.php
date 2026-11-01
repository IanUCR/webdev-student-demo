<?php

namespace Database\Factories;

use App\Models\Tree;
use App\Models\Seed;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tree>
 */
class TreeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idSeed' => Seed::factory(),
            'owner_id' => User::factory(),
            'level' => 0,
            'health' => 100,
            'progress' => 0,
            'status' => Tree::STATUS_ACTIVE,
            'last_cared_at' => null,
            'next_care_at' => null,
        ];
    }
}
