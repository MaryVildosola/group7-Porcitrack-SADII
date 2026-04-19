<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PigSale extends Model
{
    protected $fillable = ['pig_id', 'type', 'amount', 'buyer_name', 'transaction_date', 'notes'];

public function pig()
{
    return $this->belongsTo(Pig::class);
}

}
