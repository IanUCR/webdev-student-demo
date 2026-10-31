<?php

namespace Database\Seeders;

use App\Models\Seed;
use App\Models\SeedType;
use App\Models\Tree;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * Usuarios de prueba: ian@example.com y otro@example.com (contraseña: password)
     */
    public function run(): void
    {
        $ian = User::factory()->create([
            'userName' => 'ian',
            'email'    => 'ian@example.com',
        ]);

        User::factory()->create([
            'userName' => 'Ballentine',
            'email'    => 'Ballentine@example.com',
        ]);

        $normal = SeedType::create([
            'typeOfSeed'              => 'normal',
            'care_per_level'          => 5,
            'harvest_reward_in_coins' => 10,
        ]);

        $special = SeedType::create([
            'typeOfSeed' => 'special',
            'care_per_level' => 3,
            'harvest_reward_in_coins' => 7,
        ]);
        $roble = Seed::create([
            'nameOfSeed'  => 'Roble',
            'type_id'     => $normal->idSeedType,
            'category'    => 'bosque',
            'description' => 'Árbol robusto de crecimiento lento.',
        ]);

        Seed::create([
            'nameOfSeed'  => 'Cerezo',
            'type_id'     => $special->idSeedType,
            'category'    => 'frutal',
            'description' => 'Árbol frutal de flores rosadas.',
        ]);

        // Árbol nuevo para probar cuidados desde cero
        Tree::create([
            'idSeed'   => $roble->idSeed,
            'owner_id' => $ian->id,
        ]);

        // Árbol casi maduro (nivel 9, progreso 4) para probar la transición a MATURE
        Tree::create([
            'idSeed'   => $roble->idSeed,
            'owner_id' => $ian->id,
            'level'    => 9,
            'progress' => 4,
        ]);
    }
}