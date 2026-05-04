<?php

namespace App\Http\Controllers;

use App\Models\Pig;
use App\Models\Pen;
use App\Models\Task;
use App\Models\PigSale;
use App\Models\PigActivity;
use App\Models\FeedDelivery;
use App\Models\FeedConsumption;
use App\Models\User;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // --- LIVESTOCK KPIs ---
        $totalPigs = Pig::whereNotIn('status', ['Sold', 'Disposed'])->count();
        $sickPigs = Pig::where('health_status', 'Sick')->whereNotIn('status', ['Sold', 'Disposed'])->count();
        $healthyPigs = $totalPigs - $sickPigs;
        $avgWeight = round(Pig::whereNotIn('status', ['Sold', 'Disposed'])->avg('weight') ?? 0, 1);
        $totalPens = Pen::count();
        $activePens = Pen::whereHas('pigs', function ($q) {
            $q->whereNotIn('status', ['Sold', 'Disposed']);
        })->count();

        // --- GROWTH STAGE BREAKDOWN ---
        $allPigs = Pig::whereNotIn('status', ['Sold', 'Disposed'])->get();
        $stageBreakdown = [
            'Piglet' => 0,
            'Starter' => 0,
            'Grower' => 0,
            'Finisher' => 0,
        ];
        foreach ($allPigs as $pig) {
            $stage = $pig->growth_stage;
            if (isset($stageBreakdown[$stage])) {
                $stageBreakdown[$stage]++;
            }
        }

        // --- HEALTH STATUS BREAKDOWN ---
        $healthBreakdown = [
            'Healthy' => Pig::where('health_status', 'Healthy')->whereNotIn('status', ['Sold', 'Disposed'])->count(),
            'Sick' => $sickPigs,
            'Under Observation' => Pig::where('health_status', 'Under Observation')->whereNotIn('status', ['Sold', 'Disposed'])->count(),
            'Recovering' => Pig::where('health_status', 'Recovering')->whereNotIn('status', ['Sold', 'Disposed'])->count(),
        ];

        // --- FEED INVENTORY ---
        $totalDelivered = FeedDelivery::sum('quantity');
        $totalConsumed = FeedConsumption::sum('quantity');
        $availableStock = max($totalDelivered - $totalConsumed, 0);

        // --- REVENUE / SALES ---
        $totalRevenue = PigSale::sum('amount') ?? 0;
        $totalSold = Pig::where('status', 'Sold')->count();
        $totalDisposed = Pig::where('status', 'Disposed')->count();

        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = PigSale::whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->sum('amount');
            $monthlyRevenue[] = [
                'label' => $month->format('M'),
                'value' => $revenue,
            ];
        }

        // --- TASK METRICS ---
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $overdueTasks = Task::where('status', 'pending')
            ->where('due_date', '<', Carbon::today())
            ->count();

        // --- WORKERS ---
        $totalWorkers = User::where('role', 'farm_worker')->count();

        // --- PEN OCCUPANCY (for chart) ---
        $penData = Pen::withCount(['pigs' => function ($q) {
            $q->whereNotIn('status', ['Sold', 'Disposed']);
        }])->orderBy('name')->get();

        // --- RECENT ACTIVITIES ---
        $recentActivities = PigActivity::with('pig')
            ->latest()
            ->limit(8)
            ->get();

        // --- WEIGHT DISTRIBUTION (for chart) ---
        $weightRanges = [
            '0-10kg' => Pig::whereNotIn('status', ['Sold', 'Disposed'])->where('weight', '<=', 10)->count(),
            '10-30kg' => Pig::whereNotIn('status', ['Sold', 'Disposed'])->whereBetween('weight', [10.1, 30])->count(),
            '30-60kg' => Pig::whereNotIn('status', ['Sold', 'Disposed'])->whereBetween('weight', [30.1, 60])->count(),
            '60-90kg' => Pig::whereNotIn('status', ['Sold', 'Disposed'])->whereBetween('weight', [60.1, 90])->count(),
            '90kg+' => Pig::whereNotIn('status', ['Sold', 'Disposed'])->where('weight', '>', 90)->count(),
        ];

        // --- DISEASE RISK PREDICTION (Smart Engine) ---
        $regionalDiseases = \App\Models\RegionalDisease::where('is_active', true)->get();
            
        // Calculate base regional risk factor
        $baseRegionalRisk = 0;
        foreach($regionalDiseases as $rd) {
            if ($rd->level == 'High') $baseRegionalRisk += 15;
            elseif ($rd->level == 'Medium') $baseRegionalRisk += 5;
        }
        
        // 2. Pen Risk Calculation
        $penRisks = [];
        $pens = Pen::withCount(['pigs as sick_count' => function($q) {
            $q->where('health_status', 'Sick')->whereNotIn('status', ['Sold', 'Disposed']);
        }])->get();

        foreach($pens as $pen) {
            // Count historical medical activities for pigs in this pen
            $historicalSickness = PigActivity::where('type', 'Medical')
                ->whereHas('pig', function($q) use ($pen) {
                    $q->where('pen_id', $pen->id);
                })->count();

            $activeSickness = $pen->sick_count;

            // Algorithm: 
            // - Every active sick pig adds 25% risk.
            // - Every historical sickness incident adds 5% risk.
            // - Base regional risk factor is computed from active regional diseases.
            $riskScore = $baseRegionalRisk + ($activeSickness * 25) + ($historicalSickness * 5);
            $riskScore = min($riskScore, 100); // Cap at 100%

            $status = 'Safe';
            $color = 'bg-green-100 text-green-700';
            $recommendation = 'Maintain standard biosecurity protocols.';

            if ($riskScore >= 75) {
                $status = 'Critical Risk';
                $color = 'bg-red-100 text-red-700';
                $recommendation = 'Immediate isolation required. High probability of ASF or severe infection spread.';
            } elseif ($riskScore >= 40) {
                $status = 'Elevated Risk';
                $color = 'bg-yellow-100 text-yellow-700';
                $recommendation = 'Increase sanitation frequency. Monitor closely for symptoms of PED or Swine Flu.';
            }

            if ($activeSickness > 0 || $riskScore > 15) {
                $penRisks[] = (object)[
                    'pen_name' => $pen->name,
                    'risk_score' => $riskScore,
                    'active_cases' => $activeSickness,
                    'historical_cases' => $historicalSickness,
                    'status' => $status,
                    'color' => $color,
                    'recommendation' => $recommendation
                ];
            }
        }
        
        // Sort descending by risk score
        usort($penRisks, function($a, $b) {
            return $b->risk_score <=> $a->risk_score;
        });

        return view('admin.analytics.index', compact(
            'totalPigs', 'sickPigs', 'healthyPigs', 'avgWeight',
            'totalPens', 'activePens',
            'stageBreakdown', 'healthBreakdown',
            'totalDelivered', 'totalConsumed', 'availableStock',
            'totalRevenue', 'totalSold', 'totalDisposed', 'monthlyRevenue',
            'totalTasks', 'pendingTasks', 'completedTasks', 'overdueTasks',
            'totalWorkers', 'penData', 'recentActivities', 'weightRanges',
            'regionalDiseases', 'penRisks'
        ));
    }
}
