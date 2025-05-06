

<?php $__env->startSection('title'); ?> My Bookings <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<style>
    .status-badge {
        min-width: 100px;
        text-align: center;
    }
    
    /* Custom badge colors */
    .bg-purple {
        background-color: #6f42c1 !important;
        color: #fff;
    }
    
    .bg-indigo {
        background-color: #4263eb !important;
        color: #fff;
    }
    
    /* If you're using dark theme, adjust hover states */
    .bg-purple:hover {
        background-color: #5e35b1 !important;
    }
    
    .bg-indigo:hover {
        background-color: #364fc7 !important;
    }
</style>
<link href="<?php echo e(asset('css/custom-sweetalert.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">My Bookings</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if($bookings->isEmpty()): ?>
                        <div class="text-center p-4">
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-light rounded-circle text-primary display-5">
                                    <i class="las la-calendar-times"></i>
                                </div>
                            </div>
                            <h4>No Bookings Found</h4>
                            <p class="text-muted">You haven't made any bookings yet.</p>
                            <a href="<?php echo e(route('customer.find-laundress')); ?>" class="btn btn-primary">Find a Laundress</a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Booking ID</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Laundress</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Payment</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>#<?php echo e($booking->id); ?></td>
                                        <td><?php echo e($booking->service->name); ?></td>
                                        <td><?php echo e($booking->laundress->name); ?></td>
                                        <td>
                                            <?php if($booking->scheduled_date): ?>
                                                <?php echo e(\Carbon\Carbon::parse($booking->scheduled_date)->format('M d, Y')); ?><br>
                                                <small class="text-muted">
                                                    <?php echo e(\Carbon\Carbon::parse($booking->scheduled_time)->format('g:i A')); ?>

                                                </small>
                                            <?php else: ?>
                                                <span class="text-muted">Not scheduled</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>Tsh <?php echo e(number_format($booking->total_amount, 2)); ?></td>
                                        <td>
                                            <span class="badge status-badge bg-<?php echo e($booking->status === 'pending' ? 'warning' : 
                                                ($booking->status === 'confirmed' ? 'info' :
                                                ($booking->status === 'washing' ? 'primary' :
                                                ($booking->status === 'drying' ? 'secondary' :
                                                ($booking->status === 'ironing' ? 'purple' :
                                                ($booking->status === 'packaging' ? 'indigo' :
                                                ($booking->status === 'completed' ? 'success' : 'danger'))))))); ?>">
                                                <?php echo e(ucfirst($booking->status)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge status-badge bg-<?php echo e($booking->payment_status === 'paid' ? 'success' : 'warning'); ?>">
                                                <?php echo e(ucfirst($booking->payment_status)); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="<?php echo e(route('customer.bookings.show', $booking)); ?>" 
                                                   class="btn btn-soft-primary btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="View Details">
                                                    <i class="ri-eye-fill"></i>
                                                </a>

                                                <?php if($booking->status === 'pending' && $booking->payment_status !== 'paid'): ?>
                                                    <a href="#" 
                                                       class="btn btn-soft-success btn-sm"
                                                       data-bs-toggle="tooltip"
                                                       title="Pay Now">
                                                        <i class="ri-money-dollar-circle-fill"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <?php if($booking->status === 'pending'): ?>
                                                    <button type="button"
                                                            class="btn btn-soft-danger btn-sm"
                                                            onclick="confirmCancel(<?php echo e($booking->id); ?>)"
                                                            data-bs-toggle="tooltip"
                                                            title="Cancel Booking">
                                                        <i class="ri-close-circle-fill"></i>
                                                    </button>

                                                    <form id="cancel-form-<?php echo e($booking->id); ?>" 
                                                          action="<?php echo e(route('customer.bookings.cancel', $booking)); ?>" 
                                                          method="POST" class="d-none">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            <?php echo e($bookings->links()); ?>

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
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    function confirmCancel(bookingId) {
        Swal.fire({
            title: 'Cancel Booking?',
            text: 'Are you sure you want to cancel this booking? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-light ms-1'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancel-form-' + bookingId).submit();
            }
        });
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\Velzon_v4.2.0\Laravel\saas\resources\views/Customer/bookings/index.blade.php ENDPATH**/ ?>