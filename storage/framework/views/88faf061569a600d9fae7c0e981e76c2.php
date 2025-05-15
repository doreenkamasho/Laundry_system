
<?php $__env->startSection('title'); ?> Customers <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Customers List</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Customers</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($customer->id); ?></td>
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        <?php if($customer->avatar): ?>
                                            <img src="<?php echo e(asset('storage/'.$customer->avatar)); ?>" alt="" class="avatar-xs rounded-circle">
                                        <?php else: ?>
                                            <div class="avatar-xs">
                                                <span class="avatar-title rounded-circle bg-primary text-white">
                                                    <?php echo e(substr($customer->name, 0, 1)); ?>

                                                </span>
                                            </div>
                                        <?php endif; ?>
                                        <?php echo e($customer->name); ?>

                                    </div>
                                </td>
                                <td><?php echo e($customer->email); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($customer->is_active ? 'success' : 'danger'); ?>">
                                        <?php echo e($customer->is_active ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </td>
                                <td><?php echo e($customer->created_at->format('d M, Y')); ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-soft-primary">View</a>
                                        <a href="#" class="btn btn-sm btn-soft-warning">Edit</a>
                                        <button type="button" class="btn btn-sm btn-soft-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center">No customers found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <?php echo e($customers->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\fyp\Ldms\resources\views/admin/users/customers/index.blade.php ENDPATH**/ ?>