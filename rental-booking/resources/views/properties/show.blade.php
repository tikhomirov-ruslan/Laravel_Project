<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1">
            <h1 class="text-2xl font-bold text-slate-900">{{ $property->title }}</h1>
            <p class="text-sm text-slate-500">{{ $property->address }}</p>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="space-y-6">
            <div class="overflow-hidden rounded-3xl bg-white shadow-sm">
                <img src="{{ $property->primary_image_url }}" alt="{{ $property->title }}" class="h-80 w-full object-cover">
                @if ($property->images->count() > 1)
                    <div class="grid gap-3 p-4 sm:grid-cols-3">
                        @foreach ($property->images->take(6) as $image)
                            <img src="{{ $image->url }}" alt="{{ $property->title }}" class="h-28 w-full rounded-2xl object-cover">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="rounded-full bg-orange-100 px-3 py-1 text-sm text-orange-700">{{ $property->category?->name }}</span>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-700">До {{ $property->max_guests }} гостей</span>
                    <span class="rounded-full bg-slate-100 px-3 py-1 text-sm text-slate-700">{{ number_format((float) $property->price_per_night, 0, '.', ' ') }} ₸ за ночь</span>
                </div>
                <p class="mt-5 text-sm leading-7 text-slate-600">{{ $property->description }}</p>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Удобства</h2>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($property->amenities as $amenity)
                        <span class="rounded-full bg-slate-100 px-3 py-2 text-sm text-slate-700">{{ $amenity->name }}</span>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-lg font-semibold text-slate-900">Отзывы</h2>
                    <span class="text-sm text-slate-500">Средняя оценка: {{ number_format((float) ($property->reviews->avg('rating') ?? 0), 1) }}</span>
                </div>

                <div class="mt-4 space-y-4">
                    @forelse ($property->reviews as $review)
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-slate-900">{{ $review->user?->name }}</p>
                                <span class="text-sm text-slate-500">{{ $review->rating }}/5</span>
                            </div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $review->comment }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-slate-500">Пока отзывов нет.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Забронировать</h2>
            <p class="mt-2 text-sm text-slate-500">Выберите даты и отправьте заявку.</p>

            @auth
                <form method="POST" action="{{ route('web.bookings.store', $property) }}" class="mt-6 space-y-4">
                    @csrf
                    <div>
                        <label for="start_date" class="text-sm font-medium text-slate-700">Дата заезда</label>
                        <input id="start_date" name="start_date" type="date" value="{{ old('start_date') }}" class="mt-2 block w-full rounded-2xl border-slate-300">
                    </div>
                    <div>
                        <label for="end_date" class="text-sm font-medium text-slate-700">Дата выезда</label>
                        <input id="end_date" name="end_date" type="date" value="{{ old('end_date') }}" class="mt-2 block w-full rounded-2xl border-slate-300">
                    </div>
                    <button type="submit" class="w-full rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white">
                        Забронировать
                    </button>
                </form>
            @else
                <div class="mt-6 rounded-2xl bg-slate-100 p-4 text-sm text-slate-600">
                    Чтобы забронировать жильё, сначала
                    <a href="{{ route('login') }}" class="font-semibold text-orange-600">войдите</a>
                    или
                    <a href="{{ route('register') }}" class="font-semibold text-orange-600">зарегистрируйтесь</a>.
                </div>
            @endauth
        </div>
    </div>
</x-app-layout>
