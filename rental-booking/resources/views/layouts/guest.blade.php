<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Rental Booking') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-[Inter] text-slate-900 antialiased">
        <div class="mx-auto flex min-h-screen max-w-5xl items-center px-4 py-8 sm:px-6">
            <div class="grid w-full gap-6 md:grid-cols-2">
                <div class="overflow-hidden rounded-3xl bg-slate-900 text-white">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 px-8 pt-8 text-lg font-semibold">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-orange-500 font-bold">RB</span>
                        Rental Booking
                    </a>

                    <div class="px-8 pt-5">
                        <div class="flex w-fit rounded-full border border-white/20 p-1 text-xs font-semibold" aria-label="{{ __('ui.nav.language') }}">
                            @foreach (['en' => 'EN', 'ru' => 'RU'] as $locale => $label)
                                <a href="{{ route('locale.switch', $locale) }}" class="rounded-full px-3 py-1 {{ app()->getLocale() === $locale ? 'bg-white text-slate-900' : 'text-slate-300 hover:bg-white/10' }}">{{ $label }}</a>
                            @endforeach
                        </div>
                    </div>

                    <div class="px-8 pt-6">
                        {{ $visual ?? '' }}
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm sm:p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
