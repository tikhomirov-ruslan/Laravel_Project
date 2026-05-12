<x-guest-layout background="images/auth-login-background.jpg">
    <div>
        <h1 class="text-4xl font-semibold tracking-tight text-black">{{ __('ui.auth.login_title') }}</h1>
    </div>

    <x-auth-session-status class="mt-6 rounded-2xl border border-emerald-700/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-800" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" class="mb-2 !text-xs !font-medium !text-black/70" />
            <x-text-input id="email" class="block w-full rounded-xl border border-black/10 bg-black/[0.04] px-4 py-3 text-black placeholder:text-black/35 focus:border-[#c7d4a5] focus:ring-[#c7d4a5]" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="hello@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-300" />
        </div>

        <div>
            <x-input-label for="password" :value="__('ui.auth.password')" class="mb-2 !text-xs !font-medium !text-black/70" />
            <x-text-input id="password" class="block w-full rounded-xl border border-black/10 bg-black/[0.04] px-4 py-3 text-black placeholder:text-black/35 focus:border-[#c7d4a5] focus:ring-[#c7d4a5]" type="password" name="password" required autocomplete="current-password" placeholder="{{ __('ui.auth.password') }}" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-300" />
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 text-sm">
            <label class="flex items-center gap-2 text-black/55">
                <input type="checkbox" name="remember" class="rounded border-black/15 bg-black/10 text-[#c7d4a5] focus:ring-[#c7d4a5]">
                {{ __('ui.auth.remember') }}
            </label>
            <a href="{{ route('password.request') }}" class="rounded-xl border border-black/10 bg-black/[0.04] px-3 py-2 text-xs font-semibold text-black/75 transition hover:border-black/25 hover:text-black">{{ __('ui.auth.forgot') }}</a>
        </div>

        <button type="submit" class="w-full rounded-xl bg-[#c7d4a5] px-6 py-3 text-sm font-semibold text-black transition hover:bg-[#d5e1b6] focus:outline-none focus:ring-2 focus:ring-[#c7d4a5] focus:ring-offset-2 focus:ring-offset-black">
            {{ __('ui.nav.login') }}
        </button>
    </form>
</x-guest-layout>
