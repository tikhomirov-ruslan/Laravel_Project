<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Rental Booking') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-slate-100 font-[Inter] text-slate-900 antialiased">
        <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6">
            <header class="flex flex-col gap-4 rounded-3xl bg-white px-6 py-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">RB</span>
                    <div>
                        <p class="text-base font-semibold">Rental Booking</p>
                        <p class="text-xs text-slate-500">{{ __('ui.app.tagline') }}</p>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex rounded-full border border-slate-300 p-1 text-xs font-semibold" aria-label="{{ __('ui.nav.language') }}">
                        @foreach (['en' => 'EN', 'ru' => 'RU'] as $locale => $label)
                            <a href="{{ route('locale.switch', $locale) }}" class="rounded-full px-3 py-1 {{ app()->getLocale() === $locale ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-50' }}">{{ $label }}</a>
                        @endforeach
                    </div>
                    <a href="{{ route('login') }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700">{{ __('ui.nav.login') }}</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm text-white">{{ __('ui.nav.register') }}</a>
                </div>
            </header>

            <section class="mt-6 grid gap-6 md:grid-cols-[1.1fr_0.9fr]">
                <div class="rounded-3xl bg-white p-8 shadow-sm">
                    <p class="text-sm font-semibold text-orange-600">{{ __('ui.app.service') }}</p>
                    <h1 class="mt-4 text-4xl font-bold leading-tight">{{ __('ui.home.title') }}</h1>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-slate-600">
                        {{ __('ui.home.subtitle') }}
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('properties.index') }}" class="rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white">{{ __('ui.home.browse') }}</a>
                        <a href="{{ route('register') }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700">{{ __('ui.home.create_account') }}</a>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-slate-900 shadow-sm">
                    <img
                        src="{{ asset('images/almaty-booking-hero.svg') }}"
                        alt="{{ __('ui.home.hero_alt') }}"
                        class="h-full min-h-[320px] w-full object-cover"
                    >
                </div>
            </section>
        </div>
    </body>
</html>
