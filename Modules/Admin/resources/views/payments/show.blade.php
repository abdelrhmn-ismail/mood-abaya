@extends('admin::layouts.app')

@section('title', __('Payment') . ' #' . $payment->id)
@section('heading', __('Payment') . ' #' . $payment->id)

@section('content')
@php
    $orderLink = $payment->order
        ? '<a href="' . e(route('admin.orders.show', $payment->order)) . '" class="text-indigo-600 hover:text-indigo-900">' . e($payment->order->order_number) . '</a>'
        : '—';
    $detailItems = [
        ['label' => __('Order'), 'value' => $orderLink, 'raw' => true],
        ['label' => __('Method'), 'value' => $payment->method],
        ['label' => __('Status'), 'value' => $payment->status],
        ['label' => __('Created'), 'value' => $payment->created_at->format('Y-m-d H:i')],
    ];
@endphp
@component('admin::components.card', ['title' => null])
    @include('admin::components.detail-list', ['items' => $detailItems])
    @if($payment->proof_path)
        <p class="mt-4"><a href="{{ \Illuminate\Support\Facades\Storage::url($payment->proof_path) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">{{ __('View proof') }}</a></p>
    @endif
    @if($payment->method === 'bank' && $payment->status === 'pending_approval')
        <div class="mt-4 flex flex-wrap gap-2">
            <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="rounded-lg bg-green-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-green-700">{{ __('Approve') }}</button>
            </form>
            <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="rounded-lg bg-red-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-red-700">{{ __('Reject') }}</button>
            </form>
        </div>
    @endif
@endcomponent

@include('admin::components.back-link', ['url' => route('admin.payments.index'), 'text' => __('Back to payments')])
@endsection
