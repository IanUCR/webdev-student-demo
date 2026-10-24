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
            'idTree' => $this->idTree,
            'idSeed' => $this->idSeed,
            'owner_id' => $this->owner_id,
            'level' => $this->level,
            'health' => $this->health,
            'progress' => $this->progress,
            'status' => $this->status,
            'last_cared_at' => $this->last_cared_at,
            'next_cared_at' => $this->next_cared_at,
            'last_decay_at' => $this->last_decay_at,
            'last_harvested_at' => $this->last_harvested_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
