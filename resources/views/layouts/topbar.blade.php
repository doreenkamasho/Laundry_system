<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="" alt="" height="17">
                        </span>
                    </a>

                    <a href="index" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" 
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" 
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off" id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none" id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">
                            <!-- item-->
                            <div class="dropdown-header">
                                <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                            </div>

                            <div class="dropdown-item bg-transparent text-wrap">
                                <a href="index" class="btn btn-soft-secondary btn-sm rounded-pill">how to setup <i class="mdi mdi-magnify ms-1"></i></a>
                                <a href="index" class="btn btn-soft-secondary btn-sm rounded-pill">buttons <i class="mdi mdi-magnify ms-1"></i></a>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                <span>Help Center</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                <span>My account settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{ URL::asset('build/images/users/avatar-2.jpg') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">Angela Bernier</h6>
                                            <span class="fs-11 mb-0 text-muted">Manager</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{ URL::asset('build/images/users/avatar-3.jpg') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">David Grasso</h6>
                                            <span class="fs-11 mb-0 text-muted">Web Designer</span>
                                        </div>
                                    </div>
                                </a>
                                <!-- item -->
                                <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        <img src="{{ URL::asset('build/images/users/avatar-5.jpg') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-grow-1">
                                            <h6 class="m-0">Mike Bunch</h6>
                                            <span class="fs-11 mb-0 text-muted">React Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results" class="btn btn-primary btn-sm">View All Results <i class="ri-arrow-right-line ms-1"></i></a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>



                <!-- Only show notifications for admin users -->
                @if(Auth::user()->role_id === 1)
                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" 
                        id="page-header-notifications-dropdown" 
                        data-bs-toggle="dropdown" 
                        data-bs-auto-close="outside" 
                        aria-haspopup="true" 
                        aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger">
                                {{ Auth::user()->unreadNotifications->count() }}
                                <span class="visually-hidden">unread notifications</span>
                            </span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0">
                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white">Notifications</h6>
                                    </div>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge bg-light-subtle text-body fs-13">
                                            {{ Auth::user()->unreadNotifications->count() }} New
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="all-noti-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    @forelse(Auth::user()->notifications as $notification)
                                        <div class="text-reset notification-item d-block dropdown-item position-relative {{ $notification->read_at ? 'opacity-50' : '' }}">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                    @if(isset($notification->data['user_avatar']) && $notification->data['user_avatar'])
                                                        <img src="{{ asset('storage/'.$notification->data['user_avatar']) }}" 
                                                             alt="" 
                                                             class="avatar-xs rounded-circle">
                                                    @else
                                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-primary text-white">
                                                                @if(isset($notification->data['user_name']))
                                                                    {{ substr($notification->data['user_name'], 0, 1) }}
                                                                @else
                                                                    <i class="bx bx-user"></i>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mt-0 mb-1 fs-14 fw-semibold">
                                                        {{ isset($notification->data['title']) ? $notification->data['title'] : 'Notification' }}
                                                    </h6>
                                                    <div class="mb-1 text-muted">
                                                        @if(isset($notification->data['user_name']))
                                                            <span class="fw-semibold">{{ $notification->data['user_name'] }}</span>
                                                        @endif
                                                        {{ isset($notification->data['message']) ? $notification->data['message'] : 'New notification' }}
                                                    </div>
                                                    <p class="mb-0 fs-11 fw-medium text-uppercase text-muted">
                                                        <span>
                                                            <i class="mdi mdi-clock-outline"></i> 
                                                            {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                        </span>
                                                    </p>
                                                </div>
                                                @if(!$notification->read_at)
                                                    <div class="px-2 fs-15">
                                                        <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-link p-0">
                                                                <i class="mdi mdi-check-circle text-primary"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center">
                                            <div class="avatar-md mx-auto my-3">
                                                <div class="avatar-title bg-light-subtle text-body fs-36 rounded-circle">
                                                    <i class='bx bx-bell-off'></i>
                                                </div>
                                            </div>
                                            <h5 class="mb-3">No Notifications</h5>
                                        </div>
                                    @endforelse

                                    <!-- Add clear all notifications button if there are notifications -->
                                    @if(Auth::user()->notifications->count() > 0)
                                        <div class="p-2 border-top">
                                            <div class="d-grid">
                                                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-light">
                                                        <i class="mdi mdi-check-all me-1"></i> Mark all as read
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            @if (Auth::user()->avatar)
                                <img class="rounded-circle header-profile-user" 
                                    src="{{ asset('storage/'.Auth::user()->avatar) }}" 
                                    alt="{{ Auth::user()->name }}">
                            @else
                                <div class="rounded-circle header-profile-user d-flex align-items-center justify-content-center bg-primary text-white">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ Auth::user()->role->name }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ Auth::user()->name }}!</h6>
                        
                        <a class="dropdown-item" href="{{ route('customer.profile') }}">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">My Profile</span>
                        </a>

                        <a class="dropdown-item" href="{{ route('customer.settings') }}">
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">Settings</span>
                        </a>

                        <a class="dropdown-item" href="{{ route('help') }}">
                            <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">Help</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="javascript:void();" 
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off font-size-16 align-middle me-1"></i> 
                            <span class="align-middle">Sign Out</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- removeNotificationModal -->
<div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="NotificationModalbtn-close"></button>
            </div>
            <div class="modal-body">
                <div class="mt-2 text-center">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>Are you sure ?</h4>
                        <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                    </div>
                </div>
                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                    <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete It!</button>
                </div>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
