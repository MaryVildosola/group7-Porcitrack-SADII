<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the subjects.
     */
    public function index()
    {
        $totalPigs = \App\Models\Pig::whereNotIn('status', ['Sold', 'Disposed'])->count();
        $sickPigs = \App\Models\Pig::where('health_status', 'Sick')->count();
        
        // Estimated Recovery Rate (Healthy pigs / Total Pigs that were ever sick - simplified)
        // For now, let's just show a realistic dynamic number or count healthy vs total
        $healthyPigs = \App\Models\Pig::where('health_status', 'Healthy')->count();
        $recoveryRate = $totalPigs > 0 ? round(($healthyPigs / $totalPigs) * 100) : 0;

        // Total Costs (Sum of batch costs from pens)
        $totalCosts = \App\Models\Pen::sum('batch_cost'); 
        // Note: batch_cost is a string in the DB currently, might need casting or cleaning if it has symbols
        
        $avgFeedCost = \App\Models\FeedIngredient::avg('cost_per_sack') ?? 0;

        return view('subject.index', compact('totalPigs', 'sickPigs', 'recoveryRate', 'totalCosts', 'avgFeedCost'));
    }

    /**
     * Show the form for creating a new subject.
     */
    public function create()
    {
        return view('subject.create');
    }

    /**
     * Store a newly created subject in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'curriculum_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:subjects,code',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        Subject::create($validated);

        return redirect()->route('subject.index')->with('success', 'Subject created successfully.');
    }

    /**
     * Display the specified subject.
     */
    public function show(Subject $subject)
    {
        return view('subject.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified subject.
     */
    public function edit(Subject $subject)
    {
        return view('subject.edit', compact('subject'));
    }

    /**
     * Update the specified subject in storage.
     */
    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'curriculum_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $subject->update($validated);

        return redirect()->route('subject.index')->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified subject from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subject.index')->with('success', 'Subject deleted successfully.');
    }
}
