<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Админ-панель</h1>
            <p class="mt-1 text-sm text-slate-500">Управление жильём, отзывами и обзор последних бронирований.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Жильё</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $propertiesCount }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Бронирования</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $bookingsCount }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Отзывы</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $reviewsCount }}</p>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <p class="text-sm text-slate-500">Владельцы</p>
                <p class="mt-2 text-3xl font-bold text-slate-900">{{ $ownersCount }}</p>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">Последние бронирования</h2>
                    <a href="{{ route('admin.properties.index') }}" class="text-sm font-medium text-orange-600">Управлять жильём</a>
                </div>
                <div class="mt-4 space-y-3">
                    @foreach ($latestBookings as $booking)
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <p class="font-semibold text-slate-900">{{ $booking->property?->title }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $booking->user?->name }} • {{ $booking->start_date?->format('d.m.Y') }} - {{ $booking->end_date?->format('d.m.Y') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">Последние отзывы</h2>
                    <a href="{{ route('admin.reviews.index') }}" class="text-sm font-medium text-orange-600">Модерация отзывов</a>
                </div>
                <div class="mt-4 space-y-3">
                    @foreach ($latestReviews as $review)
                        <div class="rounded-2xl border border-slate-200 p-4">
                            <div class="flex items-center justify-between">
                                <p class="font-semibold text-slate-900">{{ $review->property?->title }}</p>
                                <span class="text-sm text-slate-500">{{ $review->rating }}/5</span>
                            </div>
                            <p class="mt-1 text-sm text-slate-500">{{ $review->user?->name }}</p>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
