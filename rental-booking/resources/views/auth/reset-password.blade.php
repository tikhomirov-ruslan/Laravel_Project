<x-guest-layout>
    <div>
        <h2 class="text-3xl font-bold text-slate-900">Новый пароль</h2>
        <p class="mt-2 text-sm text-slate-500">Введите email и задайте новый пароль.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="mt-2 block w-full rounded-2xl border-slate-300" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="'Пароль'" />
            <x-text-input id="password" class="mt-2 block w-full rounded-2xl border-slate-300" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="'Подтверждение пароля'" />
            <x-text-input id="password_confirmation" class="mt-2 block w-full rounded-2xl border-slate-300" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="rounded-full bg-slate-900 px-6 py-3">
            Сохранить пароль
        </x-primary-button>
    </form>
</x-guest-layout>
