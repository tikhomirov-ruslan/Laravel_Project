<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ReviewController;

Route::post('/register', [AuthController::class, 'register']); // если используешь Breeze, он уже добавил /api/register, /api/login
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // Свойства
    Route::apiResource('properties', PropertyController::class);
    // Бронирования
    Route::apiResource('bookings', BookingController::class)->only(['index', 'store', 'show']);
    Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel']);
    // Отзывы
    Route::apiResource('reviews', ReviewController::class)->only(['store', 'update', 'destroy']);
    // Только владелец отзыва может его редактировать (политику можно создать по аналогии)
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
