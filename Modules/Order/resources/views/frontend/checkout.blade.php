@extends('frontend.layouts.app')

@section('title', __('Checkout') . ' – ' . site_title())
@section('description', __('Checkout'))

@section('content')
    <x-frontend.hero-header :title="__('Checkout')" :subtitle="__('Complete your order')" setting="hero_checkout" />

    <section class="bg-slate-50 py-16 md:py-20">
        <div class="container mx-auto max-w-6xl px-4">
            @if(session('error'))
                <div class="mt-6 rounded-xl bg-red-100 px-4 py-3 text-red-800">{{ session('error') }}</div>
            @endif

            @php
                $initialBillingUse = old('billing_use', ($billingAddresses ?? collect())->isNotEmpty() ? 'saved' : 'new');
            @endphp
            <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" class="mt-10 grid gap-10 lg:grid-cols-[1.4fr_1fr]" data-initial-billing-use="{{ $initialBillingUse }}">
                @csrf

                <div class="space-y-6">
                    {{-- Address: choose saved or add new (used for delivery & billing) --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm" x-data="{ billingUse: '{{ old('billing_use', ($billingAddresses ?? collect())->isNotEmpty() ? 'saved' : 'new') }}' }">
                        <div class="space-y-4">
                            @if(isset($billingAddresses) && $billingAddresses->isNotEmpty())
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" name="billing_use" value="saved" x-model="billingUse" class="text-brand-black">
                                        <span class="text-sm font-medium text-slate-700">{{ __('Use a saved address') }}</span>
                                    </label>
                                    <label class="flex cursor-pointer items-center gap-2">
                                        <input type="radio" name="billing_use" value="new" x-model="billingUse" class="text-brand-black">
                                        <span class="text-sm font-medium text-slate-700">{{ __('Add new address') }}</span>
                                    </label>
                                </div>
                                <div x-show="billingUse === 'saved'" x-cloak class="mt-3">
                                    <label for="billing_address_id" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Choose address') }} *</label>
                                    <select name="billing_address_id" id="billing_address_id" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                        <option value="">{{ __('Select…') }}</option>
                                        @foreach($billingAddresses ?? [] as $addr)
                                            <option value="{{ $addr->id }}" {{ old('billing_address_id', $addr->is_default ? $addr->id : null) == $addr->id ? 'selected' : '' }}>
                                                {{ $addr->label ? $addr->label . ' – ' : '' }}{{ $addr->full_name }}, {{ $addr->city }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('billing_address_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            @else
                                <input type="hidden" name="billing_use" value="new">
                            @endif
                            <div id="checkout-billing-new-fields" x-show="billingUse === 'new'" x-cloak class="space-y-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                                <p class="text-sm font-medium text-slate-700">{{ __('Enter billing details') }}</p>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div class="sm:col-span-2">
                                        <label for="billing_full_name" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Full name') }} *</label>
                                        <input type="text" name="billing_full_name" id="billing_full_name" value="{{ old('billing_full_name', auth()->user()?->name) }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                        @error('billing_full_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                                <div>
                                    <x-phone-input name="billing_phone" id="billing_phone" :value="old('billing_phone', auth()->user()?->phone)" :required="false" :label="__('Phone')" />
                                </div>
                                <div>
                                    <label for="billing_address_line_1" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Address line 1') }} *</label>
                                    <input type="text" name="billing_address_line_1" id="billing_address_line_1" value="{{ old('billing_address_line_1') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                    @error('billing_address_line_1')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="billing_address_line_2" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Address line 2') }} ({{ __('optional') }})</label>
                                    <input type="text" name="billing_address_line_2" id="billing_address_line_2" value="{{ old('billing_address_line_2') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="billing_city" class="mb-1 block text-sm font-medium text-slate-700">{{ __('City') }} *</label>
                                        <input type="text" name="billing_city" id="billing_city" value="{{ old('billing_city') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                        @error('billing_city')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    </div>
                                    <div>
                                        <label for="billing_state" class="mb-1 block text-sm font-medium text-slate-700">{{ __('State / Region') }}</label>
                                        <input type="text" name="billing_state" id="billing_state" value="{{ old('billing_state') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                    </div>
                                </div>
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="billing_postal_code" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Postal code') }}</label>
                                        <input type="text" name="billing_postal_code" id="billing_postal_code" value="{{ old('billing_postal_code') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">
                                    </div>
                                    <div>
                                        <x-country-select name="billing_country" id="billing_country" :value="old('billing_country', 'Saudi Arabia')" :label="__('Country')" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <label for="notes" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Order notes') }}</label>
                                <textarea name="notes" id="notes" rows="2" placeholder="{{ __('Optional instructions for delivery…') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20">{{ old('notes') }}</textarea>
                                @error('notes')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative lg:contents">
                    <div class="sticky top-24 z-10 self-start rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                        <h2 class="text-xl font-semibold text-brand-black">{{ __('Payment Method') }}</h2>
                        @php
                            $firstCode = ($paymentMethods ?? collect())->first()?->code ?? 'cash';
                            $selectedPm = old('payment_method', $firstCode);
                        @endphp
                        <div class="mt-3 space-y-3">
                            @forelse($paymentMethods ?? [] as $pm)
                                <label class="payment-method-option flex cursor-pointer items-start gap-3 rounded-xl border border-slate-300 bg-white p-4 transition has-[:checked]:border-slate-900 has-[:checked]:ring-2 has-[:checked]:ring-slate-900/20">
                                    <input type="radio" name="payment_method" value="{{ $pm->code }}" id="pay_{{ $pm->code }}"
                                        class="payment-method-radio mt-1 text-brand-black"
                                        data-requires-proof="{{ $pm->requires_proof ? '1' : '0' }}"
                                        {{ $selectedPm === $pm->code ? 'checked' : '' }}>
                                    <span class="font-medium text-brand-black">
                                        {{ $pm->nameForLocale() }}
                                        @if($pm->descriptionForLocale())
                                            <span class="mt-1 block text-sm font-normal text-slate-600">{{ $pm->descriptionForLocale() }}</span>
                                        @endif
                                    </span>
                                </label>
                            @empty
                                <p class="text-sm text-red-600">{{ __('No payment methods available.') }}</p>
                            @endforelse
                        </div>
                        @foreach($paymentMethods ?? [] as $pm)
                            @if($pm->instructionsForLocale())
                                <div id="payment-instr-{{ $pm->code }}" class="payment-method-instructions mt-3 hidden rounded-xl border border-brand-teal/30 bg-brand-teal/5 p-4 text-left text-sm text-slate-700">
                                    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-brand-teal">{{ __('Payment details') }}</p>
                                    <div class="whitespace-pre-wrap text-slate-800">{!! nl2br(e($pm->instructionsForLocale())) !!}</div>
                                </div>
                            @endif
                        @endforeach
                        <div id="payment-proof-wrap" class="mt-3 hidden">
                            <label for="proof" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Upload payment receipt (image or PDF)') }} *</label>
                            <input type="file" name="proof" id="proof" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-slate-600 file:mr-4 file:rounded-xl file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-sm file:font-medium file:text-slate-800">
                            @error('proof')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <h2 class="mt-6 text-xl font-semibold text-brand-black">{{ __('Order Summary') }}</h2>
                        <ul class="mt-4 space-y-3 border-b border-slate-200 pb-4">
                            @foreach($items as $item)
                                <li class="flex justify-between text-sm">
                                    <span class="text-slate-600">{{ $item->product->name }} × {{ $item->quantity }}</span>
                                    <span class="font-medium text-brand-black">{{ number_format($item->product->price * $item->quantity, 2) }} {{ __('SAR') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-3 flex justify-between text-sm text-slate-600">
                            <span>{{ __('Subtotal') }}</span>
                            <span id="checkout-subtotal">{{ number_format($subtotal, 2) }} {{ __('SAR') }}</span>
                        </p>
                        @if($shippingType === 'zones' && count($shippingZones) > 0)
                            <div class="mt-2">
                                <label for="shipping_zone_id" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Delivery area') }}</label>
                                <select name="shipping_zone_id" id="shipping_zone_id" class="block w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-brand-black focus:border-brand-teal focus:ring-2 focus:ring-brand-teal/20" data-zones='@json($shippingZones)' data-subtotal="{{ $subtotal }}">
                                    @foreach($shippingZones as $z)
                                        <option value="{{ $z['id'] }}" data-amount="{{ $z['amount'] }}" {{ $loop->first ? 'selected' : '' }}>{{ $z['label'] }} — {{ number_format($z['amount'], 2) }} {{ __('SAR') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            @if($shippingType === 'free_over' && $shippingFreeOver && $subtotal < $shippingFreeOver)
                                <p class="mt-1 text-xs text-brand-teal">{{ __('Free shipping on orders over') }} {{ number_format($shippingFreeOver, 0) }} {{ __('SAR') }}</p>
                            @endif
                            <input type="hidden" name="shipping_zone_id" value="">
                        @endif
                        <p class="mt-2 flex justify-between text-sm text-slate-600">
                            <span>{{ __('Shipping') }}@if($shippingLabel && $shippingLabel !== __('Shipping')) ({{ $shippingLabel }})@endif</span>
                            <span id="checkout-shipping">@if($shippingAmount > 0){{ number_format($shippingAmount, 2) }} {{ __('SAR') }}@else{{ __('Free') }}@endif</span>
                        </p>
                        <p class="mt-4 flex justify-between items-baseline gap-2 text-lg font-bold text-brand-black">
                            <span>{{ __('Total') }}:</span>
                            <span class="flex items-baseline gap-1.5"><span id="checkout-total">{{ number_format($total, 2) }}</span><span class="font-semibold text-slate-600">{{ __('SAR') }}</span></span>
                        </p>
                        @php $checkoutBadges = array_filter(trust_badges()); @endphp
                        @if(!empty($checkoutBadges))
                            <div class="mt-4 flex flex-wrap items-center justify-center gap-4 border-t border-slate-100 pt-4 text-xs text-slate-500">
                                @foreach($checkoutBadges as $badge)
                                    <span class="flex items-center gap-1"><span class="material-icons text-base text-brand-teal">verified</span> {{ $badge }}</span>
                                @endforeach
                            </div>
                        @endif
                        <button type="submit" class="mt-6 w-full rounded-xl bg-brand-teal py-3.5 font-semibold text-white hover:bg-brand-teal-dark">
                            {{ __('Place Order') }}
                        </button>
                    </div>
                </div>
            </form>
            <script>
            (function(){
                var form = document.getElementById('checkout-form');
                var section = document.getElementById('checkout-billing-new-fields');
                if (form && section && form.getAttribute('data-initial-billing-use') === 'saved') {
                    section.querySelectorAll('[required]').forEach(function(el){ el.removeAttribute('required'); });
                }
            })();
            </script>
        </div>
    </section>

    @push('scripts')
    <script>
        function checkoutPaymentUi() {
            var selected = document.querySelector('input[name="payment_method"]:checked');
            var code = selected ? selected.value : '';
            document.querySelectorAll('.payment-method-instructions').forEach(function (el) { el.classList.add('hidden'); });
            var instr = document.getElementById('payment-instr-' + code);
            if (instr) { instr.classList.remove('hidden'); }
            var proofWrap = document.getElementById('payment-proof-wrap');
            var proof = document.getElementById('proof');
            var requiresProof = selected && selected.getAttribute('data-requires-proof') === '1';
            if (proofWrap) { proofWrap.classList.toggle('hidden', !requiresProof); }
            if (proof) { proof.required = !!requiresProof; }
        }
        document.querySelectorAll('input[name="payment_method"]').forEach(function (radio) {
            radio.addEventListener('change', checkoutPaymentUi);
        });
        checkoutPaymentUi();
        // When "Use a saved address" is selected, remove required from hidden "new address" fields so validation doesn't block submit.
        (function () {
            var form = document.querySelector('form[action*="checkout.store"]');
            if (!form) return;
            var section = document.getElementById('checkout-billing-new-fields');
            if (!section) return;
            var requiredNames = ['billing_full_name', 'billing_phone_country_code', 'billing_phone_number', 'billing_address_line_1', 'billing_city'];
            function setNewAddressRequired(required) {
                requiredNames.forEach(function (name) {
                    var el = section.querySelector('[name="' + name + '"]');
                    if (el) {
                        if (required) el.setAttribute('required', 'required');
                        else el.removeAttribute('required');
                    }
                });
            }
            function updateFromRadios() {
                var checked = form.querySelector('input[name="billing_use"]:checked');
                setNewAddressRequired(checked ? checked.value === 'new' : true);
            }
            // Use server-rendered initial state so we run before Alpine and avoid hidden required fields
            var initial = form.getAttribute('data-initial-billing-use');
            setNewAddressRequired(initial === 'new');
            // After Alpine may have run, sync again
            setTimeout(updateFromRadios, 100);
            form.querySelectorAll('input[name="billing_use"]').forEach(function (radio) {
                radio.addEventListener('change', updateFromRadios);
            });
        })();
        // Shipping zone change: update displayed shipping and total
        (function () {
            var sel = document.getElementById('shipping_zone_id');
            if (!sel) return;
            var subtotal = parseFloat(sel.getAttribute('data-subtotal')) || 0;
            function updateTotals() {
                var opt = sel.options[sel.selectedIndex];
                var amount = opt ? parseFloat(opt.getAttribute('data-amount')) || 0 : 0;
                var total = subtotal + amount;
                var shipEl = document.getElementById('checkout-shipping');
                var totalEl = document.getElementById('checkout-total');
                if (shipEl) shipEl.textContent = amount > 0 ? amount.toFixed(2) + ' {{ __("SAR") }}' : '{{ __("Free") }}';
                if (totalEl) totalEl.textContent = total.toFixed(2);
            }
            sel.addEventListener('change', updateTotals);
        })();
    </script>
    @endpush
@endsection
