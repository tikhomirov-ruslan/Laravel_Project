<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class BookingController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    public function index(): AnonymousResourceCollection
    {
        $query = Booking::query()
            ->with(['user', 'property.owner', 'property.category'])
            ->latest();

        if (! request()->user()->isAdmin()) {
            $query->where('user_id', request()->user()->id);
        }

        return BookingResource::collection($query->paginate(10));
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = $this->bookingService->createBooking($request->user(), $request->validated());

        return (new BookingResource($booking))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Booking $booking): BookingResource
    {
        Gate::authorize('view', $booking);

        return new BookingResource($booking->load(['user', 'property.owner', 'property.category', 'review']));
    }

    public function cancel(Booking $booking): JsonResponse
    {
        Gate::authorize('cancel', $booking);

        if ($booking->status === 'canceled') {
            return response()->json(['message' => 'Booking is already canceled.'], 422);
        }

        $booking->update(['status' => 'canceled']);

        return response()->json([
            'message' => 'Booking canceled successfully.',
            'booking' => new BookingResource($booking->load(['user', 'property.owner', 'property.category'])),
        ]);
    }
}
