@extends('admin.layouts.app')

@section('title', __('Payment') . ' #' . $payment->id)
@section('heading', '')

@section('content')
<div class="space-y-6">
    {{-- Payment info bar --}}
    <div class="flex flex-wrap items-center gap-4 rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm">
        <span class="flex items-center gap-2 text-sm text-gray-600">
            <span class="material-icons text-xl text-gray-400">payment</span>
            <strong class="text-gray-900">{{ __('Payment') }} #{{ $payment->id }}</strong>
        </span>
        <span class="rounded-full px-3 py-1 text-xs font-medium
            @if($payment->method === 'bank') bg-brand-gold/30 text-brand-teal
            @else bg-gray-100 text-gray-800
            @endif">
            {{ ucfirst($payment->method) }}
        </span>
        <span class="rounded-full px-3 py-1 text-xs font-medium
            @if($payment->status === 'paid') bg-green-100 text-green-800
            @elseif($payment->status === 'rejected') bg-red-100 text-red-800
            @elseif($payment->status === 'pending_approval') bg-amber-100 text-amber-800
            @else bg-gray-100 text-gray-800
            @endif">
            {{ ucfirst(str_replace('_', ' ', $payment->status ?? '')) }}
        </span>
        <span class="text-sm text-gray-500">{{ $payment->created_at->format('M j, Y H:i') }}</span>
    </div>

    <div class="grid gap-6 lg:grid-cols-2">
        {{-- Payment details --}}
        @component('components.admin.card', ['title' => __('Payment details')])
            <div class="space-y-4">
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                        <span class="material-icons">receipt_long</span>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Order') }}</p>
                        <p class="mt-0.5 text-sm font-medium text-gray-900">
                            @if($payment->order)
                                <a href="{{ route('admin.orders.show', $payment->order) }}" class="text-brand-teal hover:text-brand-teal-dark hover:underline">{{ $payment->order->order_number }}</a>
                            @else
                                —
                            @endif
                        </p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">
                        <span class="material-icons">payments</span>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Method') }}</p>
                        <p class="mt-0.5 text-sm font-medium text-gray-900">{{ ucfirst($payment->method) }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-600">
                        <span class="material-icons">info</span>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Status') }}</p>
                        <p class="mt-0.5 text-sm font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $payment->status ?? '')) }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-sky-600">
                        <span class="material-icons">schedule</span>
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('Created') }}</p>
                        <p class="mt-0.5 text-sm font-medium text-gray-900">{{ $payment->created_at->format('M j, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        @endcomponent

        {{-- Proof & actions --}}
        <div class="space-y-6">
            @if($payment->proof_path)
                @component('components.admin.card', ['title' => __('Proof')])
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-amber-50 text-amber-600">
                            <span class="material-icons">attach_file</span>
                        </span>
                        <div class="min-w-0 flex-1">
                            <a href="{{ \Illuminate\Support\Facades\Storage::url($payment->proof_path) }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-sm font-medium text-brand-teal hover:text-brand-teal-dark">
                                <span class="material-icons text-lg">open_in_new</span> {{ __('View proof') }}
                            </a>
                        </div>
                    </div>
                @endcomponent
            @endif

            @component('components.admin.card', ['title' => __('Actions')])
                @if($payment->method === 'cash' && $payment->status !== 'paid')
                    <form action="{{ route('admin.payments.markPaid', $payment) }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700">
                            <span class="material-icons text-lg">check_circle</span> {{ __('Mark as paid') }}
                        </button>
                    </form>
                @endif
                @if($payment->method === 'bank' && $payment->status === 'pending_approval')
                    <div class="flex flex-wrap gap-3">
                        <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-green-700">
                                <span class="material-icons text-lg">check</span> {{ __('Approve') }}
                            </button>
                        </form>
                        <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-red-700">
                                <span class="material-icons text-lg">close</span> {{ __('Reject') }}
                            </button>
                        </form>
                    </div>
                @endif
                @if(($payment->method === 'cash' && $payment->status === 'paid') || ($payment->method === 'bank' && $payment->status !== 'pending_approval'))
                    <p class="text-sm text-gray-500">{{ __('No actions available.') }}</p>
                @endif
            @endcomponent
        </div>
    </div>
</div>

@include('components.admin.back-link', ['url' => route('admin.payments.index'), 'text' => __('Back to payments')])
@endsection
