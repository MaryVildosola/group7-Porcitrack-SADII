<?php

namespace App\Http\Controllers;

use App\Models\Pig;
use App\Models\PigHealthReport;
use App\Models\PigActivity;
use App\Models\FeedConsumption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HealthController extends Controller
{
    /**
     * Get pig data by tag/ID from QR code
     */
    public function getPigData($tag)
    {
        $pig = Pig::with('pen', 'latestHealthReport')
            ->where('tag', $tag)
            ->orWhere('id', $tag)
            ->first();

        if (!$pig) {
            return response()->json(['error' => 'Pig not found'], 404);
        }

        $latestReport = $pig->latestHealthReport;
        
        // Fetch tasks for the pig OR its current pen
        $tasks = \App\Models\Task::where(function($q) use ($pig) {
                $q->where('pig_id', $pig->id)
                  ->orWhere(function($sq) use ($pig) {
                      $sq->where('pen_id', $pig->pen_id)->whereNull('pig_id');
                  });
            })
            ->where('status', '!=', 'completed')
            ->orderByRaw('assigned_to = ? DESC', [Auth::id()]) // Personal tasks first
            ->get();

        return response()->json([
            'success' => true,
            'pig' => [
                'id' => $pig->id,
                'tag' => $pig->tag,
                'pen_id' => $pig->pen_id,
                'pen_name' => $pig->pen->name ?? 'Unknown',
                'birth_date' => $pig->birth_date?->format('Y-m-d'),
                'age_days' => $pig->getAgeInDaysAttribute(),
                'growth_stage' => $pig->getGrowthStageAttribute(),
                'status' => $pig->status,
                'last_check' => $latestReport?->created_at?->diffForHumans() ?? 'Never',
                'last_symptom' => $latestReport?->symptom ?? 'Unknown',
                'tasks' => $tasks->map(function($t) {
                    return array_merge($t->toArray(), [
                        'is_mine' => $t->assigned_to == Auth::id()
                    ]);
                })
            ],
        ]);
    }

    public function getPenData($id)
    {
        $pen = \App\Models\Pen::where('id', $id)->orWhere('name', $id)->first();
        if (!$pen) return response()->json(['error' => 'Pen not found'], 404);

        $tasks = \App\Models\Task::where('pen_id', $pen->id)
            ->where('status', '!=', 'completed')
            ->orderByRaw('assigned_to = ? DESC', [Auth::id()]) // Personal tasks first
            ->get();

        return response()->json([
            'success' => true,
            'pen' => [
                'id' => $pen->id,
                'name' => $pen->name,
                'section' => $pen->section,
                'healthy_pigs' => $pen->healthy_pigs,
                'sick_pigs' => $pen->sick_pigs,
                'tasks' => $tasks->map(function($t) {
                    return array_merge($t->toArray(), [
                        'is_mine' => $t->assigned_to == Auth::id()
                    ]);
                })
            ]
        ]);
    }

    /**
     * Save a pen-level feeding log
     */
    public function savePenLog(Request $request)
    {
        $validated = $request->validate([
            'pen_id'        => 'required',
            'quantity'      => 'required|numeric|min:0.1',
            'water_status'  => 'nullable|string',
            'hygiene_status'=> 'nullable|string',
            'notes'         => 'nullable|string',
            'completed_tasks' => 'nullable|array',
        ]);

        $pen = \App\Models\Pen::find($validated['pen_id']);
        if (!$pen) return response()->json(['error' => 'Pen not found'], 404);

        // Save the feed consumption record
        FeedConsumption::create([
            'pen_id'           => $pen->id,
            'feed_type'        => 'Standard',
            'quantity'         => $validated['quantity'],
            'consumption_date' => now()->toDateString(),
            'user_id'          => Auth::id(),
        ]);

        // Log the activity
        $notes = "Water: " . ($validated['water_status'] ?? 'OK') .
                 " | Hygiene: " . ($validated['hygiene_status'] ?? 'OK') .
                 ($validated['notes'] ? ' | ' . $validated['notes'] : '');

        // Use first active pig in pen for the activity log (or create a pen-level log)
        $pig = $pen->pigs()->whereNotIn('status', ['Sold', 'Disposed'])->first();
        if ($pig) {
            PigActivity::create([
                'pig_id'  => $pig->id,
                'user_id' => Auth::id(),
                'type'    => 'Care',
                'action'  => 'Batch Feeding — ' . $validated['quantity'] . 'kg',
                'details' => $pen->name . ' | ' . $notes,
            ]);
        }

        // Mark completed tasks
        if (!empty($validated['completed_tasks'])) {
            \App\Models\Task::whereIn('id', $validated['completed_tasks'])
                ->update(['status' => 'completed', 'completed_at' => now()]);
        }

        return response()->json(['success' => true, 'message' => 'Feeding log saved.']);
    }

    /**
     * Save health report for a pig
     */
    public function saveHealthReport(Request $request)
    {
        $pigInput = $request->input('pig_id');
        
        // Handle Task Completion FIRST (independent of pig existence check)
        if ($request->has('completed_tasks') && is_array($request->input('completed_tasks'))) {
            \App\Models\Task::whereIn('id', $request->input('completed_tasks'))
                ->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                    'findings' => ['log' => 'Completed during assessment/feeding log']
                ]);
        }

        $pig = Pig::where('id', $pigInput)->orWhere('tag', $pigInput)->first();

        // If it's a PEN- based request and we only care about tasks, we can stop here
        if (!$pig && str_starts_with((string)$pigInput, 'PEN-')) {
            return response()->json(['success' => true, 'message' => 'Pen tasks updated']);
        }

        if (!$pig) {
            return response()->json(['error' => 'Animal record not found'], 404);
        }

        $validated = $request->validate([
            'symptom' => 'required|string',
            'body_condition_score' => 'nullable|integer|between:1,5',
            'feeding_behavior' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'physical_checks' => 'nullable|array',
            'notes' => 'nullable|string',
            'water_intake' => 'nullable|string',
        ]);

        $validated['pig_id'] = $pig->id;
        $validated['user_id'] = Auth::id();

        if (!empty($validated['water_intake'])) {
            $validated['notes'] = "Water: " . $validated['water_intake'] . " | " . ($validated['notes'] ?? '');
        }

        $report = PigHealthReport::create($validated);

        // Update pig status and log activity
        if ($pig) {
            $oldStatus = $pig->health_status;
            $newStatus = ($validated['symptom'] === 'Healthy') ? 'Healthy' : 'Sick';
            
            // Handle Pen Relocation
            $movePenId = $request->input('move_pen_id');
            if ($movePenId && $movePenId != $pig->pen_id) {
                $oldPen = $pig->pen;
                $newPen = \App\Models\Pen::find($movePenId);
                if ($newPen) {
                    $pig->pen_id = $newPen->id;
                    PigActivity::create([
                        'pig_id' => $pig->id,
                        'user_id' => Auth::id(),
                        'type' => 'Care',
                        'action' => 'Relocated to ' . $newPen->name,
                        'details' => "Moved from {$oldPen->name} to {$newPen->name} during daily check-in.",
                    ]);
                }
            }

            $pig->health_status = $newStatus;
            if ($request->filled('weight')) $pig->weight = $request->input('weight');
            $pig->save();

            PigActivity::create([
                'pig_id' => $pig->id,
                'user_id' => Auth::id(),
                'type' => ($newStatus === 'Healthy') ? 'Health Check' : 'Medical',
                'action' => 'Daily Assessment: ' . $validated['symptom'],
                'details' => $validated['notes'] ?? 'Comprehensive health check performed.',
                'is_critical_alert' => ($newStatus === 'Sick')
            ]);

            if ($oldStatus !== $newStatus) {
                if ($newStatus === 'Sick') {
                    $pig->pen->increment('sick_pigs');
                    $pig->pen->decrement('healthy_pigs');
                } else {
                    $pig->pen->decrement('sick_pigs');
                    $pig->pen->increment('healthy_pigs');
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Assessment saved and tasks updated',
            'report' => $report,
        ]);
    }

    /**
     * Get health history for a specific pig
     */
    public function getPigHealthHistory($pigId)
    {
        $reports = PigHealthReport::where('pig_id', $pigId)
            ->with('user')
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->map(function ($report) {
                return [
                    'id' => $report->id,
                    'symptom' => $report->symptom,
                    'bcs' => $report->body_condition_score,
                    'feeding' => $report->feeding_behavior,
                    'weight' => $report->weight,
                    'notes' => $report->notes,
                    'reported_by' => $report->user->name,
                    'created_at' => $report->created_at->format('Y-m-d H:i'),
                    'time_ago' => $report->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'success' => true,
            'history' => $reports,
        ]);
    }

    /**
     * Get health reports for all pigs in a pen
     */
    public function getPenHealthReports($penId)
    {
        $reports = PigHealthReport::whereHas('pig', function ($q) use ($penId) {
            $q->where('pen_id', $penId);
        })
            ->with('pig', 'user')
            ->latest('created_at')
            ->get()
            ->groupBy('pig_id')
            ->map(function ($pigReports) {
                $latestReport = $pigReports->first();
                return [
                    'pig_id' => $latestReport->pig_id,
                    'pig_tag' => $latestReport->pig->tag,
                    'symptom' => $latestReport->symptom,
                    'feeding' => $latestReport->feeding_behavior,
                    'weight' => $latestReport->weight,
                    'bcs' => $latestReport->body_condition_score,
                    'notes' => $latestReport->notes,
                    'reported_by' => $latestReport->user->name,
                    'created_at' => $latestReport->created_at->format('Y-m-d H:i'),
                    'time_ago' => $latestReport->created_at->diffForHumans(),
                    'report_count' => $pigReports->count(),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'reports' => $reports,
        ]);
    }
}
