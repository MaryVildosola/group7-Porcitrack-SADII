<?php

namespace App\Http\Controllers;

use App\Models\Pig;
use App\Models\PigHealthReport;
use App\Models\PigActivity;
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
            ],
        ]);
    }

    /**
     * Save health report for a pig
     */
    public function saveHealthReport(Request $request)
    {
        $pigInput = $request->input('pig_id');
        $pig = Pig::where('id', $pigInput)->orWhere('tag', $pigInput)->first();

        if (!$pig) {
            return response()->json(['error' => 'Pig not found in database'], 404);
        }

        $validated = $request->validate([
            'symptom' => 'required|string',
            'body_condition_score' => 'nullable|integer|between:1,5',
            'feeding_behavior' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'physical_checks' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $validated['pig_id'] = $pig->id;
        $validated['user_id'] = Auth::id();

        $report = PigHealthReport::create($validated);

        // Update pig status and log activity
        $pig = Pig::find($validated['pig_id']);
        if ($pig) {
            // Update pig's health status based on report
            $pig->health_status = ($validated['symptom'] === 'Healthy') ? 'Healthy' : 'Sick';
            $pig->save();

            // Log activity
            PigActivity::create([
                'pig_id' => $pig->id,
                'user_id' => Auth::id(),
                'type' => ($validated['symptom'] === 'Healthy') ? 'Health Check' : 'Medical',
                'action' => 'Health Report: ' . $validated['symptom'],
                'details' => $validated['notes'] ?? 'Standard health check performed.',
            ]);

            // Update pen stats if sick
            if ($pig->health_status === 'Sick' || ($validated['feeding_behavior'] ?? '') === 'Poor/None') {
                $pig->pen->increment('sick_pigs');
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Health report saved successfully',
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
