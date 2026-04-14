<?php

namespace App\Http\Controllers;

use App\Models\WeeklyReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Admin View: List all workers and their submission status
    public function adminIndex()
    {
        $workers = User::where('role', 'farm_worker')->get();
        $thisWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        
        $reports = WeeklyReport::with('user')
            ->where('week_start_date', $thisWeek)
            ->get()
            ->keyBy('user_id');

        return view('admin.reports.index', compact('workers', 'reports', 'thisWeek'));
    }

    // Admin View: Show specific report details
    public function show($id)
    {
        $report = WeeklyReport::with('user')->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }

    // Worker View: Show report submission form
    public function workerIndex()
    {
        $user = Auth::user();
        $thisWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        
        $existingReport = WeeklyReport::where('user_id', $user->id)
            ->where('week_start_date', $thisWeek)
            ->first();

        // Mock Analytics Data for the Worker
        $analytics = [
            'total_pigs' => 452,
            'sick_pigs' => 3,
            'avg_weight' => 68.5,
            'feed_stock' => 78,
            'tasks_done' => 12,
            'tasks_pending' => 4,
            'weekly_progress' => [65, 78, 72, 85, 80, 90, 88] // for chart
        ];

        return view('worker.reports.index', compact('user', 'existingReport', 'thisWeek', 'analytics'));
    }

    // Worker Action: Store weekly report
    public function store(Request $request)
    {
        $request->validate([
            'details' => 'required|string|min:10',
            'total_pigs' => 'required|integer',
            'sick_pigs' => 'required|integer',
            'avg_weight' => 'required|numeric',
            'feed_consumed' => 'required|numeric',
        ]);

        $thisWeek = Carbon::now()->startOfWeek()->format('Y-m-d');

        WeeklyReport::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'week_start_date' => $thisWeek,
            ],
            [
                'total_pigs' => $request->total_pigs,
                'sick_pigs' => $request->sick_pigs,
                'avg_weight' => $request->avg_weight,
                'feed_consumed' => $request->feed_consumed,
                'details' => $request->details,
                'status' => 'submitted'
            ]
        );

        return redirect()->route('worker.reports')->with('success', 'Weekly report submitted successfully!');
    }
}
