<?php

use App\Http\Controllers\Api\PetaController;
use Illuminate\Support\Facades\Route;

Route::prefix('peta')->group(function () {
    Route::get('/kecamatans', [PetaController::class, 'getKecamatans']);
    Route::get('/sektors', [PetaController::class, 'getSektors']);
    Route::get('/peluang-bisnis', [PetaController::class, 'getPeluangBisnis']);
    Route::get('/statistik', [PetaController::class, 'getStatistik']);
});