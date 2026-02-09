<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\AbsensiController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // User CRUD Routes
    Route::apiResource('users', UserController::class);

    // Absensi Routes
    Route::prefix('absensi')->group(function () {
        // Clock in/out
        Route::post('/clock-in', [AbsensiController::class, 'clockIn']);
        Route::post('/clock-out/{id}', [AbsensiController::class, 'clockOut']);

        // CRUD
        Route::get('/', [AbsensiController::class, 'index']);
        Route::get('/{id}', [AbsensiController::class, 'show']);
        Route::put('/{id}', [AbsensiController::class, 'update']);
        Route::delete('/{id}', [AbsensiController::class, 'destroy']);

        // Export
        Route::get('/export/excel', [AbsensiController::class, 'exportExcel']);
        Route::get('/export/pdf', [AbsensiController::class, 'exportPdf']);

        // Statistics
        Route::get('/user/{userId}/stats', [AbsensiController::class, 'userStats']);
    });
});
