<x-guest-layout>
    <div>
        <h1 class="text-4xl font-semibold tracking-tight text-white">{{ __('ui.auth.confirm_title') }}</h1>
        <p class="mt-4 max-w-sm text-sm leading-6 text-white/45">
            {{ __('ui.auth.confirm_text') }}
        </p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="password" :value="__('ui.auth.password')" class="mb-2 !text-xs !font-medium !text-white/70" />
            <x-text-input id="password" class="block w-full rounded-xl border border-white/10 bg-white/[0.08] px-4 py-3 text-white placeholder:text-white/25 focus:border-[#c7d4a5] focus:ring-[#c7d4a5]" type="password" name="password" required autocomplete="current-password" placeholder="{{ __('ui.auth.password') }}" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-300" />
        </div>

        <button type="submit" class="w-full rounded-xl bg-[#c7d4a5] px-6 py-3 text-sm font-semibold text-black transition hover:bg-[#d5e1b6]">
            {{ __('ui.auth.confirm_button') }}
        </button>

        <a href="{{ route('home') }}" class="block w-full rounded-xl border border-white/10 bg-white/[0.06] px-6 py-3 text-center text-sm font-semibold text-white/75 transition hover:border-white/25 hover:text-white">
            {{ __('ui.nav.home') }}
        </a>
    </form>
</x-guest-layout>
