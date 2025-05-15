
<?php $__env->startSection('title'); ?> Customers <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Bookings</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Laundress</th>
                                    <th>Status</th>
                                    <th>Transaction Amount</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($booking->id); ?></td>
                                    <td><?php echo e($booking->customer->name); ?></td>
                                    <td><?php echo e($booking->laundress->name); ?></td>
                                    <td>
                                        <?php
                                            $statusColor = match($booking->status) {
                                                'pending' => 'warning',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                        ?>
                                        <span class="badge rounded-pill fs-12 fw-medium bg-<?php echo e($statusColor); ?> bg-opacity-10 text-<?php echo e($statusColor); ?>">
                                            <i class="mdi mdi-circle-medium me-1"></i>
                                            <?php echo e(ucfirst($booking->status)); ?>

                                        </span>
                                    </td>
                                    <td>Tsh<?php echo e(number_format($booking->transaction->amount ?? 0, 2)); ?></td>
                                    <td><?php echo e($booking->created_at->format('M d, Y')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" 
                                           class="btn btn-sm btn-info">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo e($bookings->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\fyp\Ldms\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>