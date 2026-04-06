<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subject;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of enrollments.
     */
    public function index(): View
    {
        $enrollments = Enrollment::with(['user', 'subject'])->orderBy('created_at', 'desc')->paginate(10);
        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new enrollment.
     */
    public function create(): View
    {
        $users = User::all();
        $subjects = Subject::where('is_active', true)->get();
        return view('enrollments.create', compact('users', 'subjects'));
    }

    /**
     * Store a newly created enrollment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'school_year' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:255',
            'date_enrolled' => 'nullable|date',
            'enrollment_status' => 'required|string|max:255',
        ]);

        Enrollment::create($validated);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment created successfully.');
    }

    /**
     * Display the specified enrollment.
     */
    public function show(Enrollment $enrollment)
    {
        return view('enrollments.show', compact('enrollment'));
    }

    /**
     * Show the form for editing the specified enrollment.
     */
    public function edit(Enrollment $enrollment)
    {
        $users = User::all();
        $subjects = Subject::where('is_active', true)->get();
        return view('enrollments.edit', compact('enrollment', 'users', 'subjects'));
    }

    /**
     * Update the specified enrollment in storage.
     */
    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'school_year' => 'nullable|string|max:255',
            'semester' => 'nullable|string|max:255',
            'date_enrolled' => 'nullable|date',
            'enrollment_status' => 'required|string|max:255',
        ]);

        $enrollment->update($validated);

        return redirect()->route('enrollments.index')->with('success', 'Enrollment updated successfully.');
    }

    /**
     * Remove the specified enrollment from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('enrollments.index')->with('success', 'Enrollment deleted successfully.');
    }
}
