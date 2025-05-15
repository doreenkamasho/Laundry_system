

<?php $__env->startSection('title'); ?> Customer Dashboard <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.css')); ?>" rel="stylesheet">
<link href="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.css')); ?>" rel="stylesheet">
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #405189 0%, #2f4f8f 100%);
    }
    
    .animate-ripple::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        transform: scale(0);
        animation: ripple 2s infinite;
    }

    @keyframes ripple {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(2);
            opacity: 0;
        }
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Customer <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Dashboard <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-pattern mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-2">Welcome back, <?php echo e(auth()->user()->name); ?>! 👋</h4>
                            <p class="text-muted mb-0">Here's what's happening with your laundry orders today.</p>
                        </div>
                        <div class="avatar-lg">
                            <div class="avatar-title bg-gradient-primary text-white rounded-circle shadow-lg p-3 position-relative overflow-hidden">
                                <i class="ri-map-pin-2-line fs-1 position-relative z-1"></i>
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-opacity-50 bg-white rounded-circle animate-ripple"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-3">Total Orders</h6>
                            <h2 class="mb-0"><?php echo e($totalOrders); ?>

                                <span class="text-success ms-1 fs-12">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                    <span>+<?php echo e($ordersGrowth); ?>%</span>
                                </span>
                            </h2>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-primary rounded fs-3">
                                <i class="ri-shopping-bag-line text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-3">Active Orders</h6>
                            <h2 class="mb-0"><?php echo e($activeOrders); ?></h2>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-warning rounded fs-3">
                                <i class="ri-time-line text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-3">Total Spent</h6>
                            <h2 class="mb-0">TZS <?php echo e(number_format($totalSpent)); ?></h2>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-success rounded fs-3">
                                <i class="ri-wallet-3-line text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-3">Favorite Laundress</h6>
                            <?php if($favoriteLaundress): ?>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <!-- <img src="<?php echo e($favoriteLaundress->avatar_url ?? asset('assets/images/users/avatar-blank.jpg')); ?>" 
                                             class="rounded-circle avatar-xs me-2"> -->
                                    </div>
                                    <h6 class="mb-0"><?php echo e($favoriteLaundress->name); ?></h6>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">No orders yet</p>
                            <?php endif; ?>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-info rounded fs-3">
                                <i class="ri-user-heart-line text-info"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Quick Actions -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                    <div class="flex-shrink-0">
                        <a href="<?php echo e(route('customer.orders.index')); ?>" class="btn btn-soft-info btn-sm">
                            <i class="ri-file-list-3-line align-middle"></i> View All
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">Order</th>
                                    <th scope="col">Laundress</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('customer.orders.show', $order)); ?>" 
                                           class="fw-medium link-primary">#<?php echo e($order->order_number); ?></a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!-- <img src="<?php echo e($order->laundress->avatar_url ?? asset('assets/images/users/avatar-blank.jpg')); ?>" 
                                                 alt="" class="avatar-xs rounded-circle me-2"> -->
                                            <?php echo e($order->laundress->name); ?>

                                        </div>
                                    </td>
                                    <td>TZS <?php echo e(number_format($order->amount)); ?></td>
                                    <td>
                                        <div class="position-relative">
                                            <span class="badge bg-opacity-75 text-capitalize px-3 py-2 rounded-pill shadow-sm
                                                  <?php echo e(match($order->status) {
                                                      'pending' => 'bg-warning text-dark',
                                                      'processing' => 'bg-info text-white',
                                                      'completed' => 'btn-soft-success text-white',
                                                      'cancelled' => 'bg-danger text-white',
                                                      default => 'bg-secondary text-white'
                                                  }); ?>">
                                                <i class="<?php echo e(match($order->status) {
                                                    'pending' => 'ri-time-line',
                                                    'processing' => 'ri-loader-4-line',
                                                    'completed' => 'ri-check-double-line',
                                                    'cancelled' => 'ri-close-circle-line',
                                                    default => 'ri-question-line'
                                                }); ?> align-middle me-1"></i>
                                                <?php echo e($order->status); ?>

                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('customer.orders.show', $order)); ?>" 
                                           class="btn btn-soft-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="avatar-lg mx-auto mb-4">
                                            <div class="avatar-title bg-soft-primary text-primary display-5 rounded-circle">
                                                <i class="ri-shopping-bag-line"></i>
                                            </div>
                                        </div>
                                        <h5 class="mb-4">No Orders Yet</h5>
                                        <a href="<?php echo e(route('customer.find-laundress')); ?>" class="btn btn-success">
                                            <i class="ri-add-line align-bottom me-1"></i> Create New Order
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Quick Actions</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <a href="<?php echo e(route('customer.find-laundress')); ?>" class="btn btn-soft-success w-100">
                            <i class="ri-add-line align-bottom me-1"></i> New Order
                        </a>
                        <a href="<?php echo e(route('customer.orders.index', ['status' => 'pending'])); ?>" class="btn btn-soft-warning w-100">
                            <i class="ri-time-line align-bottom me-1"></i> Track Pending Orders
                        </a>
                        <a href="<?php echo e(route('customer.profile.edit')); ?>" class="btn btn-soft-info w-100">
                            <i class="ri-user-settings-line align-bottom me-1"></i> Update Profile
                        </a>
                        <a href="<?php echo e(route('customer.support')); ?>" class="btn btn-soft-danger w-100">
                            <i class="ri-customer-service-2-line align-bottom me-1"></i> Get Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(URL::asset('assets/libs/apexcharts/apexcharts.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/jsvectormap/jsvectormap.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('assets/libs/swiper/swiper.min.js')); ?>"></script>
<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\fyp\Ldms\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>