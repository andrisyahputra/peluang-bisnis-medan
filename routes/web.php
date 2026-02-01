<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\Admin\PeluangBisnisController;
use App\Http\Controllers\Admin\SektorController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BerandaController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/profil-kota', [BerandaController::class, 'profilKota'])->name('profil-kota');
Route::get('/potensi-investasi', [BerandaController::class, 'potensiInvestasi'])->name('potensi-investasi');
Route::get('/peluang-bisnis', [BerandaController::class, 'peluangBisnis'])->name('peluang-bisnis');
Route::get('/insentif', [BerandaController::class, 'insentif'])->name('insentif');
Route::get('/rdtr-interaktif', [BerandaController::class, 'rdtrInteraktif'])->name('rdtr-interaktif');
Route::get('/peta-investasi', [BerandaController::class, 'petaInvestasi'])->name('peta-investasi');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('sektor', SektorController::class)->except(['show']);
    Route::resource('kecamatan', KecamatanController::class)->except(['show']);
    Route::resource('peluang-bisnis', PeluangBisnisController::class);
});