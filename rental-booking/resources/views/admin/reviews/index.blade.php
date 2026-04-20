<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Модерация отзывов</h1>
            <p class="mt-1 text-sm text-slate-500">Просмотр и удаление отзывов пользователей.</p>
        </div>
    </x-slot>

    <div class="space-y-4">
        @foreach ($reviews as $review)
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-orange-600">{{ $review->property?->title }}</p>
                        <h2 class="mt-2 text-lg font-semibold text-slate-900">{{ $review->user?->name }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $review->comment }}</p>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="text-sm text-slate-500">Оценка: {{ $review->rating }}/5</p>
                        <p class="mt-1 text-sm text-slate-500">Бронь #{{ $review->booking_id }}</p>
                    </div>
                </div>

                <div class="mt-5 border-t border-slate-200 pt-5">
                    <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-full border border-rose-300 px-4 py-2 text-sm text-rose-700">
                            Удалить отзыв
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
