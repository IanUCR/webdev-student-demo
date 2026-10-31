<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Active_Effect extends Model
{
    //
    protected $fillable = [
        'tree_id',
        'item_id',
        'status',
        'start_at',
        'end_at',
    ];
}
