<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedFormulaIngredient extends Model
{
    protected $fillable = [
        'feed_formula_id',
        'feed_ingredient_id',
        'quantity_sacks',
    ];

    public function formula()
    {
        return $this->belongsTo(FeedFormula::class, 'feed_formula_id');
    }

    public function ingredient()
    {
        return $this->belongsTo(FeedIngredient::class, 'feed_ingredient_id');
    }
}
