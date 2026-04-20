<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Личный кабинет</h1>
            <p class="mt-1 text-sm text-slate-500">Добро пожаловать, {{ auth()->user()->name }}.</p>
        </div>
    </x-slot>

    <div class="grid gap-6 md:grid-cols-3">
        <a href="{{ route('properties.index') }}" class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Смотреть жильё</h2>
            <p class="mt-2 text-sm text-slate-600">Каталог квартир и апартаментов по Алматы.</p>
        </a>
        <a href="{{ route('bookings.index') }}" class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Мои бронирования</h2>
            <p class="mt-2 text-sm text-slate-600">Будущие и завершённые брони в одном месте.</p>
        </a>
        <a href="{{ route('profile.edit') }}" class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">Профиль</h2>
            <p class="mt-2 text-sm text-slate-600">Изменить имя, email и пароль.</p>
        </a>
    </div>
</x-app-layout>
