<x-guest-layout>
    <h1 class="text-2xl font-bold text-slate-900">{{ __('Verify your email') }}</h1>
    <p class="mt-2 text-sm text-slate-600">
        {{ __('Thanks for signing up! Please verify your email by clicking the link we sent you. If you didn\'t receive it, we can send another.') }}
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="mt-6 rounded-xl bg-green-100 px-4 py-3 text-sm text-green-800">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="rounded-xl bg-brand-teal px-6 py-3 font-semibold text-white hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2">
                {{ __('Resend Verification Email') }}
            </button>
        </form>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm font-medium text-slate-600 hover:text-slate-900">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
