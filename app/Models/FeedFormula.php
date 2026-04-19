<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedFormula extends Model
{
    protected $fillable = [
        'name',
        'life_stage',
        'total_batch_sacks',
        'notes',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function formulaIngredients()
    {
        return $this->hasMany(FeedFormulaIngredient::class);
    }
}
