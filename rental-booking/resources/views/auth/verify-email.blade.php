<x-guest-layout>
    <div>
        <h1 class="text-4xl font-semibold tracking-tight text-white">{{ __('ui.auth.verify_title') }}</h1>
        <p class="mt-4 max-w-sm text-sm leading-6 text-white/45">
            {{ __('ui.auth.verify_text') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mt-6 rounded-2xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
            {{ __('ui.auth.verify_sent') }}
        </div>
    @endif

    <div class="mt-8 space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button type="submit" class="w-full rounded-xl bg-[#c7d4a5] px-6 py-3 text-sm font-semibold text-black transition hover:bg-[#d5e1b6]">
                {{ __('ui.auth.resend_verification') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="w-full rounded-xl border border-white/10 bg-white/[0.06] px-6 py-3 text-sm font-semibold text-white/75 transition hover:border-white/25 hover:text-white">
                {{ __('ui.nav.logout') }}
            </button>
        </form>

        <a href="{{ route('home') }}" class="block w-full rounded-xl border border-white/10 bg-white/[0.06] px-6 py-3 text-center text-sm font-semibold text-white/75 transition hover:border-white/25 hover:text-white">
            {{ __('ui.nav.home') }}
        </a>
    </div>
</x-guest-layout>
