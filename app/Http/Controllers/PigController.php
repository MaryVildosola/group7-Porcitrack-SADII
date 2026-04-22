<?php

namespace App\Http\Controllers;

use App\Models\Pig;
use App\Models\PigSale;
use App\Models\PigActivity;
use Illuminate\Http\Request;

class PigController extends Controller
{
    public function sellOrDispose(Request $request, Pig $pig)
    {
        $request->validate([
            'type' => 'required|in:Sold,Disposed',
            'transaction_date' => 'required|date',
            'amount' => 'nullable|numeric',
        ]);

        PigSale::create([
            'pig_id' => $pig->id,
            'type' => $request->type,
            'amount' => $request->amount,
            'buyer_name' => $request->buyer_name,
            'transaction_date' => $request->transaction_date,
            'notes' => $request->notes,
        ]);

        $pig->update(['status' => $request->type]);

        return back()->with('success', 'Pig transaction recorded successfully.');
    }

    public function updateRecord(Request $request, Pig $pig)
    {
        $validated = $request->validate([
            'weight' => 'nullable|numeric|min:0',
            'target_weight' => 'nullable|numeric|min:0',
            'health_status' => 'required|in:Healthy,Warning,Sick',
            'remarks' => 'nullable|string',
            'breed' => 'nullable|string|max:255',
            'bcs_score' => 'required|integer|min:1|max:5',
            'feeding_status' => 'required|in:Active,Normal,Poor',
            'symptoms' => 'nullable|string|max:255',
        ]);

        $pig->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Record successfully updated for ' . $pig->tag
        ]);
    }

    public function logActivity(Request $request, Pig $pig)
    {
        $validated = $request->validate([
            'type' => 'required|in:Care,Medical,Growth',
            'action' => 'required|string|max:255',
            'details' => 'nullable|string',
        ]);

        $pig->activities()->create([
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'action' => $validated['action'],
            'details' => $validated['details'],
        ]);

        return response()->json([
            'success' => true,
            'message' => $validated['action'] . ' has been recorded in the history.'
        ]);
    }

    public function show(Pig $pig)
    {
        $pig->load(['pen', 'activities.user', 'healthReports.user']);
        return view('worker.pigShow', compact('pig'));
    }
}