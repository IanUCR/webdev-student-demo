<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'nameOfSeed' => $this->nameOfSeed,
            'description' => $this->description,
            'category' => $this->category,
            'type_id' => $this->whenLoaded('type', fn () => 
            [$this->type->idSeedType,
            $this->type->typeOfSeed]),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
