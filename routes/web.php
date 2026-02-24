<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserImageFavoriteController;
use App\Http\Controllers\UserUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// ================== AUTH ==================

// Register
Route::get('/register', [RegisterController::class, 'showForm'])->name('register.form');
Route::post('/register', [RegisterController::class, 'register'])->name('register.submit');

// Login
Route::get('/login', [LoginController::class, 'showForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ================== DASHBOARD ==================
Route::middleware('auth')->prefix('dashboard')->group(function () {

    // Dashboard home
    Route::get('/', [DashboardController::class, 'dashboard'])
        ->name('dashboard');

    // Upload
    Route::get('/upload', [DashboardController::class, 'create'])
        ->name('dashboard.create');

    Route::post('/upload', [DashboardController::class, 'store'])
        ->name('dashboard.store');

    // Collection
    Route::get('/collection', [DashboardController::class, 'collection'])
        ->name('dashboard.collection');

    // Settings
    Route::get('/settings', [DashboardController::class, 'settings'])
        ->name('dashboard.settings');

    Route::put('/settings', [DashboardController::class, 'updateSettings'])
        ->name('dashboard.updateSettings');

    // ================== UPLOADS MANAGEMENT ==================
    
    // Download upload
    Route::get('/uploads/{uploadId}/download', [DashboardController::class, 'download'])
        ->name('dashboard.download');

    // Delete upload (NEW - untuk hapus gambar dari collection)
    Route::delete('/uploads/{id}', [UserUploadController::class, 'destroy'])
        ->name('dashboard.uploads.destroy');

    // ================== FAVORITES ==================
    
    Route::post('/favorites/{imageId}/toggle', [UserImageFavoriteController::class, 'toggle'])
        ->name('favorites.toggle');
        
    Route::post('/favorites/{imageId}/like', [UserImageFavoriteController::class, 'like'])
        ->name('favorites.like');
        
    Route::delete('/favorites/{imageId}/unlike', [UserImageFavoriteController::class, 'unlike'])
        ->name('favorites.unlike');
});