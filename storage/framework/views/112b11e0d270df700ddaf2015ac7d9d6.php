<?php $__env->startSection('title'); ?> Laundress Dashboard <?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<!-- ApexCharts CSS from CDN -->
<link href="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.css" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startComponent('components.breadcrumb'); ?>
    <?php $__env->slot('li_1'); ?> Laundress <?php $__env->endSlot(); ?>
    <?php $__env->slot('title'); ?> Dashboard <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>

<div class="container-fluid">
    <!-- Stats Row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                        <!-- Total Orders -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total Orders</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><?php echo e($stats['totalOrders']); ?></h2>
                                    </div>
                                    <div class="flex-shrink-0 text-end dash-widget">
                                        <div id="total_orders_chart" data-colors='["--vz-primary"]' class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Earnings -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total Earnings</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">Tsh <?php echo e(number_format($stats['totalEarnings'], 2)); ?></h2>
                                    </div>
                                    <div class="flex-shrink-0 text-end dash-widget">
                                        <div id="total_earnings_chart" data-colors='["--vz-success"]' class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Orders -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Pending Orders</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><?php echo e($stats['pendingOrders']); ?></h2>
                                    </div>
                                    <div class="flex-shrink-0 text-end dash-widget">
                                        <div id="pending_orders_chart" data-colors='["--vz-warning"]' class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Completed Orders -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Completed Orders</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0"><?php echo e($stats['completedOrders']); ?></h2>
                                    </div>
                                    <div class="flex-shrink-0 text-end dash-widget">
                                        <div id="completed_orders_chart" data-colors='["--vz-success"]' class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- This Month's Earnings -->
                        <div class="col">
                            <div class="mt-3 mt-md-0 py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">This Month</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">Tsh <?php echo e(number_format($stats['monthlyEarnings'], 2)); ?></h2>
                                    </div>
                                    <div class="flex-shrink-0 text-end dash-widget">
                                        <div id="monthly_earnings_chart" data-colors='["--vz-info"]' class="apex-charts"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Earnings Overview Chart -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Earnings Overview</h4>
                </div>
                <div class="card-body">
                    <div id="earnings_overview_chart" data-colors='["--vz-primary", "--vz-success"]' class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>

        <!-- Orders by Status Chart -->
        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Orders by Status</h4>
                </div>
                <div class="card-body">
                    <div id="orders_by_status_chart" data-colors='["--vz-primary", "--vz-success", "--vz-warning"]' class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                    <div class="flex-shrink-0">
                        <a href="<?php echo e(route('laundress.orders.index')); ?>" class="btn btn-soft-info btn-sm">
                            <i class="ri-file-list-3-line align-middle"></i> View All Orders
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo e(route('laundress.orders.show', $order)); ?>" class="fw-medium link-primary">#<?php echo e($order->id); ?></a>
                                    </td>
                                    <td><?php echo e($order->customer->name); ?></td>
                                    <td><?php echo e($order->service->name); ?></td>
                                    <td><?php echo e($order->created_at->format('M d, Y')); ?></td>
                                    <td>Tsh <?php echo e(number_format($order->total_amount, 2)); ?></td>
                                    <td>
                                        <span class="badge bg-<?php echo e($order->status === 'pending' ? 'warning' : 
                                            ($order->status === 'completed' ? 'success' : 'info')); ?> text-uppercase"><?php echo e($order->status); ?></span>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('laundress.orders.show', $order)); ?>" class="btn btn-sm btn-soft-primary">
                                            <i class="ri-eye-line align-middle"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center">No recent orders found</td>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<!-- ApexCharts JS from CDN -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>

<!-- Dashboard Init JS -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Small Charts Options
    const smallChartOptions = {
        chart: { type: 'line', height: 35, sparkline: { enabled: true } },
        stroke: { curve: 'smooth', width: 2 },
        tooltip: { fixed: { enabled: false }, x: { show: false }, marker: { show: false } }
    };

    // Initialize small charts
    new ApexCharts(document.querySelector("#total_orders_chart"), {
        ...smallChartOptions,
        series: [{ data: <?php echo json_encode($charts['ordersTrend'], 15, 512) ?> }],
        colors: ['#405189']
    }).render();

    new ApexCharts(document.querySelector("#total_earnings_chart"), {
        ...smallChartOptions,
        series: [{ data: <?php echo json_encode($charts['earningsTrend'], 15, 512) ?> }],
        colors: ['#0ab39c']
    }).render();

    // Earnings Overview Chart
    new ApexCharts(document.querySelector("#earnings_overview_chart"), {
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false }
        },
        series: [{
            name: 'Earnings',
            data: <?php echo json_encode($charts['monthlyEarnings'] ?? [], 15, 512) ?>
        }],
        xaxis: {
            categories: <?php echo json_encode($charts['months'] ?? [], 15, 512) ?>,
            axisBorder: { show: false },
            axisTicks: { show: false }
        },
        stroke: { curve: 'smooth', width: 2 },
        fill: { type: 'gradient' },
        colors: ['#405189']
    }).render();

    // Orders by Status Chart
    new ApexCharts(document.querySelector("#orders_by_status_chart"), {
        chart: { height: 300, type: 'donut' },
        series: <?php echo json_encode($charts['ordersByStatus'] ?? [], 15, 512) ?>,
        labels: ['Pending', 'Processing', 'Completed'],
        colors: ['#f7b84b', '#299cdb', '#0ab39c'],
        legend: { position: 'bottom' }
    }).render();
});
</script>

<script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Lifemate\Desktop\Velzon_v4.2.0\Laravel\saas\resources\views/Laundress/dashboard.blade.php ENDPATH**/ ?>