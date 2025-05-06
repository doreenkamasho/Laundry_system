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
                    <a class="nav-link menu-link" href="{{ route('customer.dashboard') }}">
                        <i class="las la-tachometer-alt"></i> <span>Dashboard</span>
                    </a>
                </li>

                <!-- Find Laundress -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('customer.find-laundress') ? 'active' : '' }}" 
                       href="{{ route('customer.find-laundress') }}">
                        <i class="las la-search-location"></i> <span>Find Laundress</span>
                    </a>
                </li>


                <!-- My Bookings -->
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('customer.bookings.*') ? 'active' : '' }}" 
                       href="#sidebarBookings" data-bs-toggle="collapse" role="button"
                       aria-expanded="{{ request()->routeIs('customer.bookings.*') ? 'true' : 'false' }}">
                        <i class="las la-calendar-check"></i> <span>My Bookings</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('customer.bookings.*') ? 'show' : '' }}" id="sidebarBookings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('customer.bookings.index') }}" 
                                   class="nav-link {{ request()->routeIs('customer.bookings.index') && !request('status') ? 'active' : '' }}">
                                   <span>All Bookings</span>
                                   <span class="badge bg-info rounded-pill ms-auto">{{ $bookingCounts['all'] ?? 0 }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customer.bookings.index', ['status' => 'pending']) }}" 
                                   class="nav-link {{ request('status') === 'pending' ? 'active' : '' }}">
                                   <span>Pending</span>
                                   <span class="badge bg-warning rounded-pill ms-auto">{{ $bookingCounts['pending'] ?? 0 }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customer.bookings.index', ['status' => 'confirmed']) }}" 
                                   class="nav-link {{ request('status') === 'confirmed' ? 'active' : '' }}">
                                   <span>Confirmed</span>
                                   <span class="badge bg-primary rounded-pill ms-auto">{{ $bookingCounts['confirmed'] ?? 0 }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customer.bookings.index', ['status' => 'completed']) }}" 
                                   class="nav-link {{ request('status') === 'completed' ? 'active' : '' }}">
                                   <span>Completed</span>
                                   <span class="badge bg-success rounded-pill ms-auto">{{ $bookingCounts['completed'] ?? 0 }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Profile & Settings -->
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSettings" data-bs-toggle="collapse" role="button">
                        <i class="las la-user-cog"></i> <span>Profile & Settings</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarSettings">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('customer.profile') }}" class="nav-link {{ request()->routeIs('customer.profile') ? 'active' : '' }}">My Profile</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customer.settings') }}" class="nav-link {{ request()->routeIs('customer.settings') ? 'active' : '' }}">Settings</a>
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
