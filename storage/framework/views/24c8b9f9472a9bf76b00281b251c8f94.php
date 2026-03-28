<?php
    $enabled = (\App\Models\Setting::get('home_popup_enabled', '0')) === '1';
    $showOnce = (\App\Models\Setting::get('home_popup_show_once_per_session', '1')) === '1';
?>
<?php if($enabled && request()->routeIs('home')): ?>
    <?php if(!$showOnce || !session('home_popup_shown', false)): ?>
    <div id="home-popup-overlay" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/50 p-4" aria-modal="true" role="dialog" aria-labelledby="home-popup-title">
        <div id="home-popup" class="relative max-h-[90vh] w-full max-w-lg overflow-hidden rounded-2xl border border-gray-200 bg-brand-white shadow-xl">
            <button type="button" id="home-popup-close" class="absolute right-3 top-3 z-10 rounded-full p-1.5 text-gray-500 transition hover:bg-gray-100 hover:text-brand-black" aria-label="<?php echo e(__('Close')); ?>">
                <span class="material-icons text-2xl">close</span>
            </button>
            <div class="max-h-[90vh] overflow-y-auto p-6">
                <?php if($img = trim(\App\Models\Setting::get('home_popup_image', ''))): ?>
                    <?php $imgUrl = get_image_url($img) ?? $img; ?>
                    <div class="-mx-6 -mt-6 mb-4">
                        <img src="<?php echo e($imgUrl); ?>" alt="" class="h-48 w-full object-cover" loading="lazy">
                    </div>
                <?php endif; ?>
                <?php if($title = trim(\App\Models\Setting::get('home_popup_title', ''))): ?>
                    <h2 id="home-popup-title" class="text-xl font-semibold text-brand-black"><?php echo e($title); ?></h2>
                <?php endif; ?>
                <?php if($content = trim(\App\Models\Setting::get('home_popup_content', ''))): ?>
                    <div class="mt-3 text-sm text-gray-600 prose prose-sm max-w-none"><?php echo nl2br(e($content)); ?></div>
                <?php endif; ?>
                <?php if($btnText = trim(\App\Models\Setting::get('home_popup_button_text', ''))): ?>
                    <?php $btnUrl = trim(\App\Models\Setting::get('home_popup_button_url', '#')); ?>
                    <div class="mt-6">
                        <a href="<?php echo e($btnUrl); ?>" class="inline-flex rounded-xl bg-brand-teal px-6 py-3 text-sm font-semibold text-white transition hover:bg-brand-teal-dark"><?php echo e($btnText); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script>
    (function() {
        var overlay = document.getElementById('home-popup-overlay');
        var closeBtn = document.getElementById('home-popup-close');
        var delay = Math.max(0, parseInt('<?php echo e(\App\Models\Setting::get("home_popup_delay_seconds", "2")); ?>', 10) || 0) * 1000;
        function show() {
            if (overlay) {
                overlay.classList.remove('hidden');
                overlay.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
        }
        function hide() {
            if (overlay) {
                overlay.classList.add('hidden');
                overlay.classList.remove('flex');
                document.body.style.overflow = '';
            }
            <?php if($showOnce): ?>
            fetch('<?php echo e(route("home.popup.dismiss")); ?>', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' } }).catch(function(){});
            <?php endif; ?>
        }
        setTimeout(show, delay);
        if (closeBtn) closeBtn.addEventListener('click', hide);
        if (overlay) overlay.addEventListener('click', function(e) { if (e.target === overlay) hide(); });
        document.addEventListener('keydown', function(e) { if (e.key === 'Escape') hide(); });
    })();
    </script>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH F:\Work Area\Projects\Mood-Abaya\laravel\resources\views\frontend\partials\home-popup.blade.php ENDPATH**/ ?>