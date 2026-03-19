<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'country',
    'id' => null,
    'value' => '',
    'label' => __('Country'),
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'name' => 'country',
    'id' => null,
    'value' => '',
    'label' => __('Country'),
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<?php
    $id = $id ?? $name;
    $codes = config('phone_codes', []);
    $currentValue = $value ?: (old($name, 'Saudi Arabia'));
    $currentKey = 'SA';
    $currentName = 'Saudi Arabia';
    foreach ($codes as $key => $c) {
        $countryName = $c['country_name'] ?? $c['label'];
        if ((string) $countryName === (string) $currentValue) {
            $currentKey = $key;
            $currentName = $countryName;
            break;
        }
    }
    $countriesList = collect($codes)->map(fn ($c, $key) => [
        'iso' => strtolower($key),
        'value' => $c['country_name'] ?? $c['label'],
        'name' => $c['country_name'] ?? $c['label'],
    ])->values()->all();
?>
<div class="space-y-1" x-data="{
    open: false,
    iso: '<?php echo e(strtolower($currentKey)); ?>',
    selectedValue: <?php echo e(json_encode($currentName)); ?>,
    countries: <?php echo e(json_encode($countriesList)); ?>,
    choose(item) { this.iso = item.iso; this.selectedValue = item.value; this.open = false; }
}" x-id="['country-select']" @click.outside="open = false">
    <label for="<?php echo e($id); ?>" class="mb-1 block text-sm font-medium text-slate-700"><?php echo e($label); ?></label>
    <div class="relative">
        <input type="hidden" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" :value="selectedValue">
        <button type="button"
                @click="open = !open"
                :aria-expanded="open"
                aria-haspopup="listbox"
                :aria-controls="$id('country-select')"
                class="flex w-full items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-left text-sm text-slate-900 transition focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20"
                aria-label="<?php echo e($label); ?>">
            <span class="fi shrink-0 rounded-sm shadow-sm" :class="'fi fi-' + iso" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
            <span class="min-w-0 flex-1 truncate" x-text="selectedValue"><?php echo e($currentName); ?></span>
            <span class="material-icons text-lg text-slate-400 transition" :class="open && 'rotate-180'">expand_more</span>
        </button>
        <div x-show="open"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             :id="$id('country-select')"
             role="listbox"
             class="absolute left-0 right-0 top-full z-50 mt-1 max-h-64 overflow-auto rounded-xl border border-slate-200 bg-white py-1 shadow-lg"
             x-cloak>
            <template x-for="item in countries" :key="item.value">
                <button type="button"
                        role="option"
                        :aria-selected="item.value === selectedValue"
                        @click="choose(item)"
                        class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-sm text-slate-900 transition hover:bg-slate-50 focus:bg-slate-50 focus:outline-none"
                        :class="item.value === selectedValue ? 'bg-brand-teal/10 font-medium' : ''">
                    <span class="fi shrink-0 rounded-sm shadow-sm" :class="'fi fi-' + item.iso" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                    <span class="min-w-0 flex-1 truncate" x-text="item.name"></span>
                </button>
            </template>
        </div>
    </div>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/components/country-select.blade.php ENDPATH**/ ?>