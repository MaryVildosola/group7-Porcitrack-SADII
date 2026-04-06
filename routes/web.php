<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('users.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('users/index', [ProfileController::class, 'getAllUsers'])
        ->name('users.index');

    Route::get('users/create', [ProfileController::class, 'create'])
        ->name('users.create');

    Route::get('users/{id}/edit', [ProfileController::class, 'editUser'])
        ->name('users.edit');

    Route::post('users/store', [ProfileController::class, 'store'])
        ->name('users.store');

    Route::put('users/update/{id}', [ProfileController::class, 'updateUser'])
        ->name('users.update');

    Route::delete('users/destroy/{id}', [ProfileController::class, 'destroyUser'])
        ->name('users.destroy');

    // Logged-in user editing their own profile
    Route::get('profile/edit', [ProfileController::class, 'editOwnProfile'])
        ->name('profile.edit');

    Route::put('profile/update', [ProfileController::class, 'updateOwnProfile'])
        ->name('profile.update');

    // Enrollment Routes
    Route::resource('enrollments', EnrollmentController::class);

    // Subject Routes
    Route::resource('subject', SubjectController::class);
});


require __DIR__.'/auth.php';
