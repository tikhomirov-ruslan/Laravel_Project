<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Property::with('owner', 'reviews');

        // Фильтр по доступности
        if ($request->has('available')) {
            $query->where('is_available', filter_var($request->available, FILTER_VALIDATE_BOOLEAN));
        }

        // Поиск по городу (address)
        if ($request->has('city')) {
            $query->where('address', 'ilike', '%' . $request->city . '%');
        }

        $properties = $query->paginate(15);
        return response()->json($properties);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request): \Illuminate\Http\JsonResponse
    {
        $property = auth()->user()->properties()->create($request->validated());
        return response()->json($property, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        $property->load('owner', 'reviews.user', 'bookings' => function ($q) {
        $q->where('status', 'confirmed')->orderBy('check_in');
    });
        return response()->json($property);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $property->update($request->validated());
        return response()->json($property);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        $user = $request->user();
        if ($user->role !== 'admin' && $user->id !== $property->owner_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $property->delete();
        return response()->json(null, 204);
    }
}
