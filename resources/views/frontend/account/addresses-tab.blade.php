{{-- Billing addresses tab: list, add, edit, remove --}}
<div class="space-y-6">
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
    @endif

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-xl font-bold text-slate-900">{{ __('Billing addresses') }}</h2>
    </div>

    {{-- Add new address form (collapsible accordion) --}}
    <div class="rounded-2xl border border-slate-200 bg-slate-50/50" x-data="{ addFormOpen: {{ count(old()) ? 'true' : 'false' }} }">
        <button type="button" @click="addFormOpen = !addFormOpen" class="flex w-full items-center justify-between px-6 py-4 text-left transition hover:bg-slate-100/80">
            <h3 class="text-lg font-semibold text-slate-900">{{ __('Add new address') }}</h3>
            <span class="material-icons text-slate-500 transition" :class="addFormOpen ? 'rotate-180' : ''">expand_more</span>
        </button>
        <div x-show="addFormOpen" x-cloak class="border-t border-slate-200">
            <form action="{{ route('billing-addresses.store') }}" method="POST" class="grid gap-4 p-6 sm:grid-cols-2">
                @csrf
                <div class="sm:col-span-2">
                    <label for="addr_label" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Label') }} ({{ __('optional') }})</label>
                    <input type="text" name="label" id="addr_label" value="{{ old('label') }}" placeholder="{{ __('e.g. Home, Office') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                </div>
                <div class="sm:col-span-2">
                    <label for="addr_full_name" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Full name') }} *</label>
                    <input type="text" name="full_name" id="addr_full_name" value="{{ old('full_name', auth()->user()?->name) }}" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                    @error('full_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <x-phone-input name="phone" id="addr_phone" :value="old('phone', auth()->user()?->phone)" :required="true" :label="__('Phone')" />
                </div>
            <div class="sm:col-span-2">
                <label for="addr_line1" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Address line 1') }} *</label>
                <input type="text" name="address_line_1" id="addr_line1" value="{{ old('address_line_1') }}" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                @error('address_line_1')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="sm:col-span-2">
                <label for="addr_line2" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Address line 2') }} ({{ __('optional') }})</label>
                <input type="text" name="address_line_2" id="addr_line2" value="{{ old('address_line_2') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            </div>
            <div>
                <label for="addr_city" class="mb-1 block text-sm font-medium text-slate-700">{{ __('City') }} *</label>
                <input type="text" name="city" id="addr_city" value="{{ old('city') }}" required class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                @error('city')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="addr_state" class="mb-1 block text-sm font-medium text-slate-700">{{ __('State / Region') }} ({{ __('optional') }})</label>
                <input type="text" name="state" id="addr_state" value="{{ old('state') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            </div>
            <div>
                <label for="addr_postal" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Postal code') }} ({{ __('optional') }})</label>
                <input type="text" name="postal_code" id="addr_postal" value="{{ old('postal_code') }}" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
            </div>
            <div>
                <label for="addr_country" class="mb-1 block text-sm font-medium text-slate-700">{{ __('Country') }}</label>
                <select name="country" id="addr_country" class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                    @foreach(config('phone_codes', []) as $c)
                        <option value="{{ $c['country_name'] ?? $c['label'] }}" {{ old('country', 'Saudi Arabia') === ($c['country_name'] ?? $c['label']) ? 'selected' : '' }}>{{ $c['flag'] }} {{ $c['country_name'] ?? $c['label'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center sm:col-span-2">
                <input type="checkbox" name="is_default" id="addr_default" value="1" {{ old('is_default') ? 'checked' : (empty($billingAddresses) ? 'checked' : '') }} class="rounded border-slate-300 text-slate-900 focus:ring-slate-900/20">
                <label for="addr_default" class="ml-2 text-sm text-slate-700">{{ __('Set as default') }}</label>
            </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="rounded-xl bg-brand-teal px-6 py-2.5 font-semibold text-white transition hover:bg-brand-teal-dark">{{ __('Add address') }}</button>
                </div>
            </form>
        </div>
    </div>

    {{-- List of saved addresses --}}
    @if(isset($billingAddresses) && $billingAddresses->isNotEmpty())
        <ul class="grid grid-cols-1 gap-0 divide-y divide-slate-200">
            @foreach($billingAddresses as $addr)
                <li class="py-4" x-data="{ editing: false }">
                    <div x-show="!editing" class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            @if($addr->label)
                                <span class="font-semibold text-slate-900">{{ $addr->label }}</span>
                                @if($addr->is_default)
                                    <span class="ml-2 rounded bg-slate-200 px-2 py-0.5 text-xs font-medium text-slate-700">{{ __('Default') }}</span>
                                @endif
                                <br>
                            @elseif($addr->is_default)
                                <span class="rounded bg-slate-200 px-2 py-0.5 text-xs font-medium text-slate-700">{{ __('Default') }}</span>
                                <br>
                            @endif
                            <p class="mt-1 text-sm text-slate-600">{{ $addr->full_name }} · {{ $addr->phone }}</p>
                            <p class="text-sm text-slate-600">{{ $addr->summary }}</p>
                        </div>
                        <div class="mt-2 flex gap-2 shrink-0 sm:mt-0">
                            <button type="button" @click="editing = true" class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50">{{ __('Edit') }}</button>
                            <form action="{{ route('billing-addresses.destroy', $addr) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Remove this address?') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg border border-red-100 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-700 transition hover:bg-red-100">{{ __('Remove') }}</button>
                            </form>
                        </div>
                    </div>
                    <div x-show="editing" x-cloak class="rounded-xl border border-slate-200 bg-white p-4">
                        <form action="{{ route('billing-addresses.update', $addr) }}" method="POST" class="grid gap-3 sm:grid-cols-2">
                            @csrf
                            @method('PUT')
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('Label') }}</label>
                                <input type="text" name="label" value="{{ old('label', $addr->label) }}" placeholder="{{ __('e.g. Home') }}" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('Full name') }} *</label>
                                <input type="text" name="full_name" value="{{ old('full_name', $addr->full_name) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <x-phone-input name="phone" :id="'addr_phone_edit_'.$addr->id" :value="old('phone', $addr->phone)" :required="true" :label="__('Phone')" inputClass="rounded-lg border border-slate-300 px-3 py-2 text-sm" />
                            </div>
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('Address line 1') }} *</label>
                                <input type="text" name="address_line_1" value="{{ old('address_line_1', $addr->address_line_1) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('Address line 2') }}</label>
                                <input type="text" name="address_line_2" value="{{ old('address_line_2', $addr->address_line_2) }}" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('City') }} *</label>
                                <input type="text" name="city" value="{{ old('city', $addr->city) }}" required class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('State / Region') }}</label>
                                <input type="text" name="state" value="{{ old('state', $addr->state) }}" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('Postal code') }}</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code', $addr->postal_code) }}" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="mb-1 block text-sm font-medium text-slate-700">{{ __('Country') }}</label>
                                <select name="country" class="block w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20">
                                    @foreach(config('phone_codes', []) as $c)
                                        <option value="{{ $c['country_name'] ?? $c['label'] }}" {{ old('country', $addr->country) === ($c['country_name'] ?? $c['label']) ? 'selected' : '' }}>{{ $c['flag'] }} {{ $c['country_name'] ?? $c['label'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-center sm:col-span-2">
                                <input type="checkbox" name="is_default" value="1" {{ $addr->is_default ? 'checked' : '' }} class="rounded border-slate-300 text-slate-900">
                                <label class="ml-2 text-sm text-slate-700">{{ __('Set as default') }}</label>
                            </div>
                            <div class="flex gap-2 sm:col-span-2">
                                <button type="submit" class="rounded-lg bg-brand-teal px-4 py-2 text-sm font-semibold text-white hover:bg-brand-teal-dark">{{ __('Save') }}</button>
                                <button type="button" @click="editing = false" class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">{{ __('Cancel') }}</button>
                            </div>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="rounded-xl border border-slate-200 bg-slate-50/50 p-6 text-center text-slate-600">{{ __('No saved addresses yet. Add one above or at checkout.') }}</p>
    @endif
</div>
