<x-app-layout>
    <x-slot name="header">{{ __('Dashboard') }}</x-slot>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
        <p class="text-slate-600">{{ __("You're logged in!") }}</p>
        <div class="mt-4 flex flex-wrap gap-3">
            <a href="{{ route('account') }}" class="rounded-xl bg-brand-teal px-5 py-2.5 font-semibold text-white hover:bg-brand-teal-dark">
                {{ __('My Account') }}
            </a>
            <a href="{{ route('categories') }}" class="rounded-xl border border-slate-300 px-5 py-2.5 font-medium text-slate-700 hover:bg-slate-50">
                {{ __('Browse Shop') }}
            </a>
        </div>
    </div>
</x-app-layout>
