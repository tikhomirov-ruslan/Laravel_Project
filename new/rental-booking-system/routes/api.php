<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;


Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum');
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Ваши дополнительные маршруты для свойств, бронирований и т.д.
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('properties', App\Http\Controllers\Api\PropertyController::class);
//    Route::apiResource('bookings', App\Http\Controllers\Api\BookingController::class);
//    Route::apiResource('reviews', App\Http\Controllers\Api\ReviewController::class);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
