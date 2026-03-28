<?php $__env->startSection('title', __('Blog / News')); ?>
<?php $__env->startSection('heading', __('Blog / News')); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.admin.card', ['title' => null]); ?>
    <p class="mb-4 text-sm text-gray-600"><?php echo e(__('Manage blog or news posts for SEO and announcements.')); ?></p>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <span class="text-sm text-gray-500"><?php echo e($posts->total()); ?> <?php echo e(__('items')); ?></span>
        <a href="<?php echo e(route('admin.posts.create')); ?>" class="inline-flex items-center gap-1.5 rounded-lg bg-brand-teal px-4 py-2 text-sm font-medium text-white transition hover:bg-brand-teal-dark">
            <span class="material-icons text-lg">add</span> <?php echo e(__('Add post')); ?>

        </a>
    </div>
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-50/80">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        <a href="<?php echo e(admin_sort_url('title')); ?>" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            <?php echo e(__('Title')); ?>

                            <?php if(request('sort') === 'title'): ?>
                                <span class="material-icons text-base"><?php echo e(request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'); ?></span>
                            <?php else: ?>
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-600">
                        <a href="<?php echo e(admin_sort_url('published_at')); ?>" class="inline-flex items-center gap-1 transition hover:text-brand-teal">
                            <?php echo e(__('Published')); ?>

                            <?php if(request('sort') === 'published_at' || !request('sort')): ?>
                                <span class="material-icons text-base"><?php echo e(request('order', 'desc') === 'asc' ? 'arrow_drop_up' : 'arrow_drop_down'); ?></span>
                            <?php else: ?>
                                <span class="material-icons text-base opacity-50">unfold_more</span>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th scope="col" class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-600"><?php echo e(__('Actions')); ?></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50/70">
                        <td class="px-4 py-3">
                            <span class="font-medium text-gray-900"><?php echo e(Str::limit($post->title, 50)); ?></span>
                            <?php if(!$post->published_at || $post->published_at->isFuture()): ?>
                                <span class="ml-2 inline-flex rounded-full bg-amber-100 px-2 py-0.5 text-xs font-medium text-amber-800"><?php echo e(__('Draft')); ?></span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-600"><?php echo e($post->published_at?->format('Y-m-d H:i') ?? '—'); ?></td>
                        <td class="px-4 py-3 text-right">
                            <a href="<?php echo e(route('blog.show', $post->slug)); ?>" target="_blank" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-gray-600 transition hover:bg-gray-100"><?php echo e(__('View')); ?></a>
                            <a href="<?php echo e(route('admin.posts.edit', $post)); ?>" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-brand-teal transition hover:bg-brand-gold/10"><?php echo e(__('Edit')); ?></a>
                            <form action="<?php echo e(route('admin.posts.destroy', $post)); ?>" method="POST" class="inline-block" onsubmit="return confirm('<?php echo e(__('Are you sure you want to delete this post?')); ?>');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"><?php echo e(__('Delete')); ?></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center text-sm text-gray-500"><?php echo e(__('No posts yet.')); ?></td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if($posts->hasPages()): ?>
        <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
            <form method="GET" action="<?php echo e(request()->url()); ?>" class="flex items-center gap-2">
                <?php $__currentLoopData = request()->query(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($key !== 'per_page'): ?>
                        <?php if(is_array($value)): ?>
                            <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <input type="hidden" name="<?php echo e($key); ?>[]" value="<?php echo e($v); ?>">
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <label for="admin-per-page-posts" class="text-sm text-slate-600"><?php echo e(__('Per page')); ?></label>
                <select name="per_page" id="admin-per-page-posts" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm shadow-sm focus:border-brand-teal focus:ring-brand-teal">
                    <?php $__currentLoopData = admin_per_page_options(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($n); ?>" <?php echo e($posts->perPage() == $n ? 'selected' : ''); ?>><?php echo e($n); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </form>
            <div><?php echo e($posts->withQueryString()->links()); ?></div>
        </div>
    <?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\Modules\Blog\resources\views\admin\index.blade.php ENDPATH**/ ?>