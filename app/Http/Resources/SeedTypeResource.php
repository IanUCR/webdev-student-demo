<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeedTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'idSeedType' => $this->idSeedType,
            'typeOfSeed' => $this->typeOfSeed,
            'care_per_level' => $this->care_per_level,
            'harvest_reward_in_coins' => $this->harvest_reward_in_coins
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
