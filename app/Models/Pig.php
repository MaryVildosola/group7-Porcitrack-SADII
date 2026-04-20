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

    
}
