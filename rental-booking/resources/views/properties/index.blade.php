<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ __('ui.properties.title') }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ __('ui.properties.subtitle') }}</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <form method="GET" action="{{ route('properties.index') }}" class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
                <div class="xl:col-span-2">
                    <label for="q" class="text-sm font-medium text-slate-700">{{ __('ui.properties.search') }}</label>
                    <input id="q" name="q" type="text" value="{{ request('q') }}" placeholder="{{ __('ui.properties.search_placeholder') }}" class="mt-2 block w-full rounded-2xl border-slate-300">
                </div>

                <div>
                    <label for="category_id" class="text-sm font-medium text-slate-700">{{ __('ui.properties.category') }}</label>
                    <select id="category_id" name="category_id" class="mt-2 block w-full rounded-2xl border-slate-300">
                        <option value="">{{ __('ui.properties.all') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="guests" class="text-sm font-medium text-slate-700">{{ __('ui.properties.guests') }}</label>
                    <input id="guests" name="guests" type="number" min="1" value="{{ request('guests') }}" class="mt-2 block w-full rounded-2xl border-slate-300">
                </div>

                <div>
                    <label for="min_price" class="text-sm font-medium text-slate-700">{{ __('ui.properties.price_from') }}</label>
                    <input id="min_price" name="min_price" type="number" min="0" value="{{ request('min_price') }}" class="mt-2 block w-full rounded-2xl border-slate-300">
                </div>

                <div>
                    <label for="max_price" class="text-sm font-medium text-slate-700">{{ __('ui.properties.price_to') }}</label>
                    <input id="max_price" name="max_price" type="number" min="0" value="{{ request('max_price') }}" class="mt-2 block w-full rounded-2xl border-slate-300">
                </div>
            </div>

            <div class="mt-4 grid gap-4 md:grid-cols-[1fr_auto_auto] md:items-end">
                <div class="max-w-xs">
                    <label for="sort" class="text-sm font-medium text-slate-700">{{ __('ui.properties.sort') }}</label>
                    <select id="sort" name="sort" class="mt-2 block w-full rounded-2xl border-slate-300">
                        <option value="latest" @selected(request('sort', 'latest') === 'latest')>{{ __('ui.properties.sort_latest') }}</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>{{ __('ui.properties.sort_price_asc') }}</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>{{ __('ui.properties.sort_price_desc') }}</option>
                        <option value="guests_desc" @selected(request('sort') === 'guests_desc')>{{ __('ui.properties.sort_guests_desc') }}</option>
                    </select>
                </div>

                <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white">
                    {{ __('ui.properties.apply') }}
                </button>

                <a href="{{ route('properties.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-center text-sm text-slate-700">
                    {{ __('ui.properties.reset') }}
                </a>
            </div>
        </form>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($properties as $property)
                <a href="{{ route('properties.show', $property) }}" class="overflow-hidden rounded-3xl bg-white shadow-sm transition hover:shadow-md">
                    <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" class="h-56 w-full object-cover">
                    <div class="p-6">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs uppercase tracking-wide text-orange-600">{{ $property->category?->name }}</p>
                                <h2 class="mt-2 text-xl font-semibold text-slate-900">{{ $property->title }}</h2>
                            </div>
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-sm font-semibold text-slate-700">{{ number_format((float) $property->price_per_night, 0, '.', ' ') }} KZT</span>
                        </div>
                        <p class="mt-3 text-sm text-slate-600">{{ $property->address }}</p>
                        <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-500">{{ $property->description }}</p>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($property->amenities->take(3) as $amenity)
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs text-slate-600">{{ $amenity->name }}</span>
                            @endforeach
                        </div>
                        <div class="mt-5 flex items-center justify-between text-sm text-slate-500">
                            <span>{{ __('ui.properties.guests') }}: {{ $property->max_guests }}</span>
                            <span>{{ __('ui.properties.rating', ['rating' => number_format((float) ($property->reviews->avg('rating') ?? 0), 1)]) }}</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="rounded-3xl bg-white p-8 text-sm text-slate-500 shadow-sm md:col-span-2 xl:col-span-3">
                    {{ __('ui.properties.no_results') }}
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
