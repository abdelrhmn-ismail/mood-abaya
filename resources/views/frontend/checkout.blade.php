@extends('frontend.layouts.app')

@section('title', __('Checkout') . ' – ' . config('app.name'))
@section('description', __('Checkout'))

@section('content')
    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-4xl px-4">
            <h1 class="text-4xl font-bold text-slate-900">{{ __('Checkout') }}</h1>

            @if(session('error'))
                <div class="mt-6 rounded-xl bg-red-100 px-4 py-3 text-red-800">{{ session('error') }}</div>
            @endif

            <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="mt-10 grid gap-10 lg:grid-cols-2">
                @csrf

                <div class="space-y-6">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('Shipping Address') }}</h2>
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="space-y-4">
                            <div>
                                <label for="full_name" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Full Name') }} *</label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('full_name', auth()->user()?->name) }}" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                                @error('full_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="phone" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Phone') }} *</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', auth()->user()?->phone) }}" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                                @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="address" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Address') }} *</label>
                                <textarea name="address" id="address" rows="3" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">{{ old('address') }}</textarea>
                                @error('address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="city" class="mb-1 block text-sm font-medium text-slate-700">{{ __('City') }} *</label>
                                <input type="text" name="city" id="city" value="{{ old('city') }}" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                                @error('city')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="notes" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Notes') }}</label>
                                <textarea name="notes" id="notes" rows="2" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">{{ old('notes') }}</textarea>
                                @error('notes')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <h2 class="pt-4 text-xl font-semibold text-slate-900">{{ __('Payment Method') }}</h2>
                    <div class="space-y-3">
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-300 bg-white p-4 transition has-[:checked]:border-slate-900 has-[:checked]:ring-2 has-[:checked]:ring-slate-900/20">
                            <input type="radio" name="payment_method" value="cash" {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }} class="text-slate-900">
                            <span class="font-medium text-slate-900">{{ __('Cash on Delivery') }}</span>
                        </label>
                        <label class="flex cursor-pointer items-center gap-3 rounded-xl border border-slate-300 bg-white p-4 transition has-[:checked]:border-slate-900 has-[:checked]:ring-2 has-[:checked]:ring-slate-900/20">
                            <input type="radio" name="payment_method" value="bank" {{ old('payment_method') === 'bank' ? 'checked' : '' }} class="text-slate-900" id="pay_bank">
                            <span class="font-medium text-slate-900">{{ __('Bank Transfer') }}</span>
                        </label>
                    </div>
                    <div id="bank-proof-wrap" class="hidden">
                        <label for="proof" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Upload payment receipt (image or PDF)') }} *</label>
                        <input type="file" name="proof" id="proof" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-slate-800">
                        @error('proof')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <div class="sticky top-24 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-slate-900">{{ __('Order Summary') }}</h2>
                        <ul class="mt-4 space-y-3 border-b border-slate-200 pb-4">
                            @foreach($items as $item)
                                <li class="flex justify-between text-sm">
                                    <span class="text-slate-600">{{ $item->product->name }} × {{ $item->quantity }}</span>
                                    <span class="font-medium text-slate-900">{{ number_format($item->product->price * $item->quantity, 2) }} {{ __('SAR') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-4 flex justify-between text-lg font-bold text-slate-900">
                            {{ __('Total') }}: {{ number_format($total, 2) }} {{ __('SAR') }}
                        </p>
                        <button type="submit" class="mt-6 w-full rounded-xl bg-slate-900 py-3.5 font-semibold text-white hover:bg-slate-800">
                            {{ __('Place Order') }}
                        </button>
                        <a href="{{ route('cart') }}" class="mt-3 block text-center text-sm text-slate-600 hover:underline">{{ __('Back to Cart') }}</a>
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
