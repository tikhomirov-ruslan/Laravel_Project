<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
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
            'property_id' => 'required|exists:properties,id',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);
        $property = Property::findOrFail($validated['property_id']);

        // Проверка перекрытия бронирований
        $overlap = Booking::where('property_id', $property->id)
            ->where('status', '!=', 'canceled')
            ->where(function ($q) use ($validated) {
                $q->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhere(function ($q) use ($validated) {
                        $q->where('start_date', '<=', $validated['start_date'])
                            ->where('end_date', '>=', $validated['end_date']);
                    });
            })->exists();

        if ($overlap) {
            return response()->json(['message' => 'Selected dates are not available'], 422);
        }

        $nights = (new \Carbon\Carbon($validated['start_date']))->diffInDays($validated['end_date']);
        $totalPrice = $property->price_per_night * $nights;

        $booking = Booking::create([
            'user_id' => $request->user()->id,
            'property_id' => $property->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'confirmed',
        ]);

        // Запуск события для отправки email (асинхронно)
        event(new \App\Events\BookingCreated($booking));

        return new BookingResource($booking);
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
