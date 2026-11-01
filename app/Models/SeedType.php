<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class SeedType extends Model
{
    use HasFactory;

    protected $primaryKey = 'idSeedType';
    //
    protected $fillable = [
        'typeOfSeed',
        'care_per_level',
        'harvest_reward_in_coins',
    ];

    public function seeds(): HasMany
    {
        return $this->hasMany(Seed::class, 'type_id', 'idSeedType');
    }
}
