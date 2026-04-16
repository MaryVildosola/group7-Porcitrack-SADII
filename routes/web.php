<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

use Illuminate\Http\Request;

Route::get('/dashboard', function (Request $request) {
    if ($request->user()->role === 'admin') {
        return redirect('/admin/dashboard');
    } elseif ($request->user()->role === 'farm_worker') {
        return redirect('/worker/dashboard');
    }
    return abort(403);
})->middleware(['auth', 'verified'])->name('dashboard');

// --- ADMIN ZONE ---
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('users.dashboard'); // Placeholder for admin dashboard
    })->name('admin.dashboard');

    Route::get('/pens/index', function () {
        return view('pens.index'); 
    })->name('pens.index');

    Route::get('users/index', [ProfileController::class, 'getAllUsers'])->name('users.index');
    Route::get('users/create', [ProfileController::class, 'create'])->name('users.create');
    Route::get('users/{id}/edit', [ProfileController::class, 'editUser'])->name('users.edit');
    Route::post('users/store', [ProfileController::class, 'store'])->name('users.store');
    Route::put('users/update/{id}', [ProfileController::class, 'updateUser'])->name('users.update');
    Route::delete('users/destroy/{id}', [ProfileController::class, 'destroyUser'])->name('users.destroy');

    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('subject', SubjectController::class);

    Route::get('/admin/feed-stock', [InventoryController::class, 'index'])->name('admin.feed-stock.index');
    Route::post('/admin/feed-stock', [InventoryController::class, 'store'])->name('admin.feed-stock.store');
    Route::get('/admin/qr-labels', [InventoryController::class, 'qrGenerator'])->name('admin.qr.index');
});

// --- WORKER ZONE ---
Route::middleware(['auth', 'verified', 'role:farm_worker'])->group(function () {
    Route::get('/worker/dashboard', function () {
        return view('worker.dashboard'); // High-fidelity mobile worker dashboard
    })->name('worker.dashboard');

    Route::get('/worker/tasks', function () {
        return view('worker.task'); // Worker tasks page
    })->name('worker.tasks');

    Route::get('/worker/alerts', function () {
        return view('worker.alerts'); // Worker alerts page
    })->name('worker.alerts');

    Route::get('/worker/activity-log', function () {
        return view('worker.activityLog'); // Worker activity log page
    })->name('worker.activity-log');

    Route::get('/worker/settings', [ProfileController::class, 'workerSettings'])->name('worker.settings');
    Route::post('/worker/settings/update', [ProfileController::class, 'updateWorkerSettings'])->name('worker.settings.update');

    // Weekly Reports
    Route::get('/worker/weekly-reports', [ReportController::class, 'workerIndex'])->name('worker.reports');
    Route::post('/worker/weekly-reports/store', [ReportController::class, 'store'])->name('worker.reports.store');

    // PWA Offline Sync
    Route::post('/worker/sync-logs', [App\Http\Controllers\Worker\SyncController::class, 'sync'])->name('worker.sync');
});

// --- ADMIN ZONE (Protected by Auth and Admin Role) ---
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Other admin routes...
    Route::get('/admin/weekly-reports', [ReportController::class, 'adminIndex'])->name('admin.reports');
    Route::get('/admin/weekly-reports/{id}', [ReportController::class, 'show'])->name('admin.reports.show');
});

// --- SHARED ZONE (All Authenticated Users) ---
Route::middleware('auth')->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'editOwnProfile'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'updateOwnProfile'])->name('profile.update');
});


require __DIR__.'/auth.php';
