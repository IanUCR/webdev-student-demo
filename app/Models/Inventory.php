<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $primaryKey = 'idInventory';
    //
    protected $fillable = [
        'user_id',
        'item_id',
        'item_quantity',
    ];
}
