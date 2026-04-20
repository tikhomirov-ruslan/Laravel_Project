<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Жильё в Алматы</h1>
            <p class="mt-1 text-sm text-slate-500">Используйте поиск и фильтры, чтобы быстрее найти нужный вариант.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <form method="GET" action="{{ route('properties.index') }}" class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
                <div class="xl:col-span-2">
                    <label for="q" class="text-sm font-medium text-slate-700">Поиск</label>
                    <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="Название, адрес, описание" class="mt-2 block w-full rounded-2xl border-slate-300">
                </div>

                <div>
                    <label for="category_id" class="text-sm font-medium text-slate-700">Категория</label>
                    <select id="category_id" name="category_id" class="mt-2 block w-full rounded-2xl border-slate-300">
                        <option value="">Все</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="guests" class="text-sm font-medium text-slate-700">Гостей</label>
                    <input id="guests" name="guests" type="number" min="1" value="{{ request('guests') }}" class="mt-2 block w-full rounded-2xl border-slate-300">
                </div>

                <div>
                    <label for="min_price" class="text-sm font-medium text-slate-700">Цена от</label>
                    <input id="min_price" name="min_price" type="number" min="0" value="{{ request('min_price') }}" class="mt-2 block w-full rounded-2xl border-slate-300">
                </div>

                <div>
                    <label for="max_price" class="text-sm font-medium text-slate-700">Цена до</label>
                    <input id="max_price" name="max_price" type="number" min="0" value="{{ request('max_price') }}" class="mt-2 block w-full rounded-2xl border-slate-300">
                </div>
            </div>

            <div class="mt-4 grid gap-4 md:grid-cols-[1fr_auto_auto] md:items-end">
                <div class="max-w-xs">
                    <label for="sort" class="text-sm font-medium text-slate-700">Сортировка</label>
                    <select id="sort" name="sort" class="mt-2 block w-full rounded-2xl border-slate-300">
                        <option value="latest" @selected(request('sort', 'latest') === 'latest')>Сначала новые</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Сначала дешёвые</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Сначала дорогие</option>
                        <option value="guests_desc" @selected(request('sort') === 'guests_desc')>Больше гостей</option>
                    </select>
                </div>

                <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white">
                    Применить
                </button>

                <a href="{{ route('properties.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-center text-sm text-slate-700">
                    Сбросить
                </a>
            </div>
        </form>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($properties as $property)
                <a href="{{ route('properties.show', $property) }}" class="rounded-3xl bg-white p-6 shadow-sm transition hover:shadow-md">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs uppercase tracking-wide text-orange-600">{{ $property->category?->name }}</p>
                            <h2 class="mt-2 text-xl font-semibold text-slate-900">{{ $property->title }}</h2>
                        </div>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">{{ number_format((float) $property->price_per_night, 0, '.', ' ') }} ₸</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">{{ $property->address }}</p>
                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-500">{{ $property->description }}</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach ($property->amenities->take(3) as $amenity)
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-600">{{ $amenity->name }}</span>
                        @endforeach
                    </div>
                    <div class="mt-5 flex items-center justify-between text-sm text-slate-500">
                        <span>Гостей: {{ $property->max_guests }}</span>
                        <span>Рейтинг: {{ number_format((float) ($property->reviews->avg('rating') ?? 0), 1) }}</span>
                    </div>
                </a>
            @empty
                <div class="rounded-3xl bg-white p-8 text-sm text-slate-500 shadow-sm md:col-span-2 xl:col-span-3">
                    По вашему запросу ничего не найдено. Попробуйте изменить фильтры.
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
