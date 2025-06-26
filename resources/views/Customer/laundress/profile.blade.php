@extends('layouts.master')
@section('title') Laundress Profile @endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Customer @endslot
    @slot('title') Laundress Profile @endslot
@endcomponent

        <div class="text-end">
            <button type="button" class="btn btn-primary btn-lg" onclick="window.location.href='{{ route('customer.bookings.create', ['laundress' => $laundress->id]) }}'">
                <i class="ri-calendar-check-line align-middle me-1"></i>
                Book Now
            </button>
        </div>
<div class="row">
    <div class="col-lg-4">
        <div class="text-center mb-4">
            @if($laundress->avatar)
                <img src="{{ asset('storage/'.$laundress->avatar) }}" 
                     class="avatar-xl rounded-circle img-thumbnail"
                     alt="{{ $laundress->name }}">
            @else
                <div class="avatar-xl rounded-circle bg-primary text-white mx-auto">
                    <span class="avatar-title fs-1">{{ substr($laundress->name, 0, 1) }}</span>
                </div>
            @endif
            <h5 class="mt-3 mb-1">{{ $laundress->name }}</h5>
            <p class="text-muted mb-3">
                <i class="ri-map-pin-line align-middle"></i> 
                {{ $laundress->laundressDetail->address }}
            </p>
            <div class="d-flex gap-2 justify-content-center mb-3">
                <span class="badge rounded-pill bg-primary px-3 py-2">
                    <i class="ri-time-line align-bottom me-1"></i> Fast Service
                </span>
                <span class="badge rounded-pill bg-success px-3 py-2">
                    <i class="ri-shield-check-line align-bottom me-1"></i> Verified
                </span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Schedule & Availability</h5>
            </div>
            <div class="card-body">
                <div class="schedule-info">
                    <h6 class="mb-3">Available Days</h6>
                    @foreach($availableDays as $day)
                        <div class="d-flex align-items-center mb-2">
                            <i class="ri-calendar-check-line text-primary me-2"></i>
                            <span class="text-capitalize">{{ $day }}</span>
                            @php $hours = $laundress->schedule->getWorkingHours($day) @endphp
                            @if($hours)
                                <span class="ms-auto text-muted small">
                                    {{ \Carbon\Carbon::parse($hours['start'])->format('g:i A') }} - 
                                    {{ \Carbon\Carbon::parse($hours['end'])->format('g:i A') }}
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Services & Pricing</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($laundress->services as $service)
                        <div class="col-md-6">
                            <div class="service-card p-3 border rounded">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="ri-washing-machine-line text-primary me-2"></i>
                                    <h6 class="mb-0">{{ $service->name }}</h6>
                                </div>
                                <div class="price-list">
                                    @if(is_array($service->price_structure))
                                        @foreach($service->price_structure as $item)
                                            <div class="d-flex align-items-center justify-content-between mb-2">
                                                <span class="text-muted">{{ $item['item'] }}</span>
                                                <span class="fw-medium">Tsh{{ number_format($item['price'], 2) }}</span>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="text-muted">No pricing information available</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info mb-0">
                                <i class="ri-information-line me-2"></i>
                                No services available at the moment.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Special Offers</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="offer-card bg-light p-3 rounded">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-primary me-2">10% OFF</span>
                                <h6 class="mb-0">Self Service Discount</h6>
                            </div>
                            <p class="text-muted small mb-0">
                                Save 10% when you drop-off and pick-up your laundry yourself!
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Delivery Options</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="delivery-option p-3 border rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ri-bike-line text-primary me-2"></i>
                                <h6 class="mb-0">Pick-up Service</h6>
                                <span class="badge bg-soft-info text-info ms-auto">Tsh3500.00</span>
                            </div>
                            <p class="text-muted small mb-0">We'll pick up your laundry from your location</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="delivery-option p-3 border rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ri-truck-line text-primary me-2"></i>
                                <h6 class="mb-0">Delivery Service</h6>
                                <span class="badge bg-soft-info text-info ms-auto">Tsh3500.00</span>
                            </div>
                            <p class="text-muted small mb-0">We'll deliver your clean laundry to your doorstep</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="floating-button">
            <button type="button" 
                    class="btn btn-primary btn-lg rounded-circle shadow-lg" 
                    onclick="window.location.href='{{ route('customer.bookings.create', ['laundress' => $laundress->id]) }}'"
                    data-bs-toggle="tooltip" 
                    data-bs-placement="left" 
                    title="Press to Order">
                <i class="ri-calendar-check-line"></i>
            </button>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .tooltip {
    font-size: 0.875rem;
}

.tooltip .tooltip-inner {
    background-color: #2a3042;
    padding: 0.5rem 1rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.tooltip.bs-tooltip-left .tooltip-arrow::before {
    border-left-color: #2a3042;
}
    .service-card {
        background-color: #fff;
        transition: all 0.3s ease;
    }

    .service-card:hover {
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }

    .service-card .price-list {
        border-top: 1px solid rgba(0,0,0,0.1);
        padding-top: 1rem;
        margin-top: 0.5rem;
    }

    .service-card i {
        font-size: 1.25rem;
    }

    .price-list .fw-medium {
        color: #556ee6;
    }

    .offer-card {
        background-color: #f8f9fa;
        border-left: 4px solid #556ee6;
    }

    .delivery-option {
        transition: all 0.3s ease;
    }

    .delivery-option:hover {
        background-color: #f8f9fa;
    }

    .badge.bg-soft-info {
        background-color: rgba(85, 110, 230, 0.1);
    }

    .floating-button {
        position: fixed;
        bottom: 8rem;
        right: 2rem;
        z-index: 1000;
    }

    .floating-button .btn {
        width: 60px;
        height: 60px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .floating-button .btn i {
        font-size: 24px;
    }

    .floating-button .btn:hover {
        transform: scale(1.1);
        box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23) !important;
    }
</style>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection