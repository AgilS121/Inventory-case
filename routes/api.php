<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\StokLogController;
use App\Http\Controllers\DashboardController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('barangs', BarangController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('transaksi', TransaksiController::class);
    Route::post('users/{id}/deactivate', [UserController::class, 'deactivate']);
    Route::post('users/{id}/activate', [UserController::class, 'activate']);
    Route::get('stok-logs', [StokLogController::class, 'index']);
    Route::get('dashboard-stats', [DashboardController::class, 'stats']);
    Route::get('user/profile', [UserController::class, 'profile']);
    Route::get('dashboard/summary', [DashboardController::class, 'summary']);

    Route::post('/ubah-password', function (Request $request) {
        $request->validate(['password' => 'required|string|min:6']);
        $user = $request->user();
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json(['message' => 'Password updated']);
    });


});