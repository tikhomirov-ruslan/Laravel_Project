<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Property;
use App\Models\Review;
use App\Models\User;
use Illuminate\Contracts\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'propertiesCount' => Property::query()->count(),
            'bookingsCount' => Booking::query()->count(),
            'reviewsCount' => Review::query()->count(),
            'ownersCount' => User::query()->where('role', 'owner')->count(),
            'latestBookings' => Booking::query()
                ->with(['user', 'property'])
                ->latest()
                ->take(5)
                ->get(),
            'latestReviews' => Review::query()
                ->with(['user', 'property'])
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
