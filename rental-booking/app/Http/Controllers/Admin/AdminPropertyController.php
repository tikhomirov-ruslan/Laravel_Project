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
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminPropertyController extends Controller
{
    public function index(): View
    {
        $properties = Property::query()
            ->with(['owner', 'category', 'amenities', 'reviews', 'images'])
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
        unset($validated['amenities'], $validated['images']);

        $property = Property::query()->create($validated);
        $property->amenities()->sync($amenityIds);
        $this->storeImages($request, $property);

        return redirect()->route('admin.properties.index')->with('status', 'Жильё успешно добавлено.');
    }

    public function edit(Property $property): View
    {
        $property->load(['amenities', 'images']);

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
        unset($validated['amenities'], $validated['images'], $validated['delete_image_ids']);

        $property->update($validated);
        $property->amenities()->sync($amenityIds);
        $this->deleteSelectedImages($request, $property);
        $this->storeImages($request, $property);

        return redirect()->route('admin.properties.index')->with('status', 'Жильё успешно обновлено.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        foreach ($property->images as $image) {
            $this->deleteImageFile($image->path);
        }

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
            'images' => ['sometimes', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'delete_image_ids' => ['sometimes', 'array'],
            'delete_image_ids.*' => ['integer', 'exists:property_images,id'],
        ], [
            'user_id.required' => 'Выберите владельца жилья.',
            'category_id.required' => 'Выберите категорию жилья.',
            'title.required' => 'Введите название жилья.',
            'address.required' => 'Введите адрес.',
            'images.*.image' => 'Загружаемые файлы должны быть изображениями.',
        ]);
    }

    private function storeImages(Request $request, Property $property): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $directory = public_path('property-images');

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $nextSort = (int) $property->images()->max('sort_order');

        foreach ($request->file('images') as $image) {
            $filename = Str::uuid().'.'.$image->getClientOriginalExtension();
            $image->move($directory, $filename);

            $property->images()->create([
                'path' => 'property-images/'.$filename,
                'sort_order' => ++$nextSort,
            ]);
        }
    }

    private function deleteSelectedImages(Request $request, Property $property): void
    {
        $imageIds = collect($request->input('delete_image_ids', []))
            ->map(fn ($id) => (int) $id)
            ->all();

        if ($imageIds === []) {
            return;
        }

        $images = $property->images()->whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            $this->deleteImageFile($image->path);
            $image->delete();
        }
    }

    private function deleteImageFile(string $relativePath): void
    {
        $fullPath = public_path($relativePath);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }
}
