<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PrivateMessageController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\AnnonceController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

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
    Route::get('/salons/{salon}/messages/nouveaux', [MessageController::class, 'nouveaux'])->name('messages.nouveaux');

    Route::get('/messages', [PrivateMessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{utilisateur}', [PrivateMessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{utilisateur}', [PrivateMessageController::class, 'store'])->name('messages.privees.store');
    Route::get('/messages/{utilisateur}/nouveaux', [PrivateMessageController::class, 'nouveaux'])->name('messages.privees.nouveaux');

    Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}/telecharger', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    Route::middleware('role:administrateur,moderateur')->group(function () {
        Route::get('/documents/creer', [DocumentController::class, 'create'])->name('documents.create');
        Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    });

    Route::get('/annonces', [AnnonceController::class, 'index'])->name('annonces.index');
    Route::delete('/annonces/{annonce}', [AnnonceController::class, 'destroy'])->name('annonces.destroy');

    Route::middleware('role:administrateur,moderateur')->group(function () {
        Route::get('/annonces/creer', [AnnonceController::class, 'create'])->name('annonces.create');
        Route::post('/annonces', [AnnonceController::class, 'store'])->name('annonces.store');
    });

    Route::middleware('role:administrateur')->group(function () {
        Route::get('/admin/utilisateurs', [AdminUserController::class, 'index'])->name('admin.utilisateurs.index');
        Route::patch('/admin/utilisateurs/{utilisateur}', [AdminUserController::class, 'updateRole'])->name('admin.utilisateurs.updateRole');
        Route::get('/admin/journal', [JournalController::class, 'index'])->name('admin.journal.index');
    });
});

require __DIR__.'/auth.php';