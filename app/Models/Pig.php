<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pen;

class Pig extends Model
{
    protected $fillable = [
        'tag',
        'pen_id',
        'birth_date',
        'status',
        'weight',
        'target_weight',
        'health_status',
        'remarks',
        'breed',
        'bcs_score',
        'feeding_status',
        'symptoms',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function sale()
{
    return $this->hasOne(PigSale::class);
}

    public function pen()
    {
        return $this->belongsTo(Pen::class);
    }

    public function activities()
    {
        return $this->hasMany(PigActivity::class)->latest();
    }
    
}
