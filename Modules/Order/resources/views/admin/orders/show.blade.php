@extends('admin.layouts.app')

@section('title', __('Order') . ' ' . $order->order_number)
@section('heading', '')

@php
    $shippingAddr = $order->shipping_address;
    if (is_string($shippingAddr)) {
        $shippingAddr = json_decode($shippingAddr, true) ?: [];
    }
    $billingAddr = $order->billing_address;
    if (is_string($billingAddr)) {
        $billingAddr = json_decode($billingAddr, true) ?: [];
    }
    $addressLine = function ($arr) {
        if (!is_array($arr)) return '';
        if (!empty($arr['address'])) {
            return $arr['address'] . (isset($arr['city']) ? ', ' . $arr['city'] : '');
        }
        $parts = array_filter([
            $arr['address_line_1'] ?? null,
            $arr['address_line_2'] ?? null,
            $arr['city'] ?? null,
            $arr['state'] ?? null,
            $arr['postal_code'] ?? null,
            $arr['country'] ?? null,
        ]);
        return implode(', ', $parts);
    };
@endphp

@section('content')
<div class="space-y-6">
    {{-- Order info bar --}}
    <div class="flex flex-wrap items-center gap-4 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
        <span class="flex items-center gap-2 text-sm text-gray-600">
            <span class="material-icons text-xl text-gray-400">tag</span>
            <strong class="text-gray-900">{{ $order->order_number }}</strong>
        </span>
        <span class="rounded-full px-3 py-1 text-xs font-medium
            @if($order->status === 'delivered') bg-green-100 text-green-800
            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
            @elseif(in_array($order->status, ['shipped', 'processing'])) bg-blue-100 text-blue-800
            @else bg-amber-100 text-amber-800
            @endif">
            {{ __($order->status) }}
        </span>
        <span class="text-sm text-gray-500">{{ $order->created_at->format('M j, Y H:i') }}</span>
        <span class="ml-auto text-lg font-semibold text-gray-900">{{ number_format($order->total, 2) }} {{ __('SAR') }}</span>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Customer & delivery address --}}
        <div class="space-y-6">
            @component('components.admin.card', ['title' => __('Customer & delivery')])
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-gold/20 text-brand-teal">
                            <span class="material-icons">person</span>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Customer name') }}</p>
                            <p class="mt-0.5 text-sm font-medium text-gray-900">{{ $order->user?->name ?? '—' }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                            <span class="material-icons">email</span>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Email') }}</p>
                            <p class="mt-0.5 text-sm font-medium text-gray-900 break-all">{{ $order->user?->email ?? '—' }}</p>
                        </div>
                    </div>
                    @if(is_array($shippingAddr) && !empty($shippingAddr))
                        <div class="flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                <span class="material-icons">phone</span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Phone') }}</p>
                                <p class="mt-0.5 text-sm font-medium text-gray-900">{{ $shippingAddr['phone'] ?? $order->user?->phone ?? '—' }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                                <span class="material-icons">location_on</span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Delivery address') }}</p>
                                <p class="mt-0.5 text-sm text-gray-900">{{ $shippingAddr['full_name'] ?? '' }}@if(!empty($shippingAddr['full_name']) && $addressLine($shippingAddr))<br>@endif{{ $addressLine($shippingAddr) ?: '—' }}</p>
                            </div>
                        </div>
                        @if(!empty($shippingAddr['notes']))
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                                    <span class="material-icons">note</span>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Order notes') }}</p>
                                    <p class="mt-0.5 text-sm text-gray-700">{{ $shippingAddr['notes'] }}</p>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="flex items-start gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                                <span class="material-icons">phone</span>
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Phone') }}</p>
                                <p class="mt-0.5 text-sm text-gray-900">{{ $order->user?->phone ?? '—' }}</p>
                            </div>
                        </div>
                        @if($order->shipping_address)
                            <div class="flex items-start gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                                    <span class="material-icons">location_on</span>
                                </span>
                                <div class="min-w-0 flex-1">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Address') }}</p>
                                    <p class="mt-0.5 whitespace-pre-wrap text-sm text-gray-900">{{ is_string($order->shipping_address) ? $order->shipping_address : json_encode($order->shipping_address, JSON_UNESCAPED_UNICODE) }}</p>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            @endcomponent

            {{-- Billing address (if different) --}}
            @if(is_array($billingAddr) && !empty($billingAddr))
                @component('components.admin.card', ['title' => __('Billing address')])
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-violet-50 text-violet-600">
                            <span class="material-icons">receipt</span>
                        </span>
                        <div class="min-w-0 flex-1 text-sm text-gray-700">
                            <p class="font-medium text-gray-900">{{ $billingAddr['full_name'] ?? '—' }}</p>
                            @if(!empty($billingAddr['phone']))<p class="mt-0.5">{{ $billingAddr['phone'] }}</p>@endif
                            <p class="mt-1 text-gray-600">{{ $addressLine($billingAddr) ?: '—' }}</p>
                        </div>
                    </div>
                @endcomponent
            @endif
        </div>

        {{-- Order status & Payment --}}
        <div class="space-y-6">
            @component('components.admin.card', ['title' => __('Order status')])
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex flex-wrap items-center gap-3">
                    @csrf
                    @method('PUT')
                    <span class="material-icons text-gray-400">swap_horiz</span>
                    <select name="status" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                        @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">{{ __('Update status') }}</button>
                </form>
            @endcomponent

            @if($payment)
                @component('components.admin.card', ['title' => __('Payment')])
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">
                            <span class="material-icons">payment</span>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900">{{ ucfirst($payment->method) }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $payment->status ?? '')) }}</p>
                        </div>
                    </div>
                    @if($payment->method === 'cash' && $payment->status !== 'paid')
                        <form action="{{ route('admin.payments.markPaid', $payment) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                                <span class="material-icons text-lg">check_circle</span> {{ __('Mark as paid') }}
                            </button>
                        </form>
                    @endif
                    @if($payment->method === 'bank' && $payment->status === 'pending_approval')
                        @if($payment->proof_path)
                            <p class="mt-3">
                                <a href="{{ \Illuminate\Support\Facades\Storage::url($payment->proof_path) }}" target="_blank" class="inline-flex items-center gap-1 text-sm text-brand-teal hover:text-brand-teal-dark">
                                    <span class="material-icons text-lg">attach_file</span> {{ __('View proof') }}
                                </a>
                            </p>
                        @endif
                        <div class="mt-4 flex flex-wrap gap-2">
                            <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">
                                    <span class="material-icons text-lg">check</span> {{ __('Approve') }}
                                </button>
                            </form>
                            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                                    <span class="material-icons text-lg">close</span> {{ __('Reject') }}
                                </button>
                            </form>
                        </div>
                    @endif
                @endcomponent
            @endif

            @component('components.admin.card', ['title' => __('Shipping')])
                @if($order->shippings->isNotEmpty())
                    @php $s = $order->shippings->first(); @endphp
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span class="material-icons text-gray-400">local_shipping</span>
                            <span class="text-sm font-medium text-gray-900">{{ $s->carrier }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <span class="material-icons text-gray-400">pin</span>
                            <span>{{ $s->tracking_number }}</span>
                        </div>
                        @if($s->shipped_at)
                            <div class="flex items-center gap-3 text-sm text-gray-500">
                                <span class="material-icons text-gray-400">schedule</span>
                                <span>{{ $s->shipped_at->format('M j, Y H:i') }}</span>
                            </div>
                        @endif
                    </div>
                @endif
                <form action="{{ route('admin.orders.ship', $order) }}" method="POST" class="mt-4 space-y-3 border-t border-gray-200 pt-4">
                    @csrf
                    <div class="flex flex-wrap gap-2">
                        <input type="text" name="carrier" placeholder="{{ __('Carrier') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal" required>
                        <input type="text" name="tracking_number" placeholder="{{ __('Tracking number') }}" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal" required>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        <span class="material-icons text-lg">local_shipping</span> {{ __('Mark as shipped') }}
                    </button>
                </form>
            @endcomponent
        </div>
    </div>

    {{-- Order items (full width) --}}
    @component('components.admin.card', ['title' => __('Items')])
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Product') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Qty') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Price') }}</th>
                        <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Total') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $item->product?->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($item->price, 2) }} {{ __('SAR') }}</td>
                            <td class="px-4 py-3 text-right text-sm font-medium text-gray-900">{{ number_format($item->quantity * $item->price, 2) }} {{ __('SAR') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-end border-t border-gray-200 pt-4">
            <p class="text-lg font-semibold text-gray-900">{{ __('Total') }}: {{ number_format($order->total, 2) }} {{ __('SAR') }}</p>
        </div>
    @endcomponent
</div>

@include('components.admin.back-link', ['url' => route('admin.orders.index'), 'text' => __('Back to orders')])
@endsection
