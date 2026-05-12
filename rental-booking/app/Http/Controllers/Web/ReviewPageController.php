<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewPageController extends Controller
{
    public function store(Request $request, Booking $booking): RedirectResponse
    {
        $validated = $this->validateReview($request);

        if ($booking->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($booking->end_date->isFuture()) {
            return back()->withErrors([
                'review' => __('ui.messages.review_after_stay'),
            ]);
        }

        if ($booking->review) {
            return back()->withErrors([
                'review' => __('ui.messages.review_exists'),
            ]);
        }

        Review::query()->create([
            'booking_id' => $booking->id,
            'user_id' => $request->user()->id,
            'property_id' => $booking->property_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('status', __('ui.messages.review_saved'));
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        Gate::authorize('update', $review);

        $review->update($this->validateReview($request));

        return back()->with('status', __('ui.messages.review_updated'));
    }

    public function destroy(Review $review): RedirectResponse
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return back()->with('status', __('ui.messages.review_deleted'));
    }

    private function validateReview(Request $request): array
    {
        return $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ], [
            'rating.required' => __('ui.messages.rating_required'),
            'comment.required' => __('ui.messages.comment_required'),
        ]);
    }
}
