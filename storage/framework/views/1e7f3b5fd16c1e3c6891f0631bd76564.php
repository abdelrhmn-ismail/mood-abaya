<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'phone',
    'id' => null,
    'value' => '',
    'required' => false,
    'label' => __('Phone'),
    'inputClass' => '',
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
    'name' => 'phone',
    'id' => null,
    'value' => '',
    'required' => false,
    'label' => __('Phone'),
    'inputClass' => '',
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
    $codeKeys = array_keys($codes);
    usort($codeKeys, fn ($a, $b) => strlen($codes[$b]['code']) <=> strlen($codes[$a]['code']));
    $currentCode = '+966';
    $currentKey = 'SA';
    $currentLabel = 'SA';
    $currentNumber = $value;
    if ($value && (str_starts_with((string)$value, '+') || preg_match('/^\d+/', (string)$value))) {
        foreach ($codeKeys as $key) {
            $c = $codes[$key]['code'];
            if (str_starts_with((string)$value, $c)) {
                $currentCode = $c;
                $currentKey = $key;
                $currentLabel = $codes[$key]['label'] ?? $key;
                $currentNumber = trim(substr((string)$value, strlen($c)), ' -');
                break;
            }
        }
        if (!str_starts_with((string)$value, '+') && $currentNumber === $value) {
            $currentNumber = preg_replace('/^0+/', '', (string)$value);
        }
    }
    $currentLabel = $currentLabel ?? ($codes[$currentKey]['label'] ?? $currentKey);
    $codeName = $name . '_country_code';
    $numberName = $name . '_number';
    $codesList = collect($codes)->map(fn ($c, $key) => ['iso' => strtolower($key), 'code' => $c['code'], 'label' => $c['label'] ?? $key])->values()->all();
?>
<div class="space-y-1" x-data="{
    open: false,
    iso: '<?php echo e(strtolower($currentKey)); ?>',
    selectedCode: '<?php echo e($currentCode); ?>',
    selectedLabel: '<?php echo e($currentLabel); ?>',
    codes: <?php echo e(json_encode($codesList)); ?>,
    choose(item) { this.iso = item.iso; this.selectedCode = item.code; this.selectedLabel = item.label; this.open = false; }
}" x-id="['phone-code']" @click.outside="open = false">
    <label for="<?php echo e($id); ?>_number" class="block text-sm font-medium text-slate-700">
        <?php echo e($label); ?>

        <?php if($required): ?><span class="text-red-500">*</span><?php endif; ?>
    </label>
    <div class="flex gap-2">
        <div class="relative min-w-[10rem] shrink-0">
            <input type="hidden" name="<?php echo e($codeName); ?>" id="<?php echo e($id); ?>_code" :value="selectedCode">
            <button type="button"
                    @click="open = !open"
                    :aria-expanded="open"
                    :aria-haspopup="true"
                    :aria-controls="$id('phone-code')"
                    class="flex w-full items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-left text-sm text-slate-900 transition focus:border-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-900/20"
                    aria-label="<?php echo e(__('Country code')); ?>">
                <span class="fi shrink-0 rounded-sm shadow-sm" :class="'fi fi-' + iso" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                <span class="min-w-0 flex-1 truncate" x-text="selectedLabel + ' ' + selectedCode"><?php echo e($currentLabel); ?> <?php echo e($currentCode); ?></span>
                <span class="material-icons text-lg text-slate-400 transition" :class="open && 'rotate-180'">expand_more</span>
            </button>
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-100"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-75"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 :id="$id('phone-code')"
                 role="listbox"
                 class="absolute left-0 right-0 top-full z-50 mt-1 max-h-64 overflow-auto rounded-xl border border-slate-200 bg-white py-1 shadow-lg"
                 x-cloak>
                <template x-for="item in codes" :key="item.code">
                    <button type="button"
                            role="option"
                            :aria-selected="item.code === selectedCode"
                            @click="choose(item)"
                            class="flex w-full items-center gap-2 px-3 py-2.5 text-left text-sm text-slate-900 transition hover:bg-slate-50 focus:bg-slate-50 focus:outline-none"
                            :class="item.code === selectedCode ? 'bg-brand-teal/10 font-medium' : ''">
                        <span class="fi shrink-0 rounded-sm shadow-sm" :class="'fi fi-' + item.iso" style="width: 1.25rem; height: 0.875rem; background-size: cover;"></span>
                        <span class="min-w-0 flex-1 truncate" x-text="item.label + ' ' + item.code"></span>
                    </button>
                </template>
            </div>
        </div>
        <input type="tel"
               name="<?php echo e($numberName); ?>"
               id="<?php echo e($id); ?>_number"
               value="<?php echo e($currentNumber); ?>"
               <?php echo e($required ? 'required' : ''); ?>

               placeholder="5xxxxxxxx"
               class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-slate-900 focus:border-slate-900 focus:ring-2 focus:ring-slate-900/20 <?php echo e($inputClass); ?>"
               <?php echo e($attributes->except(['class', 'inputClass'])->merge([])); ?>>
    </div>
    <?php $__errorArgs = [$codeName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <?php $__errorArgs = [$numberName];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views/components/phone-input.blade.php ENDPATH**/ ?>