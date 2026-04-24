<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingPageController extends Controller
{
    public function __construct(private readonly BookingService $bookingService)
    {
    }

    public function index(Request $request): View
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
            'start_date.required' => 'Укажите дату заезда.',
            'start_date.after' => 'Дата заезда должна быть позже сегодняшнего дня.',
            'end_date.required' => 'Укажите дату выезда.',
            'end_date.after' => 'Дата выезда должна быть позже даты заезда.',
        ]);

        try {
            $this->bookingService->createBooking($request->user(), [
                'property_id' => $property->id,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
            ]);
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (\Throwable $exception) {
            report($exception);

            return back()->withErrors([
                'booking' => 'Не удалось создать бронирование. Попробуйте ещё раз.',
            ])->withInput();
        }

        return redirect()
            ->route('web.bookings.index')
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
