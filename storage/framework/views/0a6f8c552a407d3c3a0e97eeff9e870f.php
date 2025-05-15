<script src="<?php echo e(URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/simplebar/simplebar.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/node-waves/waves.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/libs/feather-icons/feather.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/pages/plugins/lord-icon-2.1.0.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/plugins.js')); ?>"></script>
<?php echo $__env->yieldContent('script'); ?>
<?php echo $__env->yieldContent('script-bottom'); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default layout to semibox
    document.documentElement.setAttribute('data-layout', 'semibox');
    
    // Update local storage
    if (sessionStorage.getItem('data-layout') === null) {
        sessionStorage.setItem('data-layout', 'semibox');
    }
});
</script>
<?php /**PATH C:\fyp\Ldms\resources\views/layouts/vendor-scripts.blade.php ENDPATH**/ ?>