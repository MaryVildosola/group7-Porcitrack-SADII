<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SubjectController;
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
});

// --- WORKER ZONE ---
Route::middleware(['auth', 'verified', 'role:farm_worker'])->group(function () {
    Route::get('/worker/dashboard', function () {
        return view('worker.dashboard'); // High-fidelity mobile worker dashboard
    })->name('worker.dashboard');
});

// --- SHARED ZONE (All Authenticated Users) ---
Route::middleware('auth')->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'editOwnProfile'])->name('profile.edit');
    Route::put('profile/update', [ProfileController::class, 'updateOwnProfile'])->name('profile.update');
});


require __DIR__.'/auth.php';
