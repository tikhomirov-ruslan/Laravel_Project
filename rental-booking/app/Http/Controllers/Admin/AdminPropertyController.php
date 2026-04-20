<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use App\Models\Category;
use App\Models\Property;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminPropertyController extends Controller
{
    public function index(): View
    {
        $properties = Property::query()
            ->with(['owner', 'category', 'amenities', 'reviews'])
            ->latest()
            ->get();

        return view('admin.properties.index', compact('properties'));
    }

    public function create(): View
    {
        return view('admin.properties.create', [
            'property' => new Property(),
            'owners' => User::query()->whereIn('role', ['owner', 'admin'])->orderBy('name')->get(),
            'categories' => Category::query()->orderBy('name')->get(),
            'amenities' => Amenity::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateProperty($request);
        $amenityIds = $validated['amenities'] ?? [];
        unset($validated['amenities']);

        $property = Property::query()->create($validated);
        $property->amenities()->sync($amenityIds);

        return redirect()->route('admin.properties.index')->with('status', 'Жильё успешно добавлено.');
    }

    public function edit(Property $property): View
    {
        $property->load('amenities');

        return view('admin.properties.edit', [
            'property' => $property,
            'owners' => User::query()->whereIn('role', ['owner', 'admin'])->orderBy('name')->get(),
            'categories' => Category::query()->orderBy('name')->get(),
            'amenities' => Amenity::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Property $property): RedirectResponse
    {
        $validated = $this->validateProperty($request);
        $amenityIds = $validated['amenities'] ?? [];
        unset($validated['amenities']);

        $property->update($validated);
        $property->amenities()->sync($amenityIds);

        return redirect()->route('admin.properties.index')->with('status', 'Жильё успешно обновлено.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $property->delete();

        return redirect()->route('admin.properties.index')->with('status', 'Жильё удалено.');
    }

    private function validateProperty(Request $request): array
    {
        return $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'address' => ['required', 'string', 'max:500'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'max_guests' => ['required', 'integer', 'min:1'],
            'amenities' => ['sometimes', 'array'],
            'amenities.*' => ['integer', 'exists:amenities,id'],
        ], [
            'user_id.required' => 'Выберите владельца жилья.',
            'category_id.required' => 'Выберите категорию жилья.',
            'title.required' => 'Введите название жилья.',
            'address.required' => 'Введите адрес.',
        ]);
    }
}
