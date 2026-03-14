<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\CreatorProfileController;
use App\Http\Controllers\CreatorLinkController;
use App\Http\Controllers\SupportController; 
use App\Http\Controllers\OnboardingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Landing Page
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('welcome');


// Rutas protegidas (Dashboard y Gestión)
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/onboarding', [App\Http\Controllers\OnboardingController::class, 'show'])->name('onboarding');
    Route::post('/onboarding', [App\Http\Controllers\OnboardingController::class, 'update'])->name('onboarding.update');

    
    // Dashboard
    Route::get('/dashboard', [CreatorProfileController::class, 'edit'])->name('dashboard');

    
    // Perfil y Links
    Route::post('/profile', [CreatorProfileController::class, 'update'])->name('profile.update');
    Route::post('/links', [CreatorLinkController::class, 'store'])->name('links.store');
    Route::put('/links/{link}', [CreatorLinkController::class, 'update'])->name('links.update');
    Route::delete('/links/{link}', [CreatorLinkController::class, 'destroy'])->name('links.destroy');
});

// 3. RUTAS PÚBLICAS 
Route::get('/@{slug}', [PublicProfileController::class, 'show'])->name('creator.public');
Route::post('/@{slug}/support', [SupportController::class, 'store'])->name('creator.support');

require __DIR__.'/auth.php';