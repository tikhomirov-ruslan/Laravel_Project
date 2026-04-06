<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Review::with('user', 'property');

        if ($request->has('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        $reviews = $query->latest()->paginate(20);
        return response()->json($reviews);
    }

    public function store(StoreReviewRequest $request): \Illuminate\Http\JsonResponse
    {
        $review = Review::create([
            'property_id' => $request->property_id,
            'user_id' => $request->user()->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json($review, 201);
    }

    public function show(Review $review): \Illuminate\Http\JsonResponse
    {
        $review->load('user', 'property');
        return response()->json($review);
    }

    public function update(UpdateReviewRequest $request, Review $review): \Illuminate\Http\JsonResponse
    {
        $review->update($request->validated());
        return response()->json($review);
    }

    public function destroy(Review $review): \Illuminate\Http\JsonResponse
    {
        $user = request()->user();
        if ($user->role !== 'admin' && $user->id !== $review->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $review->delete();
        return response()->json(null, 204);
    }
}
