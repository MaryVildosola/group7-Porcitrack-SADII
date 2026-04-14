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
     */
    public function sync(Request $request)
    {
        $logs = $request->input('logs', []);
        $userId = Auth::id();

        if (empty($logs)) {
            return response()->json(['status' => 'success', 'message' => 'No logs to sync.']);
        }

        // Find or create the current week's report for this user
        $report = WeeklyReport::firstOrCreate(
            [
                'user_id' => $userId,
                'week_start_date' => Carbon::now()->startOfWeek(),
            ],
            [
                'status' => 'draft',
                'total_pigs' => 452, // Mocking current total for now
            ]
        );

        foreach ($logs as $log) {
            if ($log['type'] === 'feeding') {
                $report->feed_consumed += (float)$log['qty'];
            } elseif ($log['type'] === 'health') {
                if ($log['symptom'] !== 'Healthy') {
                    $report->sick_pigs += 1;
                }
            }
        }

        $report->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Logs synchronized successfully.',
            'report' => $report
        ]);
    }
}
