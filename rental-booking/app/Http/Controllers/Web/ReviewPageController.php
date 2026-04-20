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
                'review' => 'Оставить отзыв можно только после завершения проживания.',
            ]);
        }

        if ($booking->review) {
            return back()->withErrors([
                'review' => 'Для этого бронирования отзыв уже существует.',
            ]);
        }

        Review::query()->create([
            'booking_id' => $booking->id,
            'user_id' => $request->user()->id,
            'property_id' => $booking->property_id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('status', 'Спасибо, ваш отзыв сохранён.');
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        Gate::authorize('update', $review);

        $review->update($this->validateReview($request));

        return back()->with('status', 'Отзыв обновлён.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        Gate::authorize('delete', $review);

        $review->delete();

        return back()->with('status', 'Отзыв удалён.');
    }

    private function validateReview(Request $request): array
    {
        return $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'max:1000'],
        ], [
            'rating.required' => 'Укажите оценку от 1 до 5.',
            'comment.required' => 'Добавьте текст отзыва.',
        ]);
    }
}
