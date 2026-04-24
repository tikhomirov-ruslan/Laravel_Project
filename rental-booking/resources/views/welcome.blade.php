<!DOCTYPE html>
<html lang="ru">
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
            <header class="flex items-center justify-between rounded-3xl bg-white px-6 py-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">RB</span>
                    <div>
                        <p class="text-base font-semibold">Rental Booking</p>
                        <p class="text-xs text-slate-500">Жильё в Алматы</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('login') }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700">Войти</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm text-white">Регистрация</a>
                </div>
            </header>

            <section class="mt-6 grid gap-6 md:grid-cols-[1.1fr_0.9fr]">
                <div class="rounded-3xl bg-white p-8 shadow-sm">
                    <p class="text-sm font-semibold text-orange-600">Сервис бронирования</p>
                    <h1 class="mt-4 text-4xl font-bold leading-tight">Квартиры и апартаменты в Алматы</h1>
                    <p class="mt-4 max-w-xl text-sm leading-7 text-slate-600">
                        Находите подходящее жильё, бронируйте на нужные даты и оставляйте отзывы после проживания.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('properties.index') }}" class="rounded-full bg-orange-500 px-5 py-3 text-sm font-semibold text-white">Смотреть жильё</a>
                        <a href="{{ route('register') }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700">Создать аккаунт</a>
                    </div>
                </div>

                <div class="overflow-hidden rounded-3xl bg-slate-900 shadow-sm">
                    <img
                        src="{{ asset('images/almaty-booking-hero.svg') }}"
                        alt="Современные апартаменты для бронирования в Алматы"
                        class="h-full min-h-[320px] w-full object-cover"
                    >
                </div>
            </section>
        </div>
    </body>
</html>
