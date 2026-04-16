<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FeedConsumption;
use App\Models\Pig;

class Pen extends Model
{
    protected $fillable = [
        'name',
    ];

    public function pigs()
    {
        return $this->hasMany(Pig::class);
    }

    public function feedConsumptions()
    {
        return $this->hasMany(FeedConsumption::class);
    }
}
