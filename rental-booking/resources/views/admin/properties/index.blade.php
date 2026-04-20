<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Управление жильём</h1>
                <p class="mt-1 text-sm text-slate-500">Добавление, редактирование и удаление объектов.</p>
            </div>
            <a href="{{ route('admin.properties.create') }}" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white">
                Добавить жильё
            </a>
        </div>
    </x-slot>

    <div class="space-y-4">
        @foreach ($properties as $property)
            <div class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-orange-600">{{ $property->category?->name }}</p>
                        <h2 class="mt-2 text-xl font-semibold text-slate-900">{{ $property->title }}</h2>
                        <p class="mt-2 text-sm text-slate-600">{{ $property->address }}</p>
                        <p class="mt-2 text-sm text-slate-500">Владелец: {{ $property->owner?->name }}</p>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="text-lg font-bold text-slate-900">{{ number_format((float) $property->price_per_night, 0, '.', ' ') }} ₸</p>
                        <p class="mt-1 text-sm text-slate-500">Отзывы: {{ $property->reviews->count() }}</p>
                    </div>
                </div>

                <div class="mt-5 flex flex-wrap gap-3 border-t border-slate-200 pt-5">
                    <a href="{{ route('admin.properties.edit', $property) }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700">
                        Редактировать
                    </a>
                    <form method="POST" action="{{ route('admin.properties.destroy', $property) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-full border border-rose-300 px-4 py-2 text-sm text-rose-700">
                            Удалить
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
