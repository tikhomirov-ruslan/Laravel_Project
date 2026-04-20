<x-guest-layout>
    <div>
        <h2 class="text-3xl font-bold text-slate-900">Восстановление пароля</h2>
        <p class="mt-2 text-sm text-slate-500">Введите email, и мы отправим ссылку для сброса пароля.</p>
    </div>

    <x-auth-session-status class="mt-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <x-input-label for="email" :value="'Email'" />
            <x-text-input id="email" class="mt-2 block w-full rounded-2xl border-slate-300" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <x-primary-button class="rounded-full bg-slate-900 px-6 py-3">
            Отправить ссылку
        </x-primary-button>
    </form>
</x-guest-layout>
