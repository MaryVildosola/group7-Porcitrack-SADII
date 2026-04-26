<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\FeedMixController;
use App\Http\Controllers\FeedIngredientController;
use App\Http\Controllers\Worker\WorkerFeedFormulaController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PenController;
use App\Http\Controllers\PigController;
use App\Http\Controllers\HealthController;

// --- PUBLIC & REDIRECTS ---
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/dashboard', function (Request $request) {
    if ($request->user()->role === 'admin') {
        return redirect('/admin/dashboard');
    }
    elseif ($request->user()->role === 'farm_worker') {
        return redirect('/worker/dashboard');
    }
    return abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

// --- ADMIN ZONE ---
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
            $pendingTasks = \App\Models\Task::where('status', 'pending')->count();
            $totalPigs = \App\Models\Pig::where('status', 'active')->count();
            $sickPigs = \App\Models\Pen::sum('sick_pigs');

            $totalDelivered = \App\Models\FeedDelivery::sum('quantity');
            $totalConsumed = \App\Models\FeedConsumption::sum('quantity');
            $availableStock = max($totalDelivered - $totalConsumed, 0);
            $recentTasks = \App\Models\Task::with('assignee')->latest()->limit(5)->get();

            return view('users.dashboard', compact(
            'pendingTasks', 'totalPigs', 'sickPigs', 'availableStock', 'recentTasks'
            ));
        }
        )->name('admin.dashboard');

        Route::post('/pigs/{pig}/sell-dispose', [PigController::class, 'sellOrDispose'])->name('pigs.sellOrDispose');

        // Pens Management
        Route::get('/pens/index', [PenController::class, 'index'])->name('pens.index');
        Route::post('/pens/store', [PenController::class, 'store'])->name('pens.store');
        Route::put('/pens/{pen}', [PenController::class, 'update'])->name('pens.update');
        Route::delete('/pens/{pen}', [PenController::class, 'destroy'])->name('pens.destroy');
        Route::get('/pens/{pen}', [PenController::class, 'show'])->name('pens.show');
        Route::get('/api/pens/next-tag', [PenController::class, 'nextTag'])->name('pens.next-tag');

        // Individual Pig management for Admin
        Route::get('/admin/pigs/{pig}', [PigController::class, 'adminShow'])->name('admin.pigs.show');
        Route::post('/admin/pigs/store', [PigController::class, 'store'])->name('admin.pigs.store');
        Route::post('/admin/pigs/{pig}/move-pen', [PigController::class, 'movePen'])->name('admin.pigs.move-pen');
        Route::post('/admin/pigs/{pig}/update', [PigController::class, 'updateRecord'])->name('admin.pigs.update');
        Route::delete('/admin/pigs/{pig}', [PigController::class, 'destroy'])->name('admin.pigs.destroy');

        // User Management
        Route::get('users/index', [ProfileController::class, 'getAllUsers'])->name('users.index');
        Route::get('users/create', [ProfileController::class, 'create'])->name('users.create');
        Route::get('users/{id}/edit', [ProfileController::class, 'editUser'])->name('users.edit');
        Route::post('users/store', [ProfileController::class, 'store'])->name('users.store');
        Route::put('users/update/{id}', [ProfileController::class, 'updateUser'])->name('users.update');
        Route::delete('users/destroy/{id}', [ProfileController::class, 'destroyUser'])->name('users.destroy');

        // Feed & Inventory
        Route::get('/admin/feed-stock', [InventoryController::class, 'index'])->name('admin.feed-stock.index');
        Route::post('/admin/feed-stock', [InventoryController::class, 'store'])->name('admin.feed-stock.store');
        Route::get('/admin/qr-labels', [InventoryController::class, 'qrGenerator'])->name('admin.qr.index');

        Route::resource('admin/feed-mix', FeedMixController::class)->names('admin.feed-mix');
        Route::resource('admin/feed-ingredients', FeedIngredientController::class)->names('admin.feed-ingredients');

        // Admin Tasks & Reports
        Route::get('/admin/tasks', [TaskController::class, 'adminIndex'])->name('admin.tasks.index');
        Route::post('/admin/tasks', [TaskController::class, 'store'])->name('admin.tasks.store');
        Route::delete('/admin/tasks/{task}', [TaskController::class, 'destroy'])->name('admin.tasks.destroy');

        Route::get('/admin/weekly-reports', [ReportController::class, 'adminIndex'])->name('admin.reports');
        Route::get('/admin/weekly-reports/{id}', [ReportController::class, 'show'])->name('admin.reports.show');

        Route::post('/admin/pigs/activities/{activity}/acknowledge', [PigController::class, 'acknowledgeActivity'])->name('admin.pigs.activities.acknowledge');
    });

// --- WORKER ZONE ---
Route::middleware(['auth', 'verified', 'role:farm_worker'])->group(function () {
        Route::get('/worker/dashboard', [ReportController::class, 'dashboard'])->name('worker.dashboard');

        Route::get('/worker/tasks', [TaskController::class, 'workerIndex'])->name('worker.tasks');
        Route::post('/worker/tasks/{task}/complete', [TaskController::class, 'updateStatus'])->name('worker.tasks.complete');

        Route::get('/worker/alerts', function () {
            return view('worker.alerts');
        }
        )->name('worker.alerts');

        Route::get('/worker/activity-log', function () {
            return view('worker.activityLog');
        }
        )->name('worker.activity-log');

        Route::get('/worker/settings', function () { return view('worker.settings'); })->name('worker.settings');

        // Health & Monitoring API (Used by QR Scanner)
        Route::get('/api/health/pig/{tag}', [HealthController::class, 'getPigData'])->name('api.health.pig');
        Route::post('/api/health/report', [HealthController::class, 'saveHealthReport'])->name('api.health.report');
        Route::get('/api/health/history/{pigId}', [HealthController::class, 'getPigHealthHistory'])->name('api.health.history');
        Route::post('/worker/settings/update', [ProfileController::class, 'updateWorkerSettings'])->name('worker.settings.update');

        Route::get('/worker/weekly-reports', [ReportController::class, 'workerIndex'])->name('worker.reports');
        Route::post('/worker/weekly-reports/store', [ReportController::class, 'store'])->name('worker.reports.store');

        // --- SWINE DETAILS ---
        Route::get('/worker/swine-details', function () {
            $thisWeek = \Carbon\Carbon::now()->startOfWeek();
            $pens = \App\Models\Pen::with(['pigs' => function($q) {
                $q->whereNotIn('status', ['Sold', 'Disposed']);
            }])->get();

            try {
                $existingReport = \App\Models\Task::where(function ($q) {
                            $q->where('user_id', auth()->id())->orWhere('assigned_to', auth()->id());
                        }
                        )->where('status', 'completed')->whereBetween('updated_at', [$thisWeek, \Carbon\Carbon::now()->endOfWeek()])->exists();
            }
            catch (\Exception $e) {
                $existingReport = false;
            }

            try {
                $analytics = [
                    'total_pigs' => \App\Models\Pig::whereNotIn('status', ['Sold', 'Disposed'])->count() ?? 0,
                    'sick_pigs' => \App\Models\Pig::where('health_status', 'Sick')->count() ?? 0,
                    'avg_weight' => \App\Models\Pig::whereNotIn('status', ['Sold', 'Disposed'])->avg('weight') ?? 0,
                    'active_pens' => \App\Models\Pen::where('is_active', true)->count() ?? 0,
                ];
            }
            catch (\Exception $e) {
                $analytics = ['total_pigs' => 0, 'sick_pigs' => 0, 'avg_weight' => 0, 'active_pens' => 0];
            }

            return view('worker.swineDetails', compact('thisWeek', 'existingReport', 'analytics', 'pens'));
        })->name('worker.swineDetails');

        Route::get('/worker/pigs/{pig}', [PigController::class, 'show'])->name('worker.pigs.show');
        Route::post('/worker/pigs/{pig}/update', [PigController::class, 'updateRecord'])->name('worker.pigs.update');
        Route::post('/worker/pigs/{pig}/log-activity', [PigController::class, 'logActivity'])->name('worker.pigs.log-activity');

        Route::post('/worker/sync-logs', [App\Http\Controllers\Worker\SyncController::class, 'sync'])->name('worker.sync');
        Route::get('/worker/feed-formulas', [WorkerFeedFormulaController::class, 'index'])->name('worker.feed-formulas');
    });

// --- SHARED ZONE (All Auth Users) ---
Route::middleware('auth')->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'editOwnProfile'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'updateOwnProfile'])->name('profile.update');

    // TEST ROUTE: Generate a critical alert for the first pig found
    Route::get('/admin/medical-emergency-test', function() {
        $pig = \App\Models\Pig::first();
        if(!$pig) return "No pigs found in database.";
        
        \App\Models\PigActivity::create([
            'pig_id' => $pig->id,
            'type' => 'Medical',
            'action' => '🚨 CRITICAL ALERT — Health In Danger',
            'details' => 'TEST ALERT: This is a simulated emergency for testing the notification system.',
            'is_critical_alert' => true,
            'created_at' => now(),
        ]);
        
        return redirect()->back()->with('success', 'Critical alert generated for Pig #' . $pig->tag);
    })->name('admin.test-alert');
});

require __DIR__ . '/auth.php';