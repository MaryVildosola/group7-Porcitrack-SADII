<?php

namespace App\Http\Controllers;

use App\Models\Pig;
use App\Models\PigSale;
use Illuminate\Http\Request;

class PigController extends Controller
{
    public function sellOrDispose(Request $request, Pig $pig)
    {
        // I validate ang data na galing sa form
        $request->validate([
            'type' => 'required|in:Sold,Disposed',
            'transaction_date' => 'required|date',
            'amount' => 'nullable|numeric',
        ]);

        // I save sa pig_sales table
        PigSale::create([
            'pig_id' => $pig->id,
            'type' => $request->type,
            'amount' => $request->amount,
            'buyer_name' => $request->buyer_name,
            'transaction_date' => $request->transaction_date,
            'notes' => $request->notes,
        ]);

        // I-update ang status ng pig sa pigs table
        $pig->update(['status' => $request->type]);

        return back()->with('success', 'Pig transaction recorded successfully.');
    }
}