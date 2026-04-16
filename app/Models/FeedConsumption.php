<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pen;
use App\Models\User;

class FeedConsumption extends Model
{
    protected $fillable = [
        'pen_id',
        'quantity',
        'consumption_date',
        'user_id',
    ];

    protected $casts = [
        'consumption_date' => 'date',
    ];

    public function pen()
    {
        return $this->belongsTo(Pen::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
