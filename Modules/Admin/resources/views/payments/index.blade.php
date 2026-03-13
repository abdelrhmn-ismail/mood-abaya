@extends('admin::layouts.app')

@section('title', __('Payments'))
@section('heading', __('Payments'))

@section('content')
<form method="GET" class="mb-4 flex flex-wrap gap-2">
    <select name="status" class="rounded-md border-gray-300 text-sm">
        <option value="">{{ __('All statuses') }}</option>
        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>pending</option>
        <option value="pending_approval" {{ request('status') === 'pending_approval' ? 'selected' : '' }}>pending_approval</option>
        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>paid</option>
        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>rejected</option>
    </select>
    <select name="method" class="rounded-md border-gray-300 text-sm">
        <option value="">{{ __('All methods') }}</option>
        <option value="cash" {{ request('method') === 'cash' ? 'selected' : '' }}>cash</option>
        <option value="bank" {{ request('method') === 'bank' ? 'selected' : '' }}>bank</option>
    </select>
    <button type="submit" class="rounded-md bg-gray-200 px-3 py-1 text-sm hover:bg-gray-300">{{ __('Filter') }}</button>
</form>

<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('ID') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Order') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Method') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Status') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Date') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($payments as $payment)
                <tr>
                    <td class="px-4 py-2 text-sm">{{ $payment->id }}</td>
                    <td class="px-4 py-2 text-sm font-mono">{{ $payment->order?->order_number ?? '-' }}</td>
                    <td class="px-4 py-2 text-sm">{{ $payment->method }}</td>
                    <td class="px-4 py-2 text-sm">{{ $payment->status }}</td>
                    <td class="px-4 py-2 text-sm">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.payments.show', $payment) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('View') }}</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">{{ __('No payments found.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $payments->withQueryString()->links() }}</div>
@endsection
