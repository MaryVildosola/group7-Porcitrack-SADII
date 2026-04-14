<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReport extends Model
{
    protected $fillable = [
        'user_id',
        'week_start_date',
        'total_pigs',
        'sick_pigs',
        'avg_weight',
        'feed_consumed',
        'details',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
