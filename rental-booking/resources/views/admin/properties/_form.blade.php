<div class="grid gap-4">
    <div>
        <label class="text-sm font-medium text-slate-700" for="user_id">Владелец</label>
        <select id="user_id" name="user_id" class="mt-2 block w-full rounded-2xl border-slate-300">
            @foreach ($owners as $owner)
                <option value="{{ $owner->id }}" @selected(old('user_id', $property->user_id) == $owner->id)>{{ $owner->name }} ({{ $owner->role }})</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-sm font-medium text-slate-700" for="category_id">Категория</label>
        <select id="category_id" name="category_id" class="mt-2 block w-full rounded-2xl border-slate-300">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $property->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="text-sm font-medium text-slate-700" for="title">Название</label>
        <input id="title" name="title" type="text" value="{{ old('title', $property->title) }}" class="mt-2 block w-full rounded-2xl border-slate-300">
    </div>

    <div>
        <label class="text-sm font-medium text-slate-700" for="address">Адрес</label>
        <input id="address" name="address" type="text" value="{{ old('address', $property->address) }}" class="mt-2 block w-full rounded-2xl border-slate-300">
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="text-sm font-medium text-slate-700" for="price_per_night">Цена за ночь</label>
            <input id="price_per_night" name="price_per_night" type="number" step="0.01" value="{{ old('price_per_night', $property->price_per_night) }}" class="mt-2 block w-full rounded-2xl border-slate-300">
        </div>
        <div>
            <label class="text-sm font-medium text-slate-700" for="max_guests">Макс. гостей</label>
            <input id="max_guests" name="max_guests" type="number" value="{{ old('max_guests', $property->max_guests) }}" class="mt-2 block w-full rounded-2xl border-slate-300">
        </div>
    </div>

    <div>
        <label class="text-sm font-medium text-slate-700" for="description">Описание</label>
        <textarea id="description" name="description" rows="5" class="mt-2 block w-full rounded-2xl border-slate-300">{{ old('description', $property->description) }}</textarea>
    </div>

    <div>
        <label class="text-sm font-medium text-slate-700" for="images">Фотографии жилья</label>
        <input id="images" name="images[]" type="file" multiple accept=".jpg,.jpeg,.png,.webp" class="mt-2 block w-full rounded-2xl border-slate-300 bg-white">
        <p class="mt-2 text-xs text-slate-500">Можно загрузить несколько изображений. Поддерживаются JPG, PNG и WEBP.</p>
    </div>

    @if ($property->exists && $property->images->isNotEmpty())
        <div>
            <p class="text-sm font-medium text-slate-700">Текущие изображения</p>
            <div class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($property->images as $image)
                    <label class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50">
                        <img src="{{ $image->url }}" alt="Фото жилья" class="h-36 w-full object-cover">
                        <span class="flex items-center gap-3 px-4 py-3 text-sm text-slate-700">
                            <input type="checkbox" name="delete_image_ids[]" value="{{ $image->id }}">
                            Удалить это изображение
                        </span>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    <div>
        <p class="text-sm font-medium text-slate-700">Удобства</p>
        <div class="mt-3 grid gap-2 md:grid-cols-2">
            @foreach ($amenities as $amenity)
                <label class="flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-3 text-sm text-slate-700">
                    <input
                        type="checkbox"
                        name="amenities[]"
                        value="{{ $amenity->id }}"
                        @checked(collect(old('amenities', $property->amenities->pluck('id')->all()))->contains($amenity->id))
                    >
                    <span>{{ $amenity->name }}</span>
                </label>
            @endforeach
        </div>
    </div>
</div>
