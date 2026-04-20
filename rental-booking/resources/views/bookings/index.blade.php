<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Мои бронирования</h1>
            <p class="mt-1 text-sm text-slate-500">Здесь отображаются ваши активные, завершённые и отменённые брони.</p>
        </div>
    </x-slot>

    <div class="space-y-6">
        @forelse ($bookings as $booking)
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-orange-600">{{ $booking->property?->category?->name }}</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900">{{ $booking->property?->title }}</h2>
                        <p class="mt-2 text-sm text-slate-600">{{ $booking->property?->address }}</p>
                        <p class="mt-3 text-sm text-slate-500">
                            {{ $booking->start_date?->format('d.m.Y') }} - {{ $booking->end_date?->format('d.m.Y') }}
                        </p>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="text-lg font-bold text-slate-900">{{ number_format((float) $booking->total_price, 0, '.', ' ') }} ₸</p>
                        <p class="mt-1 text-sm capitalize text-slate-500">Статус: {{ $booking->status }}</p>
                    </div>
                </div>

                <div class="mt-5 flex flex-col gap-4 border-t border-slate-200 pt-5">
                    @if ($booking->status !== 'canceled' && $booking->end_date?->isFuture())
                        <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                            @csrf
                            <button type="submit" class="rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700">
                                Отменить бронирование
                            </button>
                        </form>
                    @endif

                    @if ($booking->end_date?->isPast() && ! $booking->review)
                        <form method="POST" action="{{ route('reviews.store', $booking) }}" class="grid gap-3 rounded-2xl bg-slate-50 p-4">
                            @csrf
                            <p class="text-sm font-semibold text-slate-900">Оставить отзыв</p>
                            <select name="rating" class="rounded-2xl border-slate-300 text-sm">
                                <option value="">Выберите оценку</option>
                                @for ($i = 5; $i >= 1; $i--)
                                    <option value="{{ $i }}">{{ $i }}/5</option>
                                @endfor
                            </select>
                            <textarea name="comment" rows="3" class="rounded-2xl border-slate-300 text-sm" placeholder="Напишите короткий отзыв"></textarea>
                            <button type="submit" class="w-fit rounded-full bg-orange-500 px-4 py-2 text-sm font-semibold text-white">
                                Отправить отзыв
                            </button>
                        </form>
                    @elseif ($booking->review)
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <div class="flex items-center justify-between gap-4">
                                <p class="text-sm font-semibold text-slate-900">Ваш отзыв</p>
                                <span class="text-sm text-slate-500">{{ $booking->review->rating }}/5</span>
                            </div>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $booking->review->comment }}</p>

                            <div class="mt-4 grid gap-3 border-t border-slate-200 pt-4">
                                <form method="POST" action="{{ route('reviews.update', $booking->review) }}" class="grid gap-3">
                                    @csrf
                                    @method('PATCH')
                                    <p class="text-sm font-medium text-slate-900">Редактировать отзыв</p>
                                    <select name="rating" class="rounded-2xl border-slate-300 text-sm">
                                        @for ($i = 5; $i >= 1; $i--)
                                            <option value="{{ $i }}" @selected($booking->review->rating === $i)>{{ $i }}/5</option>
                                        @endfor
                                    </select>
                                    <textarea name="comment" rows="3" class="rounded-2xl border-slate-300 text-sm">{{ $booking->review->comment }}</textarea>
                                    <button type="submit" class="w-fit rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white">
                                        Сохранить отзыв
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('reviews.destroy', $booking->review) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700">
                                        Удалить отзыв
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="rounded-3xl bg-white p-8 text-sm text-slate-500 shadow-sm">
                У вас пока нет бронирований.
            </div>
        @endforelse
    </div>
</x-app-layout>
