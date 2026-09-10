<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/salons', [SalonController::class, 'index'])->name('salons.index');

    Route::middleware('role:administrateur,moderateur')->group(function () {
        Route::get('/salons/creer', [SalonController::class, 'create'])->name('salons.create');
        Route::post('/salons', [SalonController::class, 'store'])->name('salons.store');
    });

    Route::get('/salons/{salon}', [SalonController::class, 'show'])->name('salons.show');
    Route::post('/salons/{salon}/messages', [MessageController::class, 'store'])->name('messages.store');
});

require __DIR__.'/auth.php';