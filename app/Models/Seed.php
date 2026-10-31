<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seed extends Model
{
    //
    protected $fillable = [
        'nameOfSeed',
        'description',
        'category',
        'type_id',
        
    ];
}
