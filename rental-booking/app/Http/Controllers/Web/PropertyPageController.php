<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Contracts\View\View;

class PropertyPageController extends Controller
{
    public function index(): View
    {
        $properties = Property::query()
            ->with(['owner', 'category', 'amenities', 'reviews.user'])
            ->latest()
            ->get();

        return view('properties.index', compact('properties'));
    }

    public function show(Property $property): View
    {
        $property->load(['owner', 'category', 'amenities', 'reviews.user']);

        return view('properties.show', compact('property'));
    }
}
