<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-topbar="light" data-sidebar-image="none"
    data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> | Koluman - Admin & Yönetim Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Admin & Yönetim Paneli" name="description" />
    <meta content="Koluman" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo e(URL::asset('build/images/favicon.ico')); ?>">
    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<?php echo $__env->yieldContent('body'); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH C:\Users\mobiloby\master\resources\views/layouts/master-without-nav.blade.php ENDPATH**/ ?>