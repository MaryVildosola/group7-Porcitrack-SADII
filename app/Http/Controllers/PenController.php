<?php

namespace App\Http\Controllers;

use App\Models\Pen;
use App\Models\Pig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenController extends Controller
{
    /**
     * Display a listing of the pens.
     */
    public function index()
    {
        $pens = Pen::with('pigs')->get();
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
            'pig_count' => 'nullable|integer|min:0|max:100', // Limit for safety
        ]);

        return \DB::transaction(function () use ($validated) {
            $pen = Pen::create($validated);

            // Bulk generate pigs if pig_count is provided
            $pigCount = $validated['pig_count'] ?? 0;
            if ($pigCount > 0) {
                for ($i = 1; $i <= $pigCount; $i++) {
                    // Generate a tag like PENNAME-001
                    $tag = sprintf('%s-%03d', $pen->name, $i);
                    
                    Pig::create([
                        'tag' => $tag,
                        'pen_id' => $pen->id,
                        'birth_date' => $pen->start_date, // Default to start date of batch
                        'health_status' => 'Healthy',
                        'status' => 'Active',
                    ]);
                }
                // Update pen stats
                $pen->update([
                    'healthy_pigs' => $pigCount,
                    'sick_pigs' => 0
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Pen created successfully with ' . $pigCount . ' pigs!',
                'pen' => $pen->load('pigs')
            ]);
        });
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

    public function show($id)
{
    // Kukunin ang pen at isasama lahat ng pigs na 'Healthy' o 'Active'
    $pen = Pen::with(['pigs' => function($query) {
        $query->whereNotIn('status', ['Sold', 'Disposed']);
    }])->findOrFail($id);

    return view('pens.show', compact('pen'));
}
}
