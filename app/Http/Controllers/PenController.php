<?php

namespace App\Http\Controllers;

use App\Models\Pen;
use Illuminate\Http\Request;

class PenController extends Controller
{
    /**
     * Display a listing of the pens.
     */
    public function index()
    {
        $pens = Pen::all();
        return view('pens.index', compact('pens'));
    }

    /**
     * Store a newly created pen in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'section' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'healthy_pigs' => 'nullable|integer',
            'sick_pigs' => 'nullable|integer',
            'avg_weight' => 'nullable|string|max:255',
            'target_weight' => 'nullable|string|max:255',
            'batch_cost' => 'nullable|string|max:255',
            'feed_cons' => 'nullable|string|max:255',
            'profit_margin' => 'nullable|string|max:255',
            'progress' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $pen = Pen::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pen created successfully!',
            'pen' => $pen
        ]);
    }

    /**
     * Update the specified pen in storage.
     */
    public function update(Request $request, Pen $pen)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'section' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'healthy_pigs' => 'nullable|integer',
            'sick_pigs' => 'nullable|integer',
            'avg_weight' => 'nullable|string|max:255',
            'target_weight' => 'nullable|string|max:255',
            'batch_cost' => 'nullable|string|max:255',
            'feed_cons' => 'nullable|string|max:255',
            'profit_margin' => 'nullable|string|max:255',
            'progress' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $pen->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pen updated successfully!',
            'pen' => $pen
        ]);
    }

    /**
     * Remove the specified pen from storage.
     */
    public function destroy(Pen $pen)
    {
        $pen->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pen deleted successfully!'
        ]);
    }
}
