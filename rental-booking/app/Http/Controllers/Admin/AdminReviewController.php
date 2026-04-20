<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AdminReviewController extends Controller
{
    public function index(): View
    {
        $reviews = Review::query()
            ->with(['user', 'property', 'booking'])
            ->latest()
            ->get();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')->with('status', 'Отзыв удалён.');
    }
}
