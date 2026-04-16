<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedDelivery extends Model
{
    protected $fillable = [
        'delivery_date',
        'quantity',
    ];

    protected $casts = [
        'delivery_date' => 'date',
    ];
}
