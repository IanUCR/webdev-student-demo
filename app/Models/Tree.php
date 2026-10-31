<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Tree extends Model
{

    use HasFactory;

    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_DEAD = 'DEAD';
    public const STATUS_MATURE = 'MATURE';

    public const CARES_PER_LEVEL = 5;
    public const MATURE_LEVEL = 10;
    public const MAX_HEALTH = 100;
    public const HEALTH_PER_CARE = 20;
    public const COOLDOWN_MINUTES = 60;

    protected $primaryKey = 'idTree';

    //
    protected $fillable = [
        'idSeed',
        'owner_id',
        'level',
        'health',
        'progress',
        'status',
        'last_cared_at',
        'next_care_at',
        'last_decay_at',
        'last_harvested_at',
    ];

    protected function casts(): array
    {
        return [
            'level' => 'integer',
            'health' => 'integer',
            'progress' => 'integer',
            'last_cared_at' => 'datetime',
            'next_care_at' => 'datetime',
            'last_decay_at' => 'datetime',
            'last_harvested_at' => 'datetime',
        ];
    }

    public function seed(): BelongsTo
    {
        return $this->belongsTo(Seed::class, 'idSeed', 'idSeed');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }
}
