<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreReviewRequest;
use App\Http\Requests\Api\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        $validated = $request->validated();
        $booking = Booking::query()->with('review')->findOrFail($validated['booking_id']);

        if ($booking->user_id !== $request->user()->id) {
            return response()->json(['message' => 'You can review only your own bookings.'], 403);
        }

        if ($booking->end_date->isFuture()) {
            return response()->json(['message' => 'Cannot review a stay before it ends.'], 422);
        }

        if ($booking->review) {
            return response()->json(['message' => 'A review already exists for this booking.'], 422);
        }

        $review = Review::query()->create([
            'booking_id' => $booking->id,
            'user_id' => $request->user()->id,
            'property_id' => $booking->property_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return (new ReviewResource($review->load(['user', 'booking', 'property'])))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateReviewRequest $request, Review $review): ReviewResource
    {
        Gate::authorize('update', $review);

        $review->update($request->validated());

        return new ReviewResource($review->load(['user', 'booking', 'property']));
    }

    public function destroy(Review $review): JsonResponse
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully.']);
    }
}
