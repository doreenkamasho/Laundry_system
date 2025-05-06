

<?php $__env->startSection('title'); ?> Order Details #<?php echo e($order->id); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(asset('css/custom-sweetalert.css')); ?>" rel="stylesheet" type="text/css" />
<style>
    .timeline-item {
        position: relative;
        padding-left: 45px;
        margin-bottom: 35px;
    }
    .timeline-item:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: -35px;
        width: 1px;
        background: #e9ecef;
    }
    .timeline-item:last-child:before {
        bottom: 0;
    }
    .timeline-item .timeline-circle {
        position: absolute;
        left: -10px;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #405189;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Breadcrumb and Title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">Order Details #<?php echo e($order->id); ?></h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('laundress.orders.index')); ?>">Orders</a></li>
                        <li class="breadcrumb-item active">Order Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Order Details Card -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h5 class="card-title flex-grow-1 mb-0">Order Information</h5>
                        <div class="flex-shrink-0">
                            <span class="badge bg-<?php echo e($order->status === 'pending' ? 'warning' : 
                                ($order->status === 'completed' ? 'success' : 'info')); ?> fs-12"><?php echo e(ucfirst($order->status)); ?></span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <h5 class="fs-14 mb-3">Order Details</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th>Order ID</th>
                                                <td>#<?php echo e($order->id); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Order Date</th>
                                                <td><?php echo e(optional($order->created_at)->format('M d, Y g:i A') ?? 'N/A'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Service Type</th>
                                                <td><?php echo e(optional($order->service)->name ?? 'N/A'); ?></td>
                                            </tr>
                                            <!-- <tr>
                                                <th>Schedule</th>
                                                <td>
                                                    <?php echo e(optional($order->scheduled_date)->format('M d, Y') ?? 'N/A'); ?><br>
                                                    <small class="text-muted"><?php echo e(optional($order->scheduled_time)->format('g:i A') ?? 'N/A'); ?></small>
                                                </td>
                                            </tr> -->
                                            <tr>
                                                <th>Amount</th>
                                                <td>Tsh <?php echo e(number_format($order->total_amount, 2)); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-4">
                                <h5 class="fs-14 mb-3">Customer Information</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th style="width: 120px;">Full Name</th>
                                                <td><?php echo e($order->customer->name ?? 'N/A'); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Phone Number</th>
                                                <td>
                                                    <?php if($order->customer && $order->customer->phone_number): ?>
                                                        <a href="tel:<?php echo e($order->customer->phone_number); ?>" class="text-body">
                                                            <?php echo e($order->customer->phone_number); ?>

                                                        </a>
                                                    <?php elseif($order->transaction && $order->transaction->phone_number): ?>
                                                        <a href="tel:<?php echo e($order->transaction->phone_number); ?>" class="text-body">
                                                            <?php echo e($order->transaction->phone_number); ?>

                                                        </a>
                                                    <?php else: ?>
                                                        N/A
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="fs-14 mb-3">Items Details</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Item Type</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(is_array($order->selected_items) && count($order->selected_items) > 0): ?>
                                            <?php $__currentLoopData = $order->selected_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($item['itemName'] ?? $item['name'] ?? 'N/A'); ?></td>
                                                <td><?php echo e($item['quantity'] ?? 1); ?></td>
                                                <td>Tsh <?php echo e(number_format($item['price'] ?? 0, 2)); ?></td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <!-- Add total row -->
                                            <tr class="table-light">
                                                <td colspan="2" class="text-end fw-bold">Total Amount:</td>
                                                <td class="fw-bold">Tsh <?php echo e(number_format($order->total_amount ?? 0, 2)); ?></td>
                                            </tr>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">No items found</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Timeline Card -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Status</h5>
                </div>
                <div class="card-body">
                    <div class="timeline-container">
                        <!-- Order Placed -->
                        <div class="timeline-item">
                            <div class="timeline-circle"></div>
                            <h6 class="fs-14 mb-1">Order Placed</h6>
                            <p class="text-muted mb-0"><?php echo e($order->created_at ? $order->created_at->format('M d, Y g:i A') : '-'); ?></p>
                        </div>

                        <!-- Order Confirmed -->
                        <?php if($order->status !== 'pending'): ?>
                        <div class="timeline-item">
                            <div class="timeline-circle"></div>
                            <h6 class="fs-14 mb-1">Order Confirmed</h6>
                            <p class="text-muted mb-0"><?php echo e(optional($order->confirmed_at)->format('M d, Y g:i A') ?? '-'); ?></p>
                        </div>
                        <?php endif; ?>

                        <!-- Washing -->
                        <?php if(in_array($order->status, ['washing', 'drying', 'ironing', 'packaging', 'completed'])): ?>
                        <div class="timeline-item">
                            <div class="timeline-circle"></div>
                            <h6 class="fs-14 mb-1">Washing Started</h6>
                            <p class="text-muted mb-0"><?php echo e(optional($order->washing_started_at)->format('M d, Y g:i A') ?? '-'); ?></p>
                        </div>
                        <?php endif; ?>

                        <!-- Drying -->
                        <?php if(in_array($order->status, ['drying', 'ironing', 'packaging', 'completed'])): ?>
                        <div class="timeline-item">
                            <div class="timeline-circle"></div>
                            <h6 class="fs-14 mb-1">Drying Started</h6>
                            <p class="text-muted mb-0"><?php echo e(optional($order->drying_started_at)->format('M d, Y g:i A') ?? '-'); ?></p>
                        </div>
                        <?php endif; ?>

                        <!-- Ironing -->
                        <?php if(in_array($order->status, ['ironing', 'packaging', 'completed'])): ?>
                        <div class="timeline-item">
                            <div class="timeline-circle"></div>
                            <h6 class="fs-14 mb-1">Ironing Started</h6>
                            <p class="text-muted mb-0"><?php echo e(optional($order->ironing_started_at)->format('M d, Y g:i A') ?? '-'); ?></p>
                        </div>
                        <?php endif; ?>

                        <!-- Packaging -->
                        <?php if(in_array($order->status, ['packaging', 'completed'])): ?>
                        <div class="timeline-item">
                            <div class="timeline-circle"></div>
                            <h6 class="fs-14 mb-1">Packaging Started</h6>
                            <p class="text-muted mb-0"><?php echo e(optional($order->packaging_started_at)->format('M d, Y g:i A') ?? '-'); ?></p>
                        </div>
                        <?php endif; ?>

                        <!-- Completed -->
                        <?php if($order->status === 'completed'): ?>
                        <div class="timeline-item">
                            <div class="timeline-circle"></div>
                            <h6 class="fs-14 mb-1">Order Completed</h6>
                            <p class="text-muted mb-0"><?php echo e(optional($order->completed_at)->format('M d, Y g:i A') ?? '-'); ?></p>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="mt-4">
                        <?php if($order->status === 'pending'): ?>
                            <form id="status-form-<?php echo e($order->id); ?>" 
                                  action="<?php echo e(route('laundress.orders.update-status', $order)); ?>" 
                                  method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="status" value="confirmed">
                                <button type="button" 
                                        class="btn btn-success w-100"
                                        onclick="updateOrderStatus('confirmed')">
                                    <i class="ri-check-line align-middle me-1"></i> Accept Order
                                </button>
                            </form>
                        <?php elseif($order->status === 'confirmed'): ?>
                            <form id="status-form-<?php echo e($order->id); ?>" 
                                  action="<?php echo e(route('laundress.orders.update-status', $order)); ?>" 
                                  method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="status" value="washing">
                                <button type="button" 
                                        class="btn btn-info w-100"
                                        onclick="updateOrderStatus('washing')">
                                    <i class="ri-water-flash-line align-middle me-1"></i> Start Washing
                                </button>
                            </form>
                        <?php elseif($order->status === 'washing'): ?>
                            <form id="status-form-<?php echo e($order->id); ?>" 
                                  action="<?php echo e(route('laundress.orders.update-status', $order)); ?>" 
                                  method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="status" value="drying">
                                <button type="button" 
                                        class="btn btn-info w-100"
                                        onclick="updateOrderStatus('drying')">
                                    <i class="ri-sun-line align-middle me-1"></i> Start Drying
                                </button>
                            </form>
                        <?php elseif($order->status === 'drying'): ?>
                            <form id="status-form-<?php echo e($order->id); ?>" 
                                  action="<?php echo e(route('laundress.orders.update-status', $order)); ?>" 
                                  method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="status" value="ironing">
                                <button type="button" 
                                        class="btn btn-info w-100"
                                        onclick="updateOrderStatus('ironing')">
                                    <i class="ri-t-shirt-line align-middle me-1"></i> Start Ironing
                                </button>
                            </form>
                        <?php elseif($order->status === 'ironing'): ?>
                            <form id="status-form-<?php echo e($order->id); ?>" 
                                  action="<?php echo e(route('laundress.orders.update-status', $order)); ?>" 
                                  method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="status" value="packaging">
                                <button type="button" 
                                        class="btn btn-info w-100"
                                        onclick="updateOrderStatus('packaging')">
                                    <i class="ri-archive-line align-middle me-1"></i> Start Packaging
                                </button>
                            </form>
                        <?php elseif($order->status === 'packaging'): ?>
                            <form id="status-form-<?php echo e($order->id); ?>" 
                                  action="<?php echo e(route('laundress.orders.update-status', $order)); ?>" 
                                  method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="status" value="completed">
                                <button type="button" 
                                        class="btn btn-success w-100"
                                        onclick="updateOrderStatus('completed')">
                                    <i class="ri-check-double-line align-middle me-1"></i> Mark as Completed
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Additional Notes Card -->
            <?php if($order->notes): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Additional Notes</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0"><?php echo e($order->notes); ?></p>
                </div>
            </div>
            <?php endif; ?>

            <!-- Add this temporarily for debugging -->
            <!-- <?php if(config('app.debug')): ?>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5>Debug Information</h5>
                        <pre>
                            Customer Phone: <?php echo e($order->customer->phone_number ?? 'Not set'); ?>

                            Transaction Phone: <?php echo e($order->transaction->phone_number ?? 'Not set'); ?>

                        </pre>
                    </div>
                </div>
            <?php endif; ?> -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function updateOrderStatus(status) {
    const form = document.getElementById('status-form-<?php echo e($order->id); ?>');
    
    if (!form) {
        console.error('Status update form not found');
        return;
    }

    const statusMessages = {
        confirmed: 'Are you sure you want to accept this order?',
        washing: 'Start washing process?',
        drying: 'Move to drying process?',
        ironing: 'Start ironing process?',
        packaging: 'Move to packaging process?',
        completed: 'Mark this order as completed?'
    };

    Swal.fire({
        title: `Update Status`,
        text: statusMessages[status] || 'Update order status?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, update it!',
        cancelButtonText: 'No, not yet',
        customClass: {
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-light ms-1'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            // Update the hidden status input before submitting
            const statusInput = form.querySelector('input[name="status"]');
            if (statusInput) {
                statusInput.value = status;
            }
            form.submit();
        }
    });
}
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\Velzon_v4.2.0\Laravel\saas\resources\views/Laundress/orders/show.blade.php ENDPATH**/ ?>