@extends('frontend.layouts.app')

@section('title', __('My Account') . ' – ' . site_title())
@section('description', __('My Account'))

@section('content')
    <x-frontend.hero-header :title="__('My Account')" :subtitle="__('From your account dashboard you can view your recent orders and edit your details.')" setting="hero_account" />

    <section class="bg-slate-50 py-10 md:py-14">
        <div class="container mx-auto max-w-6xl px-4 lg:px-6">
            <div x-data="{
                tab: 'dashboard',
                initFromHash() {
                    const h = window.location.hash.replace('#','');
                    if (['account-details', 'orders', 'dashboard', 'wishlist', 'cart', 'addresses'].includes(h)) this.tab = h;
                    const orderParam = new URLSearchParams(window.location.search).get('order');
                    if (orderParam) this.tab = 'orders';
                },
                applyHashFromUrl() {
                    const h = window.location.hash.replace('#','');
                    if (['account-details', 'orders', 'dashboard', 'wishlist', 'cart', 'addresses'].includes(h)) this.tab = h;
                }
            }" x-init="
                initFromHash();
                $watch('tab', value => { const h = value || 'dashboard'; if (window.location.hash.replace('#','') !== h) history.replaceState(null, '', '#' + h); });
            " @hashchange.window="applyHashFromUrl()" class="flex flex-col gap-6 rounded-2xl border border-slate-200 bg-white shadow-sm lg:flex-row">
                {{-- Sidebar (left) --}}
                <aside class="w-full shrink-0 border-b border-slate-200 bg-slate-50/80 lg:w-56 lg:border-b-0 lg:border-r lg:rounded-l-2xl">
                    <nav class="flex flex-row gap-1 p-3 lg:flex-col lg:p-4" role="tablist">
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'dashboard'"
                                @click="tab = 'dashboard'"
                                :class="tab === 'dashboard' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">dashboard</span>
                            <span>{{ __('Dashboard') }}</span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'orders'"
                                @click="tab = 'orders'"
                                :class="tab === 'orders' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">receipt_long</span>
                            <span>{{ __('Orders') }}</span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'cart'"
                                @click="tab = 'cart'"
                                :class="tab === 'cart' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">shopping_cart</span>
                            <span>{{ __('Cart') }}</span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'wishlist'"
                                @click="tab = 'wishlist'"
                                :class="tab === 'wishlist' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">favorite</span>
                            <span>{{ __('Wishlist') }}</span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'addresses'"
                                @click="tab = 'addresses'"
                                :class="tab === 'addresses' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">location_on</span>
                            <span>{{ __('Addresses') }}</span>
                        </button>
                        <button type="button"
                                role="tab"
                                :aria-selected="tab === 'account-details'"
                                @click="tab = 'account-details'"
                                :class="tab === 'account-details' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-white/60 hover:text-slate-900'"
                                class="flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-medium transition">
                            <span class="material-icons text-base">manage_accounts</span>
                            <span>{{ __('Account details') }}</span>
                        </button>
                    </nav>
                    <div class="border-t border-slate-200 p-3 lg:p-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-4 py-2.5 text-left text-sm font-medium text-slate-600 transition hover:bg-red-50 hover:text-red-600">
                                <span class="material-icons text-base">logout</span>
                                <span>{{ __('Log Out') }}</span>
                            </button>
                        </form>
                    </div>
                </aside>

                {{-- Main content (right) --}}
                <div class="min-w-0 flex-1 p-6 md:p-8">
                    <div x-show="tab === 'dashboard'" x-cloak role="tabpanel" id="tab-dashboard">
                        @include('user::frontend.account.dashboard-tab')
                    </div>
                    <div x-show="tab === 'orders'" x-cloak role="tabpanel" id="tab-orders">
                        @include('user::frontend.account.orders-tab')
                    </div>
                    <div x-show="tab === 'cart'" x-cloak role="tabpanel" id="tab-cart">
                        @include('user::frontend.account.cart-tab')
                    </div>
                    <div x-show="tab === 'wishlist'" x-cloak role="tabpanel" id="tab-wishlist">
                        @include('user::frontend.account.wishlist-tab')
                    </div>
                    <div x-show="tab === 'addresses'" x-cloak role="tabpanel" id="tab-addresses">
                        @include('user::frontend.account.addresses-tab')
                    </div>
                    <div x-show="tab === 'account-details'" x-cloak role="tabpanel" id="tab-account-details">
                        @include('user::frontend.account.account-details-tab')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
