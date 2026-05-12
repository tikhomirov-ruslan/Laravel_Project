<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class BookingService
{
    public function createBooking(User $user, array $data): Booking
    {
        $property = Property::query()->findOrFail($data['property_id']);

        if ($this->isPropertyUnavailable($property, $data['start_date'], $data['end_date'])) {
            throw ValidationException::withMessages([
                'start_date' => [__('ui.messages.unavailable_dates')],
            ]);
        }

        $nights = now()->parse($data['start_date'])->diffInDays(now()->parse($data['end_date']));

        if ($nights < 1) {
            throw ValidationException::withMessages([
                'end_date' => [__('ui.messages.min_one_night')],
            ]);
        }

        return Booking::query()->create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'total_price' => $nights * $property->price_per_night,
            'status' => 'pending',
        ]);
    }

    public function isPropertyUnavailable(Property $property, string $startDate, string $endDate): bool
    {
        return $property->bookings()
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
