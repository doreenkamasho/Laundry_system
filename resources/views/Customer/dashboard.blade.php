@extends('layouts.master')

@section('title') Customer Dashboard @endsection

@section('css')
<link href="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/libs/swiper/swiper.min.css') }}" rel="stylesheet">
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
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Customer @endslot
    @slot('title') Dashboard @endslot
@endcomponent

<div class="container-fluid">
    <!-- Welcome Card -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-pattern mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h4 class="fs-22 fw-semibold ff-secondary mb-2">Welcome back, {{ auth()->user()->name }}! 👋</h4>
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
                            <h2 class="mb-0">{{ $totalOrders }}
                                <span class="text-success ms-1 fs-12">
                                    <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                    <span>+{{ $ordersGrowth }}%</span>
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
                            <h2 class="mb-0">{{ $activeOrders }}</h2>
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
                            <h2 class="mb-0">TZS {{ number_format($totalSpent) }}</h2>
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
                            @if($favoriteLaundress)
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <!-- <img src="{{ $favoriteLaundress->avatar_url ?? asset('assets/images/users/avatar-blank.jpg') }}" 
                                             class="rounded-circle avatar-xs me-2"> -->
                                    </div>
                                    <h6 class="mb-0">{{ $favoriteLaundress->name }}</h6>
                                </div>
                            @else
                                <p class="text-muted mb-0">No orders yet</p>
                            @endif
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
                        <a href="{{ route('customer.orders.index') }}" class="btn btn-soft-info btn-sm">
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
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('customer.orders.show', $order) }}" 
                                           class="fw-medium link-primary">#{{ $order->order_number }}</a>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <!-- <img src="{{ $order->laundress->avatar_url ?? asset('assets/images/users/avatar-blank.jpg') }}" 
                                                 alt="" class="avatar-xs rounded-circle me-2"> -->
                                            {{ $order->laundress->name }}
                                        </div>
                                    </td>
                                    <td>TZS {{ number_format($order->amount) }}</td>
                                    <td>
                                        <div class="position-relative">
                                            <span class="badge bg-opacity-75 text-capitalize px-3 py-2 rounded-pill shadow-sm
                                                  {{ match($order->status) {
                                                      'pending' => 'bg-warning text-dark',
                                                      'processing' => 'bg-info text-white',
                                                      'completed' => 'btn-soft-success text-white',
                                                      'cancelled' => 'bg-danger text-white',
                                                      default => 'bg-secondary text-white'
                                                  } }}">
                                                <i class="{{ match($order->status) {
                                                    'pending' => 'ri-time-line',
                                                    'processing' => 'ri-loader-4-line',
                                                    'completed' => 'ri-check-double-line',
                                                    'cancelled' => 'ri-close-circle-line',
                                                    default => 'ri-question-line'
                                                } }} align-middle me-1"></i>
                                                {{ $order->status }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('customer.orders.show', $order) }}" 
                                           class="btn btn-soft-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <div class="avatar-lg mx-auto mb-4">
                                            <div class="avatar-title bg-soft-primary text-primary display-5 rounded-circle">
                                                <i class="ri-shopping-bag-line"></i>
                                            </div>
                                        </div>
                                        <h5 class="mb-4">No Orders Yet</h5>
                                        <a href="{{ route('customer.find-laundress') }}" class="btn btn-success">
                                            <i class="ri-add-line align-bottom me-1"></i> Create New Order
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
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
                        <a href="{{ route('customer.find-laundress') }}" class="btn btn-soft-success w-100">
                            <i class="ri-add-line align-bottom me-1"></i> New Order
                        </a>
                        <a href="{{ route('customer.orders.index', ['status' => 'pending']) }}" class="btn btn-soft-warning w-100">
                            <i class="ri-time-line align-bottom me-1"></i> Track Pending Orders
                        </a>
                        <a href="{{ route('customer.profile.edit') }}" class="btn btn-soft-info w-100">
                            <i class="ri-user-settings-line align-bottom me-1"></i> Update Profile
                        </a>
                        <a href="{{ route('customer.support') }}" class="btn btn-soft-danger w-100">
                            <i class="ri-customer-service-2-line align-bottom me-1"></i> Get Support
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/jsvectormap/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/swiper/swiper.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
