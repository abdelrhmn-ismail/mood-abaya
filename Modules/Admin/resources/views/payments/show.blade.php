@extends('admin::layouts.app')

@section('title', __('Payment') . ' #' . $payment->id)
@section('heading', __('Payment') . ' #' . $payment->id)

@section('content')
<div class="rounded-lg bg-white p-6 shadow">
    <p><strong>{{ __('Order') }}:</strong> <a href="{{ route('admin.orders.show', $payment->order) }}" class="text-indigo-600">{{ $payment->order?->order_number }}</a></p>
    <p><strong>{{ __('Method') }}:</strong> {{ $payment->method }}</p>
    <p><strong>{{ __('Status') }}:</strong> {{ $payment->status }}</p>
    <p><strong>{{ __('Created') }}:</strong> {{ $payment->created_at->format('Y-m-d H:i') }}</p>
    @if($payment->proof_path)
        <p class="mt-2"><a href="{{ \Illuminate\Support\Facades\Storage::url($payment->proof_path) }}" target="_blank" class="text-indigo-600">{{ __('View proof') }}</a></p>
    @endif
    @if($payment->method === 'bank' && $payment->status === 'pending_approval')
        <form action="{{ route('admin.payments.approve', $payment) }}" method="POST" class="mt-4 inline">
            @csrf
            <button type="submit" class="rounded-md bg-green-600 px-3 py-1 text-sm text-white hover:bg-green-700">{{ __('Approve') }}</button>
        </form>
        <form action="{{ route('admin.payments.reject', $payment) }}" method="POST" class="ml-2 inline">
            @csrf
            <button type="submit" class="rounded-md bg-red-600 px-3 py-1 text-sm text-white hover:bg-red-700">{{ __('Reject') }}</button>
        </form>
    @endif
</div>
<p class="mt-4"><a href="{{ route('admin.payments.index') }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Back to payments') }}</a></p>
@endsection
