<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedIngredient extends Model
{
    protected $fillable = [
        'name',
        'crude_protein',
        'metabolizable_energy',
        'crude_fat',
        'crude_fiber',
        'calcium',
        'phosphorus',
        'cost_per_sack',
    ];

    public function formulaIngredients()
    {
        return $this->hasMany(FeedFormulaIngredient::class);
    }
}
