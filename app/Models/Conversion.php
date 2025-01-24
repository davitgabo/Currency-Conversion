<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversion extends Model
{
    protected $fillable = [
        'order_id',
        'from_currency',
        'to_currency',
        'from_amount',
        'to_amount',
        'status',
        'payed',
        'email'
    ];
}
