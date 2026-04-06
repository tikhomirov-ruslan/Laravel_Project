<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = $request->user();
        $query = Booking::with(['property', 'user']);

        if ($user->role === 'customer') {
            $query->where('user_id', $user->id);
        } elseif ($user->role === 'owner') {
            $propertyIds = $user->properties()->pluck('id');
            $query->whereIn('property_id', $propertyIds);
        }
        // admin видит все

        $bookings = $query->orderBy('created_at', 'desc')->paginate(15);
        return response()->json($bookings);
    }

    public function store(StoreBookingRequest $request): \Illuminate\Http\JsonResponse
    {
        $property = Property::findOrFail($request->property_id);
        $nights = Carbon::parse($request->check_in)->diffInDays(Carbon::parse($request->check_out));
        $totalPrice = $nights * $property->price_per_night;

        $booking = Booking::create([
            'property_id' => $request->property_id,
            'user_id' => $request->user()->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return response()->json($booking, 201);
    }

    public function show(Booking $booking)
    {
        $user = request()->user();
        if ($user->role !== 'admin' && $user->id !== $booking->user_id && $user->id !== $booking->property->owner_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $booking->load('property', 'user');
        return response()->json($booking);
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->only('status'));
        return response()->json($booking);
    }

    public function destroy(Booking $booking)
    {
        $user = request()->user();
        if ($user->role !== 'admin' && $user->id !== $booking->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $booking->delete();
        return response()->json(null, 204);
    }
}
