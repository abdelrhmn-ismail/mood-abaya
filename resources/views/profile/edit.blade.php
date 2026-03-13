<x-app-layout>
    <x-slot name="header">{{ __('Profile') }}</x-slot>

    <div class="mx-auto max-w-3xl space-y-8">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:p-8">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
