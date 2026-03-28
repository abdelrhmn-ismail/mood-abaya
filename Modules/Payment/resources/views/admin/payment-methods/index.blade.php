@extends('admin.layouts.app')

@section('title', __('Payment methods'))
@section('heading', __('Payment methods'))

@section('content')
@component('components.admin.card', ['title' => null])
    <p class="mb-4 text-sm text-gray-600">{{ __('Enable or disable methods, edit labels, and set bank details shown at checkout. Add custom gateways when you integrate new providers.') }}</p>
    <div class="mb-4">
        <a href="{{ route('admin.payment-methods.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">add</span> {{ __('Add payment method') }}
        </a>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Sort') }}</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Code') }}</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Name (EN)') }}</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Status') }}</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Behavior') }}</th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @foreach($methods as $m)
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $m->sort_order }}</td>
                        <td class="px-4 py-3 font-mono text-sm text-gray-900">{{ $m->code }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $m->name_en }}</td>
                        <td class="px-4 py-3">
                            @if($m->is_active)
                                <span class="inline-flex rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">{{ __('Active') }}</span>
                            @else
                                <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600">{{ __('Inactive') }}</span>
                            @endif
                            <form action="{{ route('admin.payment-methods.toggle', $m) }}" method="POST" class="mt-2 inline">
                                @csrf
                                <button type="submit" class="text-xs font-medium text-brand-teal hover:underline">{{ $m->is_active ? __('Turn off') : __('Turn on') }}</button>
                            </form>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">
                            @if($m->requires_proof)<span class="mr-2 inline-block rounded bg-slate-100 px-2 py-0.5">{{ __('Receipt upload') }}</span>@endif
                            @if($m->requires_admin_approval)<span class="inline-block rounded bg-amber-100 px-2 py-0.5 text-amber-900">{{ __('Admin approval') }}</span>@endif
                        </td>
                        <td class="px-4 py-3 text-right text-sm">
                            <a href="{{ route('admin.payment-methods.edit', $m) }}" class="inline-flex items-center gap-1 rounded-lg px-3 py-2 font-medium text-brand-teal transition hover:bg-brand-gold/10">{{ __('Edit') }}</a>
                            @if(!$m->is_system)
                                <form action="{{ route('admin.payment-methods.destroy', $m) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Delete this payment method?') }}');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg px-3 py-2 font-medium text-red-600 transition hover:bg-red-50">{{ __('Delete') }}</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endcomponent
@endsection
