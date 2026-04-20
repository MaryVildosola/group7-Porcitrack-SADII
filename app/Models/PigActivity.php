<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PigActivity extends Model
{
    protected $fillable = [
        'pig_id',
        'user_id',
        'type',
        'action',
        'details',
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
