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
                    <a class="nav-link menu-link" href="<?php echo e(route('laundress.dashboard')); ?>">
                        <i class="las la-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- Orders Management -->
                <li class="nav-item">
                    <a class="nav-link menu-link <?php echo e(request()->routeIs('laundress.orders.*') ? 'active' : ''); ?>" 
                       href="#sidebarOrders" 
                       data-bs-toggle="collapse" 
                       role="button"
                       aria-expanded="<?php echo e(request()->routeIs('laundress.orders.*') ? 'true' : 'false'); ?>">
                        <i class="las la-shopping-cart"></i> 
                        <span>Orders</span>
                        <?php if($pendingOrdersCount > 0): ?>
                            <span class="badge bg-danger rounded-pill ms-auto"><?php echo e($pendingOrdersCount); ?></span>
                        <?php endif; ?>
                    </a>
                    <div class="collapse menu-dropdown <?php echo e(request()->routeIs('laundress.orders.*') ? 'show' : ''); ?>" 
                         id="sidebarOrders">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('laundress.orders.index', ['status' => 'pending'])); ?>" 
                                   class="nav-link <?php echo e(request()->input('status') === 'pending' ? 'active' : ''); ?>">
                                    New Orders
                                    <?php if($pendingOrdersCount > 0): ?>
                                        <span class="badge bg-danger rounded-pill ms-1"><?php echo e($pendingOrdersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('laundress.orders.index', ['status' => 'in_progress'])); ?>" 
                                   class="nav-link <?php echo e(request()->input('status') === 'in_progress' ? 'active' : ''); ?>">
                                    Ongoing Orders
                                    <?php if($ongoingOrdersCount > 0): ?>
                                        <span class="badge bg-info rounded-pill ms-1"><?php echo e($ongoingOrdersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('laundress.orders.index', ['status' => 'completed'])); ?>" 
                                   class="nav-link <?php echo e(request()->input('status') === 'completed' ? 'active' : ''); ?>">
                                    Completed Orders
                                    <?php if($completedOrdersCount > 0): ?>
                                        <span class="badge bg-success rounded-pill ms-1"><?php echo e($completedOrdersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Schedule -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="<?php echo e(route('laundress.schedule.index')); ?>">
                        <i class="las la-calendar"></i> <span>My Schedule</span>
                    </a>
                </li>

                <!-- Services & Pricing -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarServices" data-bs-toggle="collapse" role="button">
                        <i class="las la-hand-holding-usd"></i> <span>My Services</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarServices">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('laundress.services.index')); ?>" class="nav-link">Service List</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('laundress.services.create')); ?>" class="nav-link">Add Service</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Earnings -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarEarnings" data-bs-toggle="collapse" role="button">
                        <i class="las la-wallet"></i> <span>Earnings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarEarnings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="" class="nav-link">Overview</a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">Payment History</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Profile & Settings -->
                <li class="nav-item">
                    <a class="nav-link menu-link <?php echo e(request()->routeIs('laundress.profile.*') || request()->routeIs('laundress.settings.*') ? 'active' : ''); ?>" 
                       href="#sidebarSettings" 
                       data-bs-toggle="collapse" 
                       role="button"
                       aria-expanded="<?php echo e(request()->routeIs('laundress.profile.*') || request()->routeIs('laundress.settings.*') ? 'true' : 'false'); ?>">
                        <i class="las la-user-cog"></i> <span>Profile</span>
                    </a>
                    <div class="collapse menu-dropdown <?php echo e(request()->routeIs('laundress.profile.*') || request()->routeIs('laundress.settings.*') ? 'show' : ''); ?>" 
                         id="sidebarSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="<?php echo e(route('laundress.profile.show')); ?>" 
                                   class="nav-link <?php echo e(request()->routeIs('laundress.profile.show') ? 'active' : ''); ?>">
                                    My Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('laundress.profile.business')); ?>" 
                                   class="nav-link <?php echo e(request()->routeIs('laundress.profile.business') ? 'active' : ''); ?>">
                                    Business Info
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo e(route('laundress.settings.edit')); ?>" 
                                   class="nav-link <?php echo e(request()->routeIs('laundress.settings.edit') ? 'active' : ''); ?>">
                                    Settings
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>
<?php /**PATH C:\Users\Lifemate\Desktop\Velzon_v4.2.0\Laravel\saas\resources\views/laundress/sidebar/sidebar.blade.php ENDPATH**/ ?>