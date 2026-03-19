{{-- Orders tab: list or selected order detail (same page) --}}
<div class="space-y-6">
    @if(isset($selectedOrder) && $selectedOrder)
        @php
            $statusSteps = ['pending' => 1, 'processing' => 2, 'shipped' => 3, 'delivered' => 4];
            $currentStep = $statusSteps[strtolower($selectedOrder->status)] ?? 1;
        @endphp
        @if(session('success'))
            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">{{ session('error') }}</div>
        @endif
        {{-- Back link --}}
        <a href="{{ route('account') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-600 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-900">
            <span class="material-icons text-lg">arrow_back</span>
            {{ __('Back to orders list') }}
        </a>

        {{-- Order header with progress --}}
        <div class="animate-order-detail overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 bg-gradient-to-br from-slate-50 to-white px-6 py-5">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-brand-teal text-white">
                            <span class="material-icons text-2xl">receipt_long</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-slate-900">{{ __('Order') }} {{ $selectedOrder->order_number }}</h2>
                            <p class="mt-0.5 text-sm text-slate-500">{{ $selectedOrder->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    <span class="rounded-full px-3.5 py-1.5 text-xs font-semibold uppercase tracking-wide
                        @if($selectedOrder->status === 'pending') bg-amber-100 text-amber-800
                        @elseif($selectedOrder->status === 'processing') bg-blue-100 text-blue-800
                        @elseif($selectedOrder->status === 'shipped') bg-indigo-100 text-indigo-800
                        @elseif($selectedOrder->status === 'delivered') bg-emerald-100 text-emerald-800
                        @else bg-slate-100 text-slate-700 @endif">
                        {{ __($selectedOrder->status) }}
                    </span>
                </div>
                {{-- Progress stepper --}}
                <div class="mt-6 flex items-center gap-2" role="list" aria-label="{{ __('Order progress') }}">
                    @foreach(['pending' => ['schedule', __('Pending')], 'processing' => ['sync', __('Processing')], 'shipped' => ['local_shipping', __('Shipped')], 'delivered' => ['check_circle', __('Delivered')]] as $stepKey => $stepLabel)
                        @php $stepNum = $statusSteps[$stepKey] ?? 0; $isDone = $currentStep > $stepNum; $isCurrent = $currentStep === $stepNum; @endphp
                        <div class="flex flex-1 items-center" role="listitem">
                            <div class="flex flex-col items-center gap-1.5">
                                <div class="relative flex h-10 w-10 shrink-0 items-center justify-center rounded-full border-2 transition-all duration-300
                                    @if($isDone) border-emerald-500 bg-emerald-500 text-white
                                    @elseif($isCurrent) border-slate-900 bg-brand-teal text-white ring-4 ring-slate-900/20
                                    @else border-slate-200 bg-white text-slate-400 @endif">
                                    @if($isDone)
                                        <span class="material-icons text-lg">check</span>
                                    @else
                                        <span class="material-icons text-lg">{{ $stepLabel[0] }}</span>
                                    @endif
                                </div>
                                <span class="text-xs font-medium @if($isCurrent) text-slate-900 @elseif($isDone) text-emerald-700 @else text-slate-400 @endif">{{ $stepLabel[1] }}</span>
                            </div>
                            @if(!$loop->last)
                                <div class="mx-1 h-0.5 min-w-[12px] flex-1 rounded-full transition-all duration-500 @if($isDone) bg-emerald-500 @else bg-slate-200 @endif"></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Summary cards --}}
            <div class="grid gap-4 p-6 sm:grid-cols-2 lg:grid-cols-3">
                <div class="flex items-center gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-200/80 text-slate-600">
                        <span class="material-icons">event</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ __('Date') }}</p>
                        <p class="mt-0.5 font-semibold text-slate-900">{{ $selectedOrder->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-200/80 text-slate-600">
                        <span class="material-icons">payments</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ __('Payment') }}</p>
                        <p class="mt-0.5 font-semibold text-slate-900">{{ __($selectedOrder->payment_method) }} · {{ __($selectedOrder->payment_status) }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4 sm:col-span-2 lg:col-span-1">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-200/80 text-slate-600">
                        <span class="material-icons">shopping_bag</span>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ __('Items') }}</p>
                        <p class="mt-0.5 font-semibold text-slate-900">{{ $selectedOrder->items->count() }} {{ $selectedOrder->items->count() === 1 ? __('item') : __('items') }}</p>
                    </div>
                </div>
            </div>

            {{-- Items list --}}
            <div class="border-t border-slate-100 px-6 pb-6">
                <h3 class="mb-4 flex items-center gap-2 pt-6 text-base font-semibold text-slate-900">
                    <span class="material-icons text-slate-600">inventory_2</span>
                    {{ __('Items') }}
                </h3>
                @php $reviewedIds = $reviewedProductIds ?? []; @endphp
                <ul class="space-y-3">
                    @foreach($selectedOrder->items as $item)
                        <li class="rounded-xl border border-slate-100 bg-white p-4 shadow-sm transition hover:border-slate-200 hover:shadow">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="h-12 w-12 shrink-0 rounded-lg bg-slate-100 flex items-center justify-center text-slate-500">
                                        <span class="material-icons">inventory</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="font-medium text-slate-900 truncate">{{ $item->product?->name ?? '-' }}</p>
                                        <p class="text-sm text-slate-500">{{ __('Qty') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }} {{ __('SAR') }}</p>
                                    </div>
                                </div>
                                <span class="shrink-0 font-semibold text-slate-900">{{ number_format($item->quantity * $item->price, 2) }} {{ __('SAR') }}</span>
                            </div>
                            @if($selectedOrder->status === 'delivered')
                                @if(in_array($item->product_id, $reviewedIds))
                                    <p class="mt-3 flex items-center gap-2 text-sm text-emerald-600">
                                        <span class="material-icons text-lg">check_circle</span>
                                        {{ __('Reviewed') }}
                                    </p>
                                @else
                                    <form action="{{ route('account.order-review.store') }}" method="POST" class="mt-4 border-t border-slate-100 pt-4" x-data="{ hover: 0, selected: 5 }" @change="if ($event.target.name === 'rating') selected = parseInt($event.target.value)">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $selectedOrder->id }}">
                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                        <p class="mb-2 text-sm font-medium text-slate-700">{{ __('Add review') }}</p>
                                        <div class="flex flex-wrap items-center gap-4">
                                            <div class="flex items-center gap-1" role="group" aria-label="{{ __('Rating') }}">
                                                @for($r = 1; $r <= 5; $r++)
                                                    <label class="cursor-pointer focus-within:text-amber-500 transition-colors"
                                                           @mouseenter="hover = {{ $r }}"
                                                           @mouseleave="hover = 0"
                                                           :class="{{ $r }} <= (hover || selected) ? 'text-amber-400' : 'text-slate-300'">
                                                        <input type="radio" name="rating" value="{{ $r }}" class="sr-only" {{ $r == 5 ? 'checked' : '' }}>
                                                        <span class="material-icons text-2xl">star</span>
                                                    </label>
                                                @endfor
                                            </div>
                                            <input type="text" name="comment" placeholder="{{ __('Your comment (optional)') }}" maxlength="2000" class="min-w-[200px] flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm">
                                            <button type="submit" class="rounded-xl bg-brand-teal px-4 py-2 text-sm font-medium text-white hover:bg-brand-teal-dark">{{ __('Submit review') }}</button>
                                        </div>
                                        @error('rating')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </form>
                                @endif
                            @endif
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 flex items-center justify-between rounded-xl bg-brand-teal px-5 py-4 text-white">
                    <span class="font-semibold">{{ __('Total') }}</span>
                    <span class="text-xl font-bold">{{ number_format($selectedOrder->total, 2) }} {{ __('SAR') }}</span>
                </div>
            </div>

            @if($selectedOrder->shippings->isNotEmpty())
                @php $shipping = $selectedOrder->shippings->first(); @endphp
                <div class="border-t border-slate-100 px-6 py-6">
                    <h3 class="mb-4 flex items-center gap-2 text-base font-semibold text-slate-900">
                        <span class="material-icons rounded-lg bg-indigo-100 p-1.5 text-indigo-600">local_shipping</span>
                        {{ __('Shipping') }}
                    </h3>
                    <div class="flex flex-wrap gap-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ __('Carrier') }}</p>
                            <p class="mt-0.5 font-medium text-slate-900">{{ $shipping->carrier }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">{{ __('Tracking number') }}</p>
                            <p class="mt-0.5 font-mono font-medium text-slate-900">{{ $shipping->tracking_number }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        {{-- Orders list --}}
        <h2 class="text-lg font-semibold text-slate-900">{{ __('Order History') }}</h2>
        @if($orders->isEmpty())
            <div class="rounded-2xl border border-slate-200 bg-slate-50/50 p-12 text-center">
                <span class="material-icons text-6xl text-slate-300">receipt_long</span>
                <p class="mt-4 font-medium text-slate-700">{{ __('No orders yet.') }}</p>
                <p class="mt-1 text-sm text-slate-500">{{ __('When you place an order, it will appear here.') }}</p>
                <a href="{{ route('categories') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-teal px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark">
                    {{ __('Browse categories') }}
                </a>
            </div>
        @else
            <ul class="space-y-4">
                @foreach($orders as $order)
                    <li class="flex flex-wrap items-center justify-between gap-2 border-b border-slate-100 pb-4 last:border-0">
                        <span class="font-mono text-sm font-medium text-slate-900">{{ $order->order_number }}</span>
                        <span class="text-sm text-slate-500">{{ $order->created_at->format('Y-m-d') }}</span>
                        <span class="rounded-lg px-2.5 py-1 text-xs font-medium
                            @if($order->status === 'pending') bg-amber-100 text-amber-800
                            @elseif($order->status === 'delivered' || $order->status === 'shipped') bg-green-100 text-green-800
                            @else bg-slate-100 text-slate-700 @endif">
                            {{ __($order->status) }}
                        </span>
                        <span class="font-semibold text-slate-900">{{ number_format($order->total, 2) }} {{ __('SAR') }}</span>
                        <a href="{{ route('account', ['order' => $order->order_number]) }}#orders" class="text-sm font-medium text-slate-700 underline hover:no-underline">{{ __('View') }}</a>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif
</div>
