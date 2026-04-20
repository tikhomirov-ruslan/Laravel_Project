<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Жильё в Алматы</h1>
            <p class="mt-1 text-sm text-slate-500">Выберите подходящий вариант и откройте карточку для бронирования.</p>
        </div>
    </x-slot>

    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        @foreach ($properties as $property)
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
        @endforeach
    </div>
</x-app-layout>
