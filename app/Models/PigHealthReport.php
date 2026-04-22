<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PigHealthReport extends Model
{
    protected $fillable = [
        'pig_id',
        'user_id',
        'symptom',
        'body_condition_score',
        'feeding_behavior',
        'weight',
        'physical_checks',
        'notes',
    ];

    protected $casts = [
        'physical_checks' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pig()
    {
        return $this->belongsTo(Pig::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
