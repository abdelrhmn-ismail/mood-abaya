@extends('admin::layouts.app')

@section('title', __('Contact messages'))
@section('heading', __('Contact messages'))

@section('content')
<div class="overflow-x-auto rounded-lg bg-white shadow">
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Name') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Email') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Subject') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Read') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500">{{ __('Date') }}</th>
                <th class="px-4 py-2 text-left text-xs font-medium uppercase text-gray-500"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($messages as $message)
                <tr class="{{ !$message->read_at ? 'bg-blue-50' : '' }}">
                    <td class="px-4 py-2 text-sm">{{ $message->name }}</td>
                    <td class="px-4 py-2 text-sm">{{ $message->email }}</td>
                    <td class="px-4 py-2 text-sm">{{ Str::limit($message->subject, 40) }}</td>
                    <td class="px-4 py-2 text-sm">{{ $message->read_at ? __('Yes') : __('No') }}</td>
                    <td class="px-4 py-2 text-sm">{{ $message->created_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.contacts.show', $message) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('View') }}</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-gray-500">{{ __('No messages yet.') }}</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $messages->links() }}</div>
@endsection
