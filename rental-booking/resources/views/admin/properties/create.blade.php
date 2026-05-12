<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">{{ __('ui.admin.create_title') }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ __('ui.admin.create_subtitle') }}</p>
        </div>
    </x-slot>

    <form method="POST" action="{{ route('admin.properties.store') }}" enctype="multipart/form-data" class="rounded-3xl bg-white p-6 shadow-sm">
        @csrf
        @include('admin.properties._form')

        <div class="mt-6 flex gap-3">
            <button type="submit" class="rounded-full bg-slate-900 px-5 py-3 text-sm font-semibold text-white">{{ __('ui.admin.save') }}</button>
            <a href="{{ route('admin.properties.index') }}" class="rounded-full border border-slate-300 px-5 py-3 text-sm text-slate-700">{{ __('ui.admin.cancel') }}</a>
        </div>
    </form>
</x-app-layout>
