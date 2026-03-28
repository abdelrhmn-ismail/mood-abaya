

<?php $__env->startSection('title', __('Message from') . ' ' . $contactMessage->name); ?>
<?php $__env->startSection('heading', __('Contact message')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <?php echo $__env->make('components.admin.detail-list', [
        'items' => [
            ['label' => __('Name'), 'value' => $contactMessage->name],
            ['label' => __('Email'), 'value' => $contactMessage->email],
            ['label' => __('Subject'), 'value' => $contactMessage->subject],
            ['label' => __('Date'), 'value' => $contactMessage->created_at->format('Y-m-d H:i')],
        ],
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <div class="mt-4 border-t border-gray-200 pt-4">
        <dt class="text-sm font-medium text-gray-500"><?php echo e(__('Message')); ?></dt>
        <dd class="mt-2 whitespace-pre-wrap text-sm text-gray-900"><?php echo e($contactMessage->message); ?></dd>
    </div>
<?php echo $__env->renderComponent(); ?>

<?php echo $__env->make('components.admin.back-link', [
    'url' => route('admin.contacts.index'),
    'text' => __('Back to messages'),
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Contact\resources\views\admin\contacts\show.blade.php ENDPATH**/ ?>