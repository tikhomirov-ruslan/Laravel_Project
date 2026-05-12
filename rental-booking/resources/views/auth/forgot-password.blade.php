<x-guest-layout>
    <div>
        <h1 class="text-4xl font-semibold tracking-tight text-white">{{ __('ui.auth.forgot_title') }}</h1>
        <p class="mt-4 max-w-sm text-sm leading-6 text-white/45">{{ __('ui.auth.forgot_text') }}</p>
    </div>

    <x-auth-session-status class="mt-6 rounded-2xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" class="mb-2 !text-xs !font-medium !text-white/70" />
            <x-text-input id="email" class="block w-full rounded-xl border border-white/10 bg-white/[0.08] px-4 py-3 text-white placeholder:text-white/25 focus:border-[#c7d4a5] focus:ring-[#c7d4a5]" type="email" name="email" :value="old('email')" required autofocus placeholder="hello@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-300" />
        </div>

        <button type="submit" class="w-full rounded-xl bg-[#c7d4a5] px-6 py-3 text-sm font-semibold text-black transition hover:bg-[#d5e1b6]">
            {{ __('ui.auth.send_link') }}
        </button>

        <a href="{{ route('login') }}" class="block w-full rounded-xl border border-white/10 bg-white/[0.06] px-6 py-3 text-center text-sm font-semibold text-white/75 transition hover:border-white/25 hover:text-white">
            {{ __('ui.nav.login') }}
        </a>

        <a href="{{ route('home') }}" class="block w-full rounded-xl border border-white/10 bg-white/[0.06] px-6 py-3 text-center text-sm font-semibold text-white/75 transition hover:border-white/25 hover:text-white">
            {{ __('ui.nav.home') }}
        </a>
    </form>
</x-guest-layout>
