<x-guest-layout>
    <div>
        <h2 class="text-3xl font-bold text-slate-900">Регистрация</h2>
        <p class="mt-2 text-sm text-slate-500">Создайте аккаунт гостя или владельца жилья.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf

        <div>
            <x-input-label for="name" :value="'Имя'" />
            <x-text-input id="name" class="mt-2 block w-full rounded-2xl border-slate-300" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="mt-2 block w-full rounded-2xl border-slate-300" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role" :value="'Тип аккаунта'" />
            <select id="role" name="role" class="mt-2 block w-full rounded-2xl border-slate-300">
                <option value="customer" @selected(old('role', 'customer') === 'customer')>Гость</option>
                <option value="owner" @selected(old('role') === 'owner')>Владелец жилья</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
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

        <div class="flex items-center justify-between gap-4">
            <a class="text-sm text-slate-600" href="{{ route('login') }}">Уже есть аккаунт?</a>
            <x-primary-button class="rounded-full bg-orange-500 px-6 py-3 hover:bg-orange-600">
                Зарегистрироваться
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
