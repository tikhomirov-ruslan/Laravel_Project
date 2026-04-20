<!DOCTYPE html>
<html lang="ru">
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
                <div class="rounded-3xl bg-slate-900 p-8 text-white">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-3 text-lg font-semibold">
                        <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-orange-500 font-bold">RB</span>
                        Rental Booking
                    </a>
                    <div class="mt-10 space-y-4">
                        <h1 class="text-4xl font-bold leading-tight">Простой сервис для бронирования жилья в Алматы</h1>
                        <p class="text-sm leading-6 text-slate-300">
                            Выберите квартиру, отправьте заявку на бронирование, смотрите свои поездки и оставляйте отзывы после проживания.
                        </p>
                    </div>
                    <div class="mt-10 space-y-3 text-sm text-slate-300">
                        <div class="rounded-2xl bg-white/10 px-4 py-3">Квартиры и апартаменты по районам Алматы</div>
                        <div class="rounded-2xl bg-white/10 px-4 py-3">Личный кабинет для гостя и владельца</div>
                        <div class="rounded-2xl bg-white/10 px-4 py-3">Отзывы и оценки после завершения брони</div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white p-6 shadow-sm sm:p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
