<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookingPageController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    public function index(Request $request)
    {
        $query = Booking::query()
            ->with(['property.owner', 'property.category', 'review'])
            ->latest();

        if (! $request->user()->isAdmin()) {
            $query->where('user_id', $request->user()->id);
        }

        $bookings = $query->get();

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request, Property $property): RedirectResponse
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date', 'after:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
        ], [
            'start_date.after' => 'Дата заезда должна быть позже сегодняшнего дня.',
            'end_date.after' => 'Дата выезда должна быть позже даты заезда.',
        ]);

        $this->bookingService->createBooking($request->user(), [
            'property_id' => $property->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);

        return redirect()
            ->route('bookings.index')
            ->with('status', 'Бронирование успешно создано.');
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        Gate::authorize('cancel', $booking);

        if ($booking->status !== 'canceled') {
            $booking->update(['status' => 'canceled']);
        }

        return back()->with('status', 'Бронирование отменено.');
    }
}
