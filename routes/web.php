<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LockerController;
use Illuminate\Support\Facades\Route;

// Home route
Route::get('/', [LockerController::class, 'index'])->name('welcome');

// Block any route to register
Route::match(['get', 'post'], 'register', function () {
    return redirect()->route('welcome');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    //
});

// Admin-specific routes
Route::middleware(['auth', 'admin'])->group(function() {
    // Admin dashboard
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // Admin activity page
    Route::get('admin/activity', [AdminController::class, 'activity'])->name('admin.activity');
    
    // Profile edit routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('admin/activity', [AdminController::class, 'activity'])->name('admin.activity');
Route::get('admin/activity/finish/{id}', [AdminController::class, 'finish'])->name('admin.activity.finish');


    // Locker reservation route (to reserve up to 5 lockers)
    Route::post('admin/locker/reserve', [AdminController::class, 'reserveLockers'])->name('admin.locker.reserve');
    
    // Locker pickup confirmation route (to confirm locker availability after item is picked up)
    Route::post('admin/locker/pickup', [AdminController::class, 'confirmPickup'])->name('admin.locker.pickup');
});

// Include authentication routes
require __DIR__.'/auth.php';
