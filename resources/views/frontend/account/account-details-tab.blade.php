{{-- Account details tab: profile forms --}}
<div class="space-y-8">
    @if(session('status') === 'profile-updated')
        <p class="rounded-lg bg-green-50 px-4 py-2 text-sm text-green-800">{{ __('Saved.') }}</p>
    @endif
    @if(session('status') === 'password-updated')
        <p class="rounded-lg bg-green-50 px-4 py-2 text-sm text-green-800">{{ __('Saved.') }}</p>
    @endif
    <div class="rounded-xl border border-slate-200 bg-slate-50/30 p-6">
        @include('profile.partials.update-profile-information-form')
    </div>
    <div class="rounded-xl border border-slate-200 bg-slate-50/30 p-6">
        @include('profile.partials.update-password-form')
    </div>
    <div class="rounded-xl border border-slate-200 bg-slate-50/30 p-6">
        @include('profile.partials.delete-user-form')
    </div>
</div>
