<x-guest-layout background="images/auth-register-background.jpg">
    <div>
        <h1 class="text-4xl font-semibold tracking-tight text-black">{{ __('ui.auth.register_title') }}</h1>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('ui.auth.name')" class="mb-2 !text-xs !font-medium !text-black/70" />
            <x-text-input id="name" class="block w-full rounded-xl border border-black/10 bg-black/[0.04] px-4 py-3 text-black placeholder:text-black/35 focus:border-[#c7d4a5] focus:ring-[#c7d4a5]" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="{{ __('ui.auth.name') }}" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-rose-300" />
        </div>

        <div>
            <x-input-label for="email" value="Email" class="mb-2 !text-xs !font-medium !text-black/70" />
            <x-text-input id="email" class="block w-full rounded-xl border border-black/10 bg-black/[0.04] px-4 py-3 text-black placeholder:text-black/35 focus:border-[#c7d4a5] focus:ring-[#c7d4a5]" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="andrew@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-300" />
        </div>

        <div>
            <x-input-label for="role" :value="__('ui.auth.role')" class="mb-2 !text-xs !font-medium !text-black/70" />
            <select id="role" name="role" class="block w-full rounded-xl border border-black/10 bg-black/[0.04] px-4 py-3 text-black focus:border-[#c7d4a5] focus:ring-[#c7d4a5]">
                <option value="customer" @selected(old('role', 'customer') === 'customer')>{{ __('ui.auth.customer') }}</option>
                <option value="owner" @selected(old('role') === 'owner')>{{ __('ui.auth.owner') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2 text-rose-300" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <x-input-label for="password" :value="__('ui.auth.password')" class="mb-2 !text-xs !font-medium !text-black/70" />
                <x-text-input id="password" class="block w-full rounded-xl border border-black/10 bg-black/[0.04] px-4 py-3 text-black placeholder:text-black/35 focus:border-[#c7d4a5] focus:ring-[#c7d4a5]" type="password" name="password" required autocomplete="new-password" placeholder="{{ __('ui.auth.password') }}" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-300" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('ui.auth.password_confirmation')" class="mb-2 !text-xs !font-medium !text-black/70" />
                <x-text-input id="password_confirmation" class="block w-full rounded-xl border border-black/10 bg-black/[0.04] px-4 py-3 text-black placeholder:text-black/35 focus:border-[#c7d4a5] focus:ring-[#c7d4a5]" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('ui.auth.password_confirmation') }}" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-rose-300" />
            </div>
        </div>

        <button type="submit" class="w-full rounded-xl bg-[#c7d4a5] px-6 py-3 text-sm font-semibold text-black transition hover:bg-[#d5e1b6] focus:outline-none focus:ring-2 focus:ring-[#c7d4a5] focus:ring-offset-2 focus:ring-offset-black">
            {{ __('ui.nav.register') }}
        </button>
    </form>
</x-guest-layout>
