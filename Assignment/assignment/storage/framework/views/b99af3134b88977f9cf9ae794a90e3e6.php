

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
    <h2>Welcome, <?php echo e(Auth::user()->first_name ?? ''); ?></h2>
    <p><strong>First Name:</strong> <?php echo e(Auth::user()->first_name ?? ''); ?></p>
    <p><strong>Last Name:</strong> <?php echo e(Auth::user()->last_name ?? ''); ?></p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp-8.2.12\htdocs\assignment\resources\views/dashboard.blade.php ENDPATH**/ ?>