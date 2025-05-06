@extends('layouts.master')
@section('title') Laundress Details @endsection

@section('css')
<link href="{{ URL::asset('css/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""/>
<link href="{{ URL::asset('css/map.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Admin @endslot
    @slot('title') Laundress Details @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h5 class="card-title flex-grow-1 mb-0">Laundress Profile</h5>
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.laundress.edit', $laundress->id) }}" 
                            class="btn btn-primary btn-sm">
                            <i class="ri-edit-2-fill me-1 align-middle"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xxl-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    @if($laundress->avatar)
                                        <img src="{{ asset('storage/'.$laundress->avatar) }}" 
                                            alt="{{ $laundress->name }}" 
                                            class="avatar-lg rounded-circle img-thumbnail"
                                            onerror="this.onerror=null; this.src='{{ asset('images/users/default-avatar.png') }}'">
                                    @else
                                        <div class="avatar-lg mx-auto">
                                            <div class="avatar-title bg-primary text-primary bg-opacity-10 rounded-circle fs-1">
                                                {{ substr($laundress->name, 0, 1) }}
                                            </div>
                                        </div>
                                    @endif
                                    <h5 class="mt-3 mb-1">{{ $laundress->name }}</h5>
                                    <p class="text-muted">Laundress</p>
                                </div>
                                <div class="mt-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="ri-mail-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Email</h6>
                                            <p class="text-muted mb-0">{{ $laundress->email }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="flex-shrink-0">
                                            <i class="ri-phone-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Phone</h6>
                                            <p class="text-muted mb-0">{{ $laundress->laundressDetail->phone_number ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <i class="ri-map-pin-line text-muted fs-16"></i>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Address</h6>
                                            <p class="text-muted mb-0">{{ $laundress->laundressDetail->address ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="col-xxl-9">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Additional Details</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Account Status</h6>
                                            <span class="badge bg-{{ $laundress->is_active ? 'success' : 'danger' }} fs-12">
                                                {{ $laundress->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Member Since</h6>
                                            <p class="text-muted mb-0">{{ $laundress->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Current Location</h6>
                                            <p class="text-muted mb-0">{{ $laundress->laundressDetail->current_location ?? 'N/A' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Availability Status</h6>
                                            <span class="badge bg-{{ $laundress->laundressDetail->availability_status ? 'success' : 'warning' }} fs-12">
                                                {{ $laundress->laundressDetail->availability_status ? 'Available' : 'Unavailable' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($laundress->laundressDetail && $laundress->laundressDetail->latitude && $laundress->laundressDetail->longitude)
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Location</h5>
                            </div>
                            <div class="card-body">
                                <div id="map"></div>
                            </div>
                        </div>
                        @endif
                    </div><!--end col-->
                </div><!--end row-->
            </div>
        </div>
    </div><!--end col-->
</div><!--end row-->
@endsection

@section('script')
@if($laundress->laundressDetail && $laundress->laundressDetail->latitude && $laundress->laundressDetail->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const location = [
        {{ $laundress->laundressDetail->latitude }},
        {{ $laundress->laundressDetail->longitude }}
    ];
    
    const map = L.map('map').setView(location, 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Create custom popup content
    const popupContent = `
        <div class="custom-popup">
            @if($laundress->avatar)
                <img src="{{ asset('storage/'.$laundress->avatar) }}" 
                    alt="{{ $laundress->name }}"
                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'avatar-fallback\'>{{ substr($laundress->name, 0, 1) }}</div>'">
            @else
                <div class="avatar-fallback">{{ substr($laundress->name, 0, 1) }}</div>
            @endif
            <p class="name">{{ $laundress->name }}</p>
        </div>
    `;

    // Add marker with custom popup
    L.marker(location)
        .addTo(map)
        .bindPopup(popupContent, {
            className: 'custom-popup-wrapper',
            closeButton: false,
            minWidth: 120
        })
        .openPopup();

    setTimeout(() => {
        map.invalidateSize();
    }, 100);
});
</script>
@endif
@endsection