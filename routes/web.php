<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LockerController;
use Illuminate\Support\Facades\Route;


Route::get('/', [LockerController::class, 'index'])->name('welcome');


Route::match(['get', 'post'], 'register', function () {
    return redirect()->route('welcome');
});


Route::middleware('auth')->group(function () {
    
});


Route::middleware(['auth', 'admin'])->group(function() {
    
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    
    Route::get('admin/activity', [AdminController::class, 'activity'])->name('admin.activity');
    
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('admin/activity', [AdminController::class, 'activity'])->name('admin.activity');
Route::get('admin/activity/finish/{id}', [AdminController::class, 'finish'])->name('admin.activity.finish');
Route::post('/admin/activity/finish/confirm/{id}', [AdminController::class, 'finishConfirm'])->name('admin.activity.finish.confirm');


    
    Route::post('admin/locker/reserve', [AdminController::class, 'reserveLockers'])->name('admin.locker.reserve');
    
    
    Route::post('admin/locker/pickup', [AdminController::class, 'confirmPickup'])->name('admin.locker.pickup');
});


require __DIR__.'/auth.php';
