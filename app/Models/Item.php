<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $primaryKey = 'idItem';
    //
    protected $fillable = [
        'idItem',
        'nameOfItem',
        'description',
        'price',
        'effect_type',
        'duration',
    ];
}
