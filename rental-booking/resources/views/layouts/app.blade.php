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
    <body class="min-h-screen bg-slate-100 font-[Inter] antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            @isset($header)
                <header class="border-b border-slate-200 bg-white">
                    <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="mx-auto max-w-6xl px-4 py-6 sm:px-6">
                @if (session('status'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->has('review'))
                    <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        {{ $errors->first('review') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>
    </body>
</html>
