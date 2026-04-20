<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\BookingPageController;
use App\Http\Controllers\Web\PropertyPageController;
use App\Http\Controllers\Web\ReviewPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');
})->name('home');

Route::get('/properties', [PropertyPageController::class, 'index'])->name('properties.index');
Route::get('/properties/{property}', [PropertyPageController::class, 'show'])->name('properties.show');

Route::view('/dashboard', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/bookings', [BookingPageController::class, 'index'])->name('bookings.index');
    Route::post('/properties/{property}/bookings', [BookingPageController::class, 'store'])->name('bookings.store');
    Route::post('/bookings/{booking}/cancel', [BookingPageController::class, 'cancel'])->name('bookings.cancel');

    Route::post('/bookings/{booking}/reviews', [ReviewPageController::class, 'store'])->name('reviews.store');
});

require __DIR__.'/auth.php';
