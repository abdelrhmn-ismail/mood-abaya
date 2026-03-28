<?php
    $name = $name ?? '';
    $id = $id ?? str_replace(['[', ']'], '_', $name);
    $oldKey = preg_replace('/\[(\w+)\]/', '.$1', $name);
    $label = $label ?? '';
    $type = $type ?? 'text';
    $value = $value ?? '';
    $required = $required ?? false;
    $options = $options ?? []; // for select: [['value' => 'x', 'label' => 'y'], ...]
    $attributes = $attributes ?? []; // placeholder, step, min, max, rows, accept, etc.
    $errorKey = $errorKey ?? $name;
    $inputClass = 'mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-teal focus:ring-brand-teal text-sm ';
?>
<div>
    <?php if($label): ?>
        <label for="<?php echo e($id); ?>" class="block text-sm font-medium text-gray-700">
            <?php echo e($label); ?> <?php if($required): ?><span class="text-red-500">*</span><?php endif; ?>
        </label>
    <?php endif; ?>
    <?php if($type === 'select'): ?>
        <select name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" class="<?php echo e($inputClass); ?>"
                <?php if($required): ?> required <?php endif; ?>
                <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($k); ?>="<?php echo e($v); ?>" <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        >
            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($opt['value'] ?? $opt[0]); ?>" <?php echo e((string)($value ?? '') === (string)($opt['value'] ?? $opt[0]) ? 'selected' : ''); ?>>
                    <?php echo e($opt['label'] ?? $opt[1] ?? $opt['value'] ?? $opt[0]); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    <?php elseif($type === 'textarea'): ?>
        <textarea name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" rows="<?php echo e($attributes['rows'] ?? 3); ?>" class="<?php echo e($inputClass); ?>"
                  <?php if($required): ?> required <?php endif; ?>
                  <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($k !== 'rows'): ?> <?php echo e($k); ?>="<?php echo e($v); ?>" <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ><?php echo e(old($oldKey, $value)); ?></textarea>
    <?php elseif($type === 'checkbox'): ?>
        <label class="mt-2 inline-flex items-center">
            <input type="checkbox" name="<?php echo e($name); ?>" value="1" <?php echo e(old($oldKey, $value) ? 'checked' : ''); ?> class="rounded border-gray-300 text-brand-teal focus:ring-brand-teal">
            <span class="ml-2 text-sm text-gray-700"><?php echo e($attributes['help'] ?? ''); ?></span>
        </label>
    <?php elseif($type === 'file'): ?>
        <?php if(!empty($attributes['current'])): ?>
            <p class="mb-1 text-sm text-gray-500"><?php echo e(__('Current')); ?>: <a href="<?php echo e($attributes['current_url'] ?? '#'); ?>" target="_blank" class="text-brand-teal"><?php echo e($attributes['current']); ?></a></p>
        <?php endif; ?>
        <input type="file" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" accept="<?php echo e($attributes['accept'] ?? 'image/*'); ?>" class="<?php echo e($inputClass); ?> text-sm">
    <?php else: ?>
        <input type="<?php echo e($type); ?>" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" value="<?php echo e(old($oldKey, $value)); ?>"
               class="<?php echo e($inputClass); ?>"
               <?php if($required): ?> required <?php endif; ?>
               <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($k); ?>="<?php echo e($v); ?>" <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        >
    <?php endif; ?>
    <?php $__errorArgs = [$errorKey];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\admin\form-field.blade.php ENDPATH**/ ?>