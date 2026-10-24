<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeedType extends Model
{
    //
    protected $fillable = [
        'idSeedType',
        'typeOfSeed',
        'Care_per_level',
        'haervest_reward_in_coins',
    ];
}
