<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FeedConsumption;
use App\Models\Pig;

class Pen extends Model
{
    protected $fillable = [
        'name', 'section', 'status', 'healthy_pigs', 'sick_pigs', 'avg_weight',
        'target_weight', 'batch_cost', 'feed_cons', 'profit_margin',
        'progress', 'start_date', 'end_date'
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
