<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Http\Resources\PropertyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with(['owner', 'category', 'amenities', 'reviews'])->paginate(15);
        return PropertyResource::collection($properties);
    }


    /**
     * Создать новое жильё
     *
     * @authenticated
     * @group Properties
     *
     * @bodyParam title string required Название объявления. Example: "Уютная квартира в центре"
     * @bodyParam description string required Подробное описание. Example: "Просторная светлая квартира..."
     * @bodyParam address string required Адрес. Example: "ул. Пушкина, 10"
     * @bodyParam price_per_night number required Цена за ночь. Example: 150.00
     * @bodyParam max_guests integer required Максимум гостей. Example: 4
     * @bodyParam category_id integer required ID категории (см. список категорий). Example: 1
     * @bodyParam amenities array Массив ID удобств. Example: [1,2,3]
     *
     * @response 201 {
     *   "id": 1,
     *   "title": "Уютная квартира в центре",
     *   "description": "...",
     *   "address": "ул. Пушкина, 10",
     *   "price_per_night": 150,
     *   "max_guests": 4,
     *   "category": { "id": 1, "name": "Entire apartment", "slug": "entire-apartment" },
     *   "owner": "User Name",
     *   "amenities": ["Wi-Fi", "Кухня"],
     *   "average_rating": 0,
     *   "created_at": "2026-04-03T12:00:00.000000Z"
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
            'address'        => 'required|string',
            'price_per_night'=> 'required|numeric|min:0',
            'max_guests'     => 'required|integer|min:1',
            'category_id'    => 'required|exists:categories,id',
            'amenities'      => 'array|exists:amenities,id',
        ]);

        $property = $request->user()->properties()->create($validated);

        if ($request->has('amenities')) {
            $property->amenities()->sync($request->amenities);
        }

        return new PropertyResource($property->load(['owner', 'category', 'amenities']));
    }

    public function show(Property $property)
    {
        return new PropertyResource($property->load(['owner', 'category', 'amenities', 'reviews.user']));
    }

    public function update(Request $request, Property $property)
    {
        Gate::authorize('update', $property);

        $validated = $request->validate([
            'title'          => 'sometimes|string|max:255',
            'description'    => 'sometimes|string',
            'address'        => 'sometimes|string',
            'price_per_night'=> 'sometimes|numeric|min:0',
            'max_guests'     => 'sometimes|integer|min:1',
            'category_id'    => 'sometimes|exists:categories,id',
            'amenities'      => 'array|exists:amenities,id',
        ]);

        $property->update($validated);

        if ($request->has('amenities')) {
            $property->amenities()->sync($request->amenities);
        }

        return new PropertyResource($property->load(['owner', 'category', 'amenities']));
    }

    public function destroy(Property $property)
    {
        Gate::authorize('delete', $property);
        $property->delete();
        return response()->json(['message' => 'Property deleted']);
    }
}
