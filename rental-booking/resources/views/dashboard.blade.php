<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ __('ui.dashboard.title') }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ __('ui.dashboard.welcome', ['name' => auth()->user()->name]) }}</p>
        </div>
    </x-slot>

    <div class="grid gap-6 md:grid-cols-3">
        <a href="{{ route('properties.index') }}" class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">{{ __('ui.dashboard.browse_title') }}</h2>
            <p class="mt-2 text-sm text-slate-600">{{ __('ui.dashboard.browse_text') }}</p>
        </a>
        <a href="{{ url('/bookings') }}" class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">{{ __('ui.dashboard.bookings_title') }}</h2>
            <p class="mt-2 text-sm text-slate-600">{{ __('ui.dashboard.bookings_text') }}</p>
        </a>
        <a href="{{ route('profile.edit') }}" class="rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="text-lg font-semibold">{{ __('ui.dashboard.profile_title') }}</h2>
            <p class="mt-2 text-sm text-slate-600">{{ __('ui.dashboard.profile_text') }}</p>
        </a>
    </div>
</x-app-layout>
