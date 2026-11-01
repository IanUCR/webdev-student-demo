<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            //'idTree' => $this->idTree,
            'id' => $this->idTree,
            'idSeed' => $this->idSeed,
            'owner_id' => $this->owner_id,
            'level' => $this->level,
            'health' => $this->health,
            'progress' => $this->progress,
            'status' => $this->status,
            //'last_cared_at' => $this->last_cared_at,
            'last_cared_at' => $this->last_cared_at?->toIso8601ZuluString(),
            //'next_cared_at' => $this->next_cared_at,
            'next_care_at' => $this->next_care_at?->toIso8601ZuluString(),
            //'last_decay_at' => $this->last_decay_at,
            'last_decay_at' => $this->last_decay_at?->toIso8601ZuluString(),
            //'last_harvested_at' => $this->last_harvested_at,
            'last_harvested_at' => $this->last_harvested_at?->toIso8601ZuluString(),
            //'created_at' => $this->created_at,
            'created_at' => $this->created_at?->toIso8601ZuluString(),
            //'updated_at' => $this->updated_at,
            'updated_at' => $this->updated_at?->toIso8601ZuluString(),
        ];
    }
}
