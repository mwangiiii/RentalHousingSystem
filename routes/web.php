<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LockScreenController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard',[HomeController::class,'dashboard'])
    // function () {
        //     return view('dashboard');})
        ->name('dashboard');
});


// Route::get('/dashboard', [HomeController::class,'dashboard'])->name('dashboard');
// Routes for the lock screen
Route::get('/lock_screen',[LockScreenController::class,'lockscreen'])->name('lock-screen');
Route::post('/unlock_screen',[LockScreenController::class,'unlock'])->name('unlock');
Route::post('/manual_screen', [LockScreenController::class, 'manualLock'])->name('manual-lock');
Route::post('/auto_screen', [LockScreenController::class, 'autoLock'])->name('auto-lock');

    



