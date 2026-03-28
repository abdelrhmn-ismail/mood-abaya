<?php
    $name = $name ?? '';
    $id = $id ?? str_replace(['[', ']'], '_', $name);
    $oldKey = preg_replace('/\[(\w+)\]/', '.$1', $name);
    $label = $label ?? '';
    $value = $value ?? '';
    $required = $required ?? false;
    $attributes = $attributes ?? [];
    $errorKey = $errorKey ?? $name;
    $inputClass = 'mt-1 block w-full rounded-lg border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm min-h-[200px] ';
?>
<div class="rich-editor-wrap" data-rich-editor>
    <?php if($label): ?>
        <label for="<?php echo e($id); ?>" class="block text-sm font-medium text-gray-700">
            <?php echo e($label); ?> <?php if($required): ?><span class="text-red-500">*</span><?php endif; ?>
        </label>
    <?php endif; ?>
    <textarea name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" class="<?php echo e($inputClass); ?> rich-editor"
              <?php if($required): ?> required <?php endif; ?>
              <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if(!in_array($k, ['rows'])): ?> <?php echo e($k); ?>="<?php echo e($v); ?>" <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ><?php echo old($oldKey, $value); ?></textarea>
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
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\components\admin\rich-editor.blade.php ENDPATH**/ ?>