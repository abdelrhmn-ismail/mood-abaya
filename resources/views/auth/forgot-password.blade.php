<x-guest-layout>
    <h1 class="text-2xl font-bold text-slate-900">{{ __('Forgot your password?') }}</h1>
    <p class="mt-2 text-sm text-slate-600">
        {{ __('No problem. Enter your email and we will send you a password reset link.') }}
    </p>

    @if (session('status'))
        <div class="mt-6 rounded-xl bg-green-100 px-4 py-3 text-sm text-green-800">{{ session('status') }}</div>
    @endif

    @error('email')
        <div class="mt-4 rounded-xl bg-red-100 px-4 py-3 text-sm text-red-800">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('password.email') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
        </div>

        <div class="flex flex-wrap items-center gap-4">
            <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900">{{ __('Back to login') }}</a>
            <button type="submit" class="rounded-xl bg-brand-teal px-6 py-3 font-semibold text-white hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
</x-guest-layout>
