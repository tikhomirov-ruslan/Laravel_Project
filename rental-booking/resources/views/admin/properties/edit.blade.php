<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Редактировать жильё</h1>
            <p class="mt-1 text-sm text-slate-500">{{ $property->title }}</p>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.properties.update', $property) }}" class="rounded-3xl bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')
        @include('admin.properties._form')

        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white">Обновить</button>
            <a href="{{ route('admin.properties.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm text-slate-700">Назад</a>
        </div>
    </form>
</x-app-layout>
