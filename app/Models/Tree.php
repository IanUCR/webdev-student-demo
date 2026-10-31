<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    //
    protected $fillable = [
        'idSeed',
        'owner_id',
        'level',
        'health',
        'progress',
        'status',
        'last_cared_at',
        'next_cared_at',
        'last_decay_at',
        'last_harvested_at',
    ];
}
