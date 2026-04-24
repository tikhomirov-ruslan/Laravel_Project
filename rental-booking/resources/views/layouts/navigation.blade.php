<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-6xl px-4 sm:px-6">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-900 text-sm font-bold text-white">RB</span>
                    <span class="text-base font-semibold text-slate-900">Rental Booking</span>
                </a>

                <div class="hidden items-center gap-5 md:flex">
                    <a href="{{ route('properties.index') }}" class="text-sm {{ request()->routeIs('properties.*') ? 'font-semibold text-slate-900' : 'text-slate-600' }}">Жильё</a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm {{ request()->routeIs('dashboard') ? 'font-semibold text-slate-900' : 'text-slate-600' }}">Главная</a>
                        <a href="{{ url('/bookings') }}" class="text-sm {{ request()->is('bookings') || request()->is('my-bookings') ? 'font-semibold text-slate-900' : 'text-slate-600' }}">Мои брони</a>
                        <a href="{{ url('/profile') }}" class="text-sm {{ request()->is('profile') ? 'font-semibold text-slate-900' : 'text-slate-600' }}">Профиль</a>
                        @if (Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-sm {{ request()->routeIs('admin.*') ? 'font-semibold text-slate-900' : 'text-slate-600' }}">Админ-панель</a>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden md:flex md:items-center md:gap-4">
                @auth
                    <div class="text-right">
                        <p class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-500 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50">
                            Выйти
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50">
                        Войти
                    </a>
                    <a href="{{ route('register') }}" class="rounded-full bg-slate-900 px-4 py-2 text-sm text-white transition hover:bg-slate-800">
                        Регистрация
                    </a>
                @endauth
            </div>

            <button @click="open = !open" class="md:hidden rounded-xl border border-slate-300 px-3 py-2 text-sm text-slate-700">
                Меню
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak class="border-t border-slate-200 bg-white md:hidden">
        <div class="space-y-2 px-4 py-4">
            <a href="{{ route('properties.index') }}" class="block rounded-xl px-3 py-2 text-sm text-slate-700">Жильё</a>

            @auth
                <a href="{{ route('dashboard') }}" class="block rounded-xl px-3 py-2 text-sm text-slate-700">Главная</a>
                <a href="{{ url('/bookings') }}" class="block rounded-xl px-3 py-2 text-sm text-slate-700">Мои брони</a>
                <a href="{{ url('/profile') }}" class="block rounded-xl px-3 py-2 text-sm text-slate-700">Профиль</a>
                @if (Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-3 py-2 text-sm text-slate-700">Админ-панель</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-xl px-3 py-2 text-left text-sm text-slate-700">Выйти</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block rounded-xl px-3 py-2 text-sm text-slate-700">Войти</a>
                <a href="{{ route('register') }}" class="block rounded-xl px-3 py-2 text-sm text-slate-700">Регистрация</a>
            @endauth
        </div>
    </div>
</nav>
