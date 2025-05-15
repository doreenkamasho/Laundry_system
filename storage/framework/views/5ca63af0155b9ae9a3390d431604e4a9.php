<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <i class="fas fa-tshirt fa-2x" style="color: #4169E1;"></i>
            </span>
            <span class="logo-lg">
                <i class="fas fa-tshirt fa-3x" style="color: #4169E1;"></i>
                <span class="ml-2">LaundryHub</span>
            </span>
        </a>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Menu</span></li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="las la-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- User Management -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarUsers" data-bs-toggle="collapse" role="button">
                        <i class="las la-users"></i> <span>Users</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarUsers">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.customers.index')); ?>" class="nav-link">Customers</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.laundress.index')); ?>" class="nav-link">Laundress</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- All Bookings -->
                <li class="nav-item">
                    <a class="nav-link menu-link <?php echo e(request()->routeIs('admin.bookings.*') ? 'active' : ''); ?>" 
                       href="#sidebarBookings" data-bs-toggle="collapse" role="button"
                       aria-expanded="<?php echo e(request()->routeIs('admin.bookings.*') ? 'true' : 'false'); ?>">
                        <i class="las la-calendar-check"></i> <span>All Bookings</span>
                    </a>
                    <div class="collapse menu-dropdown " id="sidebarBookings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.bookings.index')); ?>" 
                                   class="nav-link <?php echo e(request()->routeIs('admin.bookings.index') && !request('status') ? 'active' : ''); ?>">
                                   <span>All Bookings</span>
                                   <span class="badge bg-info rounded-pill ms-auto"><?php echo e($bookingCounts['all'] ?? 0); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.bookings.index', ['status' => 'pending'])); ?>" 
                                   class="nav-link <?php echo e(request('status') === 'pending' ? 'active' : ''); ?>">
                                   <span>Pending</span>
                                   <span class="badge bg-warning rounded-pill ms-auto"><?php echo e($bookingCounts['pending'] ?? 0); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.bookings.index', ['status' => 'confirmed'])); ?>" 
                                   class="nav-link <?php echo e(request('status') === 'confirmed' ? 'active' : ''); ?>">
                                   <span>Confirmed</span>
                                   <span class="badge bg-primary rounded-pill ms-auto"><?php echo e($bookingCounts['confirmed'] ?? 0); ?></span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.bookings.index', ['status' => 'completed'])); ?>" 
                                   class="nav-link <?php echo e(request('status') === 'completed' ? 'active' : ''); ?>">
                                   <span>Completed</span>
                                   <span class="badge bg-success rounded-pill ms-auto"><?php echo e($bookingCounts['completed'] ?? 0); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!-- Reports -->
                <li class="nav-item">
                    <a class="nav-link menu-link <?php echo e(request()->routeIs('admin.reports.*') ? 'active' : ''); ?>" 
                       href="#sidebarReports" data-bs-toggle="collapse" role="button"
                       aria-expanded="<?php echo e(request()->routeIs('admin.reports.*') ? 'true' : 'false'); ?>">
                        <i class="las la-chart-bar"></i> <span>Reports</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarReports">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.reports.sales')); ?>" 
                                   class="nav-link <?php echo e(request()->routeIs('admin.reports.sales') ? 'active' : ''); ?>">
                                    Sales Report
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.reports.user-activity')); ?>" 
                                   class="nav-link <?php echo e(request()->routeIs('admin.reports.user-activity') ? 'active' : ''); ?>">
                                    User Activity
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Settings -->
                <!-- <li class="nav-item">
                    <a class="nav-link menu-link <?php echo e(request()->routeIs('admin.settings.*') ? 'active' : ''); ?>" 
                       href="#sidebarSettings" data-bs-toggle="collapse" role="button"
                       aria-expanded="<?php echo e(request()->routeIs('admin.settings.*') ? 'true' : 'false'); ?>">
                        <i class="las la-cog"></i> <span>Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.settings.general')); ?>" 
                                   class="nav-link <?php echo e(request()->routeIs('admin.settings.general') ? 'active' : ''); ?>">
                                    General Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('admin.settings.system')); ?>" 
                                   class="nav-link <?php echo e(request()->routeIs('admin.settings.system') ? 'active' : ''); ?>">
                                    System Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> -->
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
<?php /**PATH C:\fyp\Ldms\resources\views/admin/sidebar/sidebar.blade.php ENDPATH**/ ?>