<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PropertyPageController extends Controller
{
    public function index(Request $request): View
    {
        $query = Property::query()
            ->with(['owner', 'category', 'amenities', 'reviews.user', 'images']);

        if ($search = trim((string) $request->input('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'ilike', "%{$search}%")
                    ->orWhere('description', 'ilike', "%{$search}%")
                    ->orWhere('address', 'ilike', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($guests = $request->input('guests')) {
            $query->where('max_guests', '>=', (int) $guests);
        }

        if ($minPrice = $request->input('min_price')) {
            $query->where('price_per_night', '>=', (float) $minPrice);
        }

        if ($maxPrice = $request->input('max_price')) {
            $query->where('price_per_night', '<=', (float) $maxPrice);
        }

        $sort = $request->input('sort', 'latest');

        match ($sort) {
            'price_asc' => $query->orderBy('price_per_night'),
            'price_desc' => $query->orderByDesc('price_per_night'),
            'guests_desc' => $query->orderByDesc('max_guests'),
            default => $query->latest(),
        };

        $properties = $query->get();
        $categories = Category::query()->orderBy('name')->get();

        return view('properties.index', compact('properties', 'categories'));
    }

    public function show(Property $property): View
    {
        $property->load(['owner', 'category', 'amenities', 'reviews.user', 'images']);

        return view('properties.show', compact('property'));
    }
}
