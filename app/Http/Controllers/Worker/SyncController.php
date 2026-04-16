<?php

namespace App\Http\Controllers\Worker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SyncController extends Controller
{
    /**
     * Handle the incoming offline logs from the Worker PWA.
     * NOTE: This does NOT create a weekly report record — only the worker's
     * explicit "Submit to HQ" action creates one. This prevents draft records
     * from being mistaken for a submitted report.
     */
    public function sync(Request $request)
    {
        $logs = $request->input('logs', []);
        $userId = Auth::id();

        if (empty($logs)) {
            return response()->json(['status' => 'success', 'message' => 'No logs to sync.']);
        }

        $thisWeek = Carbon::now()->startOfWeek()->format('Y-m-d');

        // Only update an ALREADY SUBMITTED report — never auto-create one
        $report = WeeklyReport::where('user_id', $userId)
            ->where('week_start_date', $thisWeek)
            ->where('status', 'submitted')
            ->first();

        if ($report) {
            // Append synced log data into the existing submitted report
            foreach ($logs as $log) {
                if ($log['type'] === 'feeding') {
                    $report->feed_consumed += (float)($log['qty'] ?? 0);
                } elseif ($log['type'] === 'health') {
                    if (($log['symptom'] ?? 'Healthy') !== 'Healthy') {
                        $report->sick_pigs += 1;
                    }
                }
            }
            $report->save();
        }
        // If no submitted report exists yet, logs are accepted but not persisted
        // to a report record — they live in the worker's localStorage until
        // they explicitly submit their weekly report.

        return response()->json([
            'status'  => 'success',
            'message' => 'Logs received. They will be included when you submit your weekly report.',
        ]);
    }
}
