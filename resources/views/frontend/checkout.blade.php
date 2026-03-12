@extends('frontend.layouts.app')

@section('title', __('Checkout') . ' – ' . config('app.name'))
@section('description', __('Checkout'))

@section('content')
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4 max-w-4xl">
            <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">{{ __('Checkout') }}</h1>

            @if(session('error'))
                <div class="mb-6 rounded-lg bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200 px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-10 lg:grid-cols-2">
                @csrf

                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('Shipping Address') }}</h2>
                    <div>
                        <label for="full_name" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Full Name') }} *</label>
                        <input type="text" name="full_name" id="full_name" value="{{ old('full_name', auth()->user()?->name) }}" required
                               class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-gray-900 dark:text-gray-100">
                        @error('full_name')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="phone" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Phone') }} *</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()?->phone) }}" required
                               class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-gray-900 dark:text-gray-100">
                        @error('phone')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="address" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Address') }} *</label>
                        <textarea name="address" id="address" rows="3" required
                                  class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-gray-900 dark:text-gray-100">{{ old('address') }}</textarea>
                        @error('address')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="city" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('City') }} *</label>
                        <input type="text" name="city" id="city" value="{{ old('city') }}" required
                               class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-gray-900 dark:text-gray-100">
                        @error('city')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="notes" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Notes') }}</label>
                        <textarea name="notes" id="notes" rows="2"
                                  class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-4 py-2 text-gray-900 dark:text-gray-100">{{ old('notes') }}</textarea>
                        @error('notes')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>

                    <h2 class="pt-4 text-xl font-semibold text-gray-900 dark:text-white">{{ __('Payment Method') }}</h2>
                    <div class="space-y-3">
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-300 dark:border-gray-600 p-4 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600">
                            <input type="radio" name="payment_method" value="cash" {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }} class="text-blue-600">
                            <span class="font-medium text-gray-900 dark:text-white">{{ __('Cash on Delivery') }}</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-gray-300 dark:border-gray-600 p-4 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600">
                            <input type="radio" name="payment_method" value="bank" {{ old('payment_method') === 'bank' ? 'checked' : '' }} class="text-blue-600" id="pay_bank">
                            <span class="font-medium text-gray-900 dark:text-white">{{ __('Bank Transfer') }}</span>
                        </label>
                    </div>
                    <div id="bank-proof-wrap" class="hidden">
                        <label for="proof" class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Upload payment receipt (image or PDF)') }} *</label>
                        <input type="file" name="proof" id="proof" accept=".jpg,.jpeg,.png,.pdf"
                               class="block w-full text-sm text-gray-600 dark:text-gray-400 file:mr-4 file:rounded-lg file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-gray-800 dark:file:bg-gray-700 dark:file:text-gray-200">
                        @error('proof')<p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <div class="sticky top-24 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-6 shadow-sm">
                        <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">{{ __('Order Summary') }}</h2>
                        <ul class="space-y-3 border-b border-gray-200 dark:border-gray-700 pb-4">
                            @foreach($items as $item)
                                <li class="flex justify-between text-sm">
                                    <span class="text-gray-700 dark:text-gray-300">{{ $item->product->name }} × {{ $item->quantity }}</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ number_format($item->product->price * $item->quantity, 2) }} {{ __('SAR') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-4 flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                            {{ __('Total') }}: {{ number_format($total, 2) }} {{ __('SAR') }}
                        </p>
                        <button type="submit" class="mt-6 w-full rounded-lg bg-blue-600 py-3 font-medium text-white hover:bg-blue-700">
                            {{ __('Place Order') }}
                        </button>
                        <a href="{{ route('cart') }}" class="mt-3 block text-center text-sm text-gray-600 dark:text-gray-400 hover:underline">{{ __('Back to Cart') }}</a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
            radio.addEventListener('change', function () {
                document.getElementById('bank-proof-wrap').classList.toggle('hidden', this.value !== 'bank');
                document.getElementById('proof').required = this.value === 'bank';
            });
        });
        if (document.getElementById('pay_bank').checked) {
            document.getElementById('bank-proof-wrap').classList.remove('hidden');
            document.getElementById('proof').required = true;
        }
    </script>
    @endpush
@endsection
