<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePropertyRequest;
use App\Http\Requests\Api\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Support\Facades\Gate;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::query()
            ->with(['owner', 'category', 'amenities', 'reviews.user'])
            ->latest()
            ->paginate(10);

        return PropertyResource::collection($properties);
    }

    public function store(StorePropertyRequest $request)
    {
        Gate::authorize('create', Property::class);

        $validated = $request->validated();
        $amenityIds = $validated['amenities'] ?? [];
        unset($validated['amenities']);

        $property = $request->user()->properties()->create($validated);

        if ($amenityIds !== []) {
            $property->amenities()->sync($amenityIds);
        }

        return (new PropertyResource($property->load(['owner', 'category', 'amenities', 'reviews.user'])))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Property $property): PropertyResource
    {
        return new PropertyResource($property->load(['owner', 'category', 'amenities', 'reviews.user']));
    }

    public function update(UpdatePropertyRequest $request, Property $property): PropertyResource
    {
        Gate::authorize('update', $property);

        $validated = $request->validated();
        $amenityIds = $validated['amenities'] ?? null;
        unset($validated['amenities']);

        $property->update($validated);

        if (is_array($amenityIds)) {
            $property->amenities()->sync($amenityIds);
        }

        return new PropertyResource($property->load(['owner', 'category', 'amenities', 'reviews.user']));
    }

    public function destroy(Property $property)
    {
        Gate::authorize('delete', $property);

        $property->delete();

        return response()->json(['message' => 'Property deleted successfully.']);
    }
}
