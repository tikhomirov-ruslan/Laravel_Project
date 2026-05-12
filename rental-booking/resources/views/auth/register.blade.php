<x-guest-layout>
    <x-slot:visual>
        <div class="space-y-5">
            <div>
                <h1 class="text-4xl font-bold leading-tight">{{ __('ui.auth.register_hero_title') }}</h1>
                <p class="mt-3 text-sm leading-6 text-slate-300">
                    {{ __('ui.auth.register_hero_text') }}
                </p>
            </div>

            <img
                src="{{ asset('images/register.svg') }}"
                alt="{{ __('ui.auth.register_alt') }}"
                class="h-[360px] w-full rounded-[28px] object-cover"
            >
        </div>
    </x-slot:visual>

    <div>
        <h2 class="text-3xl font-bold text-slate-900">{{ __('ui.auth.register_title') }}</h2>
        <p class="mt-2 text-sm text-slate-500">{{ __('ui.auth.register_text') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="__('ui.auth.name')" />
            <x-text-input id="name" class="mt-2 block w-full rounded-2xl border-slate-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-2 block w-full rounded-2xl border-slate-300" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role" :value="__('ui.auth.role')" />
            <select id="role" name="role" class="mt-2 block w-full rounded-2xl border-slate-300">
                <option value="customer" @selected(old('role', 'customer') === 'customer')>{{ __('ui.auth.customer') }}</option>
                <option value="owner" @selected(old('role') === 'owner')>{{ __('ui.auth.owner') }}</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('ui.auth.password')" />
            <x-text-input id="password" class="mt-2 block w-full rounded-2xl border-slate-300" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('ui.auth.password_confirmation')" />
            <x-text-input id="password_confirmation" class="mt-2 block w-full rounded-2xl border-slate-300" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between gap-4">
            <a class="text-sm text-slate-600" href="{{ route('login') }}">{{ __('ui.auth.already_account') }}</a>
            <x-primary-button class="rounded-full bg-orange-500 px-6 py-3 hover:bg-orange-600">
                {{ __('ui.nav.register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
