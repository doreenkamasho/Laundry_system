@extends('layouts.master')
@section('title') Admin Dashboard @endsection

@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Admin @endslot
    @slot('title') Dashboard @endslot
@endcomponent

<div class="container-fluid">
    <!-- Stats Overview -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card crm-widget">
                <div class="card-body p-0">
                    <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                        <!-- Total Customers -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total Customers</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-user-2-line display-6 text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">{{ $totalCustomers ?? 0 }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Laundress -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total Laundress</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-team-line display-6 text-success"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">{{ $totalLaundress ?? 0 }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Active Orders -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Active Orders</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-shopping-basket-line display-6 text-warning"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">{{ $activeOrders ?? 0 }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Revenue -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">Total Revenue</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-money-dollar-circle-line display-6 text-info"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">Tsh {{ number_format($totalRevenue ?? 0) }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- This Month -->
                        <div class="col">
                            <div class="py-4 px-3">
                                <h5 class="text-muted text-uppercase fs-13">This Month</h5>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <i class="ri-calendar-line display-6 text-danger"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h2 class="mb-0">Tsh {{ number_format($monthlyRevenue ?? 0) }}</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Analytics -->
    <div class="row">
        <!-- Revenue Chart -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header border-0 align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Revenue Analytics</h4>
                    <div>
                        <button type="button" class="btn btn-soft-secondary btn-sm">
                            ALL
                        </button>
                        <button type="button" class="btn btn-soft-secondary btn-sm">
                            1M
                        </button>
                        <button type="button" class="btn btn-soft-secondary btn-sm">
                            6M
                        </button>
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            1Y
                        </button>
                    </div>
                </div>
                <div class="card-body p-0 pb-2">
                    <div class="w-100">
                        <div id="revenue-chart" 
                             data-revenue='@json($revenueData)' 
                             class="apex-charts" 
                             style="height: 350px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="col-xl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Recent Activities</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-soft-primary btn-sm">
                            View All
                        </button>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div data-simplebar style="max-height: 390px;" class="p-3">
                        <!-- Activity items will be dynamically loaded here -->
                        <div class="acitivity-timeline acitivity-main">
                            @forelse($recentActivities ?? [] as $activity)
                            <div class="acitivity-item d-flex">
                                <div class="flex-shrink-0">
                                    <i class="ri-taxi-line icon-dual"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ is_object($activity) ? $activity->title : $activity['title'] }}</h6>
                                    <p class="text-muted mb-2">{{ is_object($activity) ? $activity->description : $activity['description'] }}</p>
                                    <small class="mb-0 text-muted">
                                        {{ is_object($activity) && $activity->created_at ? $activity->created_at->diffForHumans() : \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}
                                    </small>
                                </div>
                            </div>
                            @empty
                            <div class="text-center">
                                <p class="text-muted mb-0">No recent activities</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders & Top Laundress -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                    <div class="flex-shrink-0">
                        <button type="button" class="btn btn-soft-info btn-sm">
                            <i class="ri-file-list-3-line align-middle"></i> Generate Report
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">Order ID</th>
                                    <th scope="col">Customer</th>
                                    <th scope="col">Laundress</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->laundress->name }}</td>
                                    <td>Tsh {{ number_format($order->amount) }}</td>
                                    <td><span class="badge badge-soft-{{ $order->status_color }}">{{ $order->status }}</span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-soft-primary">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No recent orders</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Laundress -->
        <div class="col-xl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Top Laundress</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted fs-16"><i class="mdi mdi-dots-vertical align-middle"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">This Week</a>
                                <a class="dropdown-item" href="#">Last Week</a>
                                <a class="dropdown-item" href="#">Last Month</a>
                                <a class="dropdown-item" href="#">Current Year</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @forelse($topLaundress ?? [] as $laundress)
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-shrink-0">
                            @if($laundress->avatar)
                                <img src="{{ asset('storage/'.$laundress->avatar) }}" alt="" class="avatar-sm rounded-circle">
                            @else
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-primary text-white">
                                        {{ substr($laundress->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-1">{{ $laundress->name }}</h6>
                            <p class="text-muted mb-0">{{ $laundress->total_orders }} Orders</p>
                        </div>
                        <div>
                            <h6 class="mb-0">Tsh {{ number_format($laundress->total_revenue) }}</h6>
                        </div>
                    </div>
                    @empty
                    <div class="text-center">
                        <p class="text-muted mb-0">No data available</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/dashboard-analytics.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
