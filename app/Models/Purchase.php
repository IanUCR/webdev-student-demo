<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{  
    protected $primaryKey = 'idPurchase';
    //
    protected $fillable = [
        'user_id',
        'item_id',
        'quantity',
        'unit_price',
        'total_price',
    ];
}
