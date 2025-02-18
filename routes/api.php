<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::prefix('api/cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::get('/add/{product}', [CartController::class, 'add']);
        Route::get('/remove/{product}', [CartController::class, 'remove']);
        Route::get('/clear', [CartController::class, 'clear']);
    });
});