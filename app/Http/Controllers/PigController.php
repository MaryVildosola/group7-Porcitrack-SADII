<?php

namespace App\Http\Controllers;

use App\Models\Pig;
use App\Models\PigSale;
use App\Models\PigActivity;
use Illuminate\Http\Request;

class PigController extends Controller
{
    /**
     * Store a newly created pig in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tag'           => 'nullable|string|max:255',
            'pen_id'        => 'required|exists:pens,id',
            'birth_date'    => 'nullable|date',
            'weight'        => 'nullable|numeric|min:0',
            'health_status' => 'required|in:Healthy,Warning,Sick',
            'status'        => 'required|in:Active,Sold,Disposed',
            'breed'         => 'nullable|string|max:255',
        ]);

        // Auto-generate ear tag if not supplied
        if (empty($validated['tag'])) {
            $pen = \App\Models\Pen::findOrFail($validated['pen_id']);
            $existing = Pig::where('pen_id', $pen->id)->count();
            $validated['tag'] = PenController::generateUniqueTag($pen->name, $existing + 1);
        } else {
            // Validate uniqueness only when manually entered
            if (Pig::where('tag', $validated['tag'])->exists()) {
                return response()->json(['success' => false, 'message' => 'Ear tag "' . $validated['tag'] . '" is already taken. Please choose another.'], 422);
            }
        }

        $pig = Pig::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pig #' . $pig->tag . ' added successfully!',
            'pig'     => $pig
        ]);
    }


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
            'tag' => 'required|string|max:255|unique:pigs,tag,' . $pig->id,
            'birth_date' => 'nullable|date',
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
            'is_critical_alert' => $request->boolean('is_critical_alert')
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

    /**
     * Display a detailed record for the admin.
     */
    public function adminShow(Pig $pig)
    {
        $pig->load(['pen', 'activities.user', 'healthReports.user', 'tasks.assignee']);
        $workers = \App\Models\User::where('role', 'farm_worker')->get();
        $pens = \App\Models\Pen::all(); // Load pens for relocation
        return view('admin.pigs.details_modal', compact('pig', 'workers', 'pens'));
    }

    public function acknowledgeActivity(Request $request, PigActivity $activity)
    {
        $validated = $request->validate([
            'admin_response' => 'required|string',
            'health_status' => 'required|string',
            'feeding_status' => 'required|string',
            'new_pen_id' => 'nullable|exists:pens,id',
        ]);

        $activity->update([
            'admin_response' => $validated['admin_response'],
            'new_health_status' => $validated['health_status'],
            'new_feeding_status' => $validated['feeding_status'],
            'acknowledged_at' => now(),
            'acknowledged_by' => auth()->id(),
        ]);

        // Update the Pig's master record
        $updateData = [
            'health_status' => $validated['health_status'],
            'feeding_status' => $validated['feeding_status'],
        ];
        
        if (!empty($validated['new_pen_id'])) {
            $updateData['pen_id'] = $validated['new_pen_id'];
        }

        $activity->pig->update($updateData);

        return response()->json([
            'success' => true,
            'message' => 'Care update successfully logged and pig relocated.'
        ]);
    }

    public function movePen(Request $request, Pig $pig) 
    {
        $validated = $request->validate([
            'pen_id' => 'required|exists:pens,id'
        ]);

        $oldPen = $pig->pen->name ?? 'Unknown';
        $pig->update(['pen_id' => $validated['pen_id']]);
        $newPen = $pig->fresh()->pen->name;

        \App\Models\PigActivity::create([
            'pig_id' => $pig->id,
            'type' => 'Movement',
            'action' => 'Pen Relocation',
            'details' => "Pig moved from $oldPen to $newPen.",
            'created_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => "Successfully moved to $newPen."
        ]);
    }

    /**
     * Remove the specified pig from storage.
     */
    public function destroy(Pig $pig)
    {
        $pig->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pig record deleted successfully!'
        ]);
    }
}