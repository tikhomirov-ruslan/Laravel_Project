@props(['background' => 'images/auth-login-background.jpg'])

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
    <body class="min-h-screen bg-[#989d92] font-[Inter] {{ request()->routeIs('login', 'register') ? 'text-black' : 'text-white' }} antialiased">
        <div class="flex min-h-screen items-center justify-center px-4 py-8 sm:px-6 lg:px-10">
            <div class="grid w-full max-w-6xl overflow-hidden rounded-[30px] border border-black/70 bg-black shadow-2xl shadow-black/30 lg:min-h-[690px] lg:grid-cols-[1.05fr_0.95fr]">
                <section
                    class="relative min-h-[300px] overflow-hidden bg-cover bg-center lg:min-h-full"
                    style="background-image: url('{{ asset($background) }}');"
                >
                    <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-black/5 to-black/45"></div>
                    <div class="absolute inset-x-0 top-0 h-40 bg-gradient-to-b from-black/45 to-transparent"></div>

                    <a href="{{ route('home') }}" class="absolute left-6 top-6 z-10 inline-flex items-center gap-3 rounded-2xl border border-white/20 bg-black/25 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-black/20 backdrop-blur-md">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white font-bold text-black">RB</span>
                        <span class="tracking-wide">Rental Booking</span>
                    </a>
                </section>

                <section class="relative flex min-h-[620px] flex-col overflow-hidden {{ request()->routeIs('login', 'register') ? 'bg-white' : 'bg-black' }} px-6 py-6 sm:px-10 lg:px-16">
                    <div class="pointer-events-none absolute -right-24 top-0 h-72 w-72 rounded-full bg-[#c7d4a5]/10 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-24 left-16 h-64 w-64 rounded-full bg-white/5 blur-3xl"></div>

                    <header class="relative z-10 flex items-center justify-end gap-4 text-xs {{ request()->routeIs('login', 'register') ? 'text-black/55' : 'text-white/55' }}">
                        <a href="{{ route('home') }}" class="font-medium transition {{ request()->routeIs('login', 'register') ? 'hover:text-black' : 'hover:text-white' }}">{{ __('ui.nav.home') }}</a>

                        <div class="flex items-center gap-4">
                            @if (request()->routeIs('register'))
                                <a href="{{ route('login') }}" class="font-medium transition {{ request()->routeIs('login', 'register') ? 'hover:text-black' : 'hover:text-white' }}">{{ __('ui.nav.login') }}</a>
                            @else
                                <a href="{{ route('register') }}" class="font-medium transition {{ request()->routeIs('login', 'register') ? 'hover:text-black' : 'hover:text-white' }}">{{ __('ui.nav.register') }}</a>
                            @endif

                            <span class="h-4 w-px {{ request()->routeIs('login', 'register') ? 'bg-black/15' : 'bg-white/15' }}"></span>

                            @foreach (['en' => 'EN', 'ru' => 'RU'] as $locale => $label)
                                <a href="{{ route('locale.switch', $locale) }}" class="font-medium transition {{ request()->routeIs('login', 'register') ? 'hover:text-black' : 'hover:text-white' }} {{ app()->getLocale() === $locale ? (request()->routeIs('login', 'register') ? 'text-black' : 'text-white') : '' }}">{{ $label }}</a>
                            @endforeach
                        </div>
                    </header>

                    <main class="relative z-10 flex flex-1 items-center">
                        <div class="mx-auto w-full max-w-md">
                            {{ $slot }}
                        </div>
                    </main>

                    <footer class="relative z-10 flex items-center justify-between gap-4 border-t {{ request()->routeIs('login', 'register') ? 'border-black/10 text-black/35' : 'border-white/10 text-white/35' }} pt-5 text-xs">
                        <span>2026 Rental Booking</span>
                    </footer>
                </section>
            </div>
        </div>
    </body>
</html>
