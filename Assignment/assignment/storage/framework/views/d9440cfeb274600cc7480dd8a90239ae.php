

<?php $__env->startSection("title", "Book List By Author - <?php echo e(getAuthorName($author_id) ?? ''); ?>"); ?>

<?php $__env->startSection('content'); ?>
<div class="row mb-3">
    <div class="col-md-6">
        <h2>Book List By Author - <?php echo e(getAuthorName($author_id) ?? ''); ?></h2>
    </div>
</div>

<!-- Success and Error Messages -->
<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<!-- Table for books -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>Sr No.</th>
            <th>Book Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key + 1); ?></td>
                <td><?php echo e($book['name']); ?></td>
                <td>
                    <form action="<?php echo e(route('book.destroy', $book['id'])); ?>" method="POST" class="d-inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp-8.2.12\htdocs\assignment\resources\views/author/view_books.blade.php ENDPATH**/ ?>