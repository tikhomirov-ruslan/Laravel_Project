<?php

namespace App\Services;

use App\Events\BookingCreated;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function createBooking(User $user, array $validated): Booking
    {
        $property = Property::query()->findOrFail($validated['property_id']);

        if ($this->hasOverlap($property->id, $validated['start_date'], $validated['end_date'])) {
            throw ValidationException::withMessages([
                'start_date' => ['Selected dates are not available for this property.'],
            ]);
        }

        $nights = Carbon::parse($validated['start_date'])->diffInDays(Carbon::parse($validated['end_date']));

        $booking = Booking::query()->create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $property->price_per_night * $nights,
            'status' => 'confirmed',
        ]);

        $booking->load(['user', 'property.owner', 'property.category']);
        event(new BookingCreated($booking));

        return $booking;
    }

    public function hasOverlap(int $propertyId, string $startDate, string $endDate): bool
    {
        return Booking::query()
            ->where('property_id', $propertyId)
            ->where('status', '!=', 'canceled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();
    }
}
