<x-guest-layout>
    @if (session('status'))
        <div class="mb-6 rounded-xl bg-green-100 px-4 py-3 text-sm text-green-800">{{ session('status') }}</div>
    @endif

    <h1 class="text-2xl font-bold text-slate-900">{{ __('Log in') }}</h1>
    <p class="mt-1 text-sm text-slate-600">{{ __('Sign in to your account') }}</p>

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-slate-700">{{ __('Email') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-slate-700">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember"
                   class="rounded border-slate-300 text-slate-900 focus:ring-slate-900/20">
            <label for="remember_me" class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</label>
        </div>

        <div class="flex flex-col gap-4 pt-2 sm:flex-row sm:items-center sm:justify-between">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 transition">
                    {{ __('Forgot your password?') }}
                </a>
            @else
                <span></span>
            @endif
            <button type="submit" class="w-full rounded-xl bg-brand-teal px-6 py-3 font-semibold text-white transition hover:bg-brand-teal-dark focus:outline-none focus:ring-2 focus:ring-brand-teal focus:ring-offset-2 sm:w-auto">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    <div class="mt-6 text-center text-sm text-slate-600">
        <a href="{{ route('register') }}" class="font-medium text-slate-600 hover:text-slate-900 transition">
            {{ __('Register') }}
        </a>
    </div>
</x-guest-layout>
