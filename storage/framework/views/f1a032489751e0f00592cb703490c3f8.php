

<?php $__env->startSection('title'); ?> 
    <?php echo e(ucfirst($status)); ?> Orders
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(asset('css/custom-sweetalert.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0"><?php echo e(ucfirst($status)); ?> Orders</h4>
                </div>
                <div class="card-body">
                    <?php if($orders->isEmpty()): ?>
                        <div class="text-center py-4">
                            <div class="avatar-md mx-auto mb-4">
                                <div class="avatar-title bg-light rounded-circle text-primary">
                                    <i class="las la-shopping-cart fs-24"></i>
                                </div>
                            </div>
                            <h5 class="mb-2">No <?php echo e(strtolower($status)); ?> orders found</h5>
                            <p class="text-muted">When you receive new orders, they will appear here.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th>Schedule</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>#<?php echo e($order->id); ?></td>
                                        <td><?php echo e($order->customer->name ?? 'N/A'); ?></td>
                                        <td><?php echo e(optional($order->service)->name ?? 'N/A'); ?></td>
                                        <td>
                                            <?php if($order->scheduled_date): ?>
                                                <?php echo e(\Carbon\Carbon::parse($order->scheduled_date)->format('M d, Y')); ?><br>
                                                <small class="text-muted"><?php echo e(\Carbon\Carbon::parse($order->scheduled_time)->format('g:i A')); ?></small>
                                            <?php else: ?>
                                                N/A
                                            <?php endif; ?>
                                        </td>
                                        <td>Tsh <?php echo e(number_format($order->total_amount, 2)); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo e($order->status === 'pending' ? 'warning' : 
                                                ($order->status === 'completed' ? 'success' : 'info')); ?>">
                                                <?php echo e(ucfirst($order->status)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="<?php echo e(route('laundress.orders.show', $order)); ?>" 
                                                   class="btn btn-sm btn-soft-primary">
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-3">
                            <?php echo e($orders->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateStatus(orderId, status) {
        Swal.fire({
            title: 'Accept Order?',
            text: 'Are you sure you want to accept this order?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, accept it!',
            cancelButtonText: 'No, not now',
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-light ms-1'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('status-form-' + orderId).submit();
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\fyp\Ldms\resources\views/Laundress/orders/index.blade.php ENDPATH**/ ?>