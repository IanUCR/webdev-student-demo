<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seed extends Model
{
    use HasFactory;

    protected $primaryKey = 'idSeed';
    //
    protected $fillable = [
        'nameOfSeed',
        'description',
        'category',
        'type_id',
        
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(SeedType::class, 'type_id', 'idSeedType');
    }

    public function trees(): HasMany
    {
        return $this->hasMany(Tree::class, 'idSeed', 'idSeed');
    }


}
