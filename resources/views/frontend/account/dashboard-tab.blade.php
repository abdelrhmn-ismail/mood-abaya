{{-- Dashboard tab content --}}
<div class="space-y-6">
    <h2 class="text-lg font-semibold text-slate-900">{{ __('Dashboard') }}</h2>
    <p class="text-sm text-slate-600">
        {{ __('Hello :name', ['name' => $user->name]) }} —
        {{ __('From your account dashboard you can view your recent orders and manage your details.') }}
    </p>
    <dl class="grid gap-4 text-sm text-slate-600 md:grid-cols-2">
        <div>
            <dt class="font-medium text-slate-900">{{ __('Your Name') }}</dt>
            <dd>{{ $user->name }}</dd>
        </div>
        <div>
            <dt class="font-medium text-slate-900">{{ __('Your Email') }}</dt>
            <dd>{{ $user->email }}</dd>
        </div>
        @if($user->phone)
            <div>
                <dt class="font-medium text-slate-900">{{ __('Phone') }}</dt>
                <dd>{{ $user->phone }}</dd>
            </div>
        @endif
    </dl>
    <button type="button" @click="tab = 'account-details'"
            class="rounded-xl bg-brand-teal px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-teal-dark">
        {{ __('Edit Profile') }}
    </button>
</div>
