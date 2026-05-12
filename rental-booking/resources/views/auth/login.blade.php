<x-guest-layout>
    <x-slot:visual>
        <div class="space-y-5">
            <div>
                <h1 class="text-4xl font-bold leading-tight">{{ __('ui.auth.login_hero_title') }}</h1>
                <p class="mt-3 text-sm leading-6 text-slate-300">
                    {{ __('ui.auth.login_hero_text') }}
                </p>
            </div>

            <img
                src="{{ asset('images/login.svg') }}"
                alt="{{ __('ui.auth.login_alt') }}"
                class="h-[360px] w-full rounded-[28px] object-cover"
            >
        </div>
    </x-slot:visual>

    <div>
        <h2 class="text-3xl font-bold text-slate-900">{{ __('ui.auth.login_title') }}</h2>
        <p class="mt-2 text-sm text-slate-500">{{ __('ui.auth.login_text') }}</p>
    </div>

    <x-auth-session-status class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-2 block w-full rounded-2xl border-slate-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('ui.auth.password')" />
            <x-text-input id="password" class="mt-2 block w-full rounded-2xl border-slate-300" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label class="flex items-center gap-3 text-sm text-slate-600">
            <input type="checkbox" name="remember" class="rounded border-slate-300 text-orange-500 focus:ring-orange-400">
            {{ __('ui.auth.remember') }}
        </label>

        <div class="flex items-center justify-between gap-4">
            <a href="{{ route('password.request') }}" class="text-sm text-slate-600">{{ __('ui.auth.forgot') }}</a>
            <x-primary-button class="rounded-full bg-slate-900 px-6 py-3">
                {{ __('ui.nav.login') }}
            </x-primary-button>
        </div>
    </form>

    <p class="mt-6 text-sm text-slate-600">
        {{ __('ui.auth.no_account') }}
        <a href="{{ route('register') }}" class="font-semibold text-orange-600">{{ __('ui.auth.register_link') }}</a>
    </p>
</x-guest-layout>
