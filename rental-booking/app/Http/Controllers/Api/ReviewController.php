<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);
        $booking = Booking::findOrFail($validated['booking_id']);

        // Проверка: бронирование принадлежит пользователю и уже завершено (end_date < today)
        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        if ($booking->end_date->isFuture()) {
            return response()->json(['message' => 'Cannot review before stay ends'], 422);
        }
        if ($booking->review) {
            return response()->json(['message' => 'Review already exists'], 422);
        }

        $review = Review::create([
            'booking_id' => $booking->id,
            'user_id' => $request->user()->id,
            'property_id' => $booking->property_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return new ReviewResource($review);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
