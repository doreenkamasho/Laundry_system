@extends('layouts.master')
@section('title') Find Laundress @endsection

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
<link href="{{ URL::asset('css/map.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Customer @endslot
    @slot('title') Find Laundress @endslot
@endcomponent

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div class="d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">
                                Available Laundresses Near You
                                <span class="badge bg-primary ms-1">{{ $laundresses->count() }}</span>
                            </h4>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap gap-2">
                            <div class="search-box">
                                <input type="text" class="form-control" id="searchInput" placeholder="Search laundress...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-light" id="locationFilter">
                                    <i class="ri-map-pin-line align-bottom"></i> Near Me
                                </button>
                                <button type="button" class="btn btn-light" id="ratingFilter">
                                    <i class="ri-star-line align-bottom"></i> Top Rated
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div id="map" class="mb-3"></div>
                <div class="row g-4" id="laundressList">
                    @forelse($laundresses as $laundress)
                        <div class="col-md-6 col-xl-3 laundress-item" 
                            data-latitude="{{ $laundress->laundressDetail->latitude }}" 
                            data-longitude="{{ $laundress->laundressDetail->longitude }}">
                            <div class="card ribbon-box border shadow-none mb-lg-0">
                                @if($laundress->laundressDetail->availability_status)
                                    <div class="ribbon ribbon-success">Available</div>
                                @else
                                    <div class="ribbon ribbon-warning">Busy</div>
                                @endif
                                <div class="card-body text-center">
                                    <div class="position-relative d-inline-block mb-3">
                                        @if($laundress->avatar)
                                            <img src="{{ asset('storage/'.$laundress->avatar) }}" 
                                                class="avatar-lg rounded-circle img-thumbnail"
                                                alt="{{ $laundress->name }}"
                                                loading="lazy">
                                        @else
                                            <div class="avatar-lg rounded-circle bg-primary text-white mx-auto">
                                                <span class="avatar-title">{{ substr($laundress->name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <h5 class="mb-1">{{ $laundress->name }}</h5>
                                    <p class="text-muted mb-2">
                                        <i class="ri-map-pin-line align-middle"></i> 
                                        {{ Str::limit($laundress->laundressDetail->address, 30) }}
                                    </p>
                                    <div class="distance-info text-muted small mb-2">
                                        <i class="ri-route-line align-middle"></i> Calculating...
                                    </div>
                                    <div class="mb-3">
                                        <a href="{{ route('customer.laundress.reviews', $laundress->id) }}" class="text-decoration-none">
                                            <div class="d-flex align-items-center justify-content-center gap-1">
                                                <i class="ri-star-fill text-warning"></i>
                                                <span>{{ number_format($laundress->average_rating, 1) }}</span>
                                                <span class="text-muted">({{ $laundress->reviews_count }} reviews)</span>
                                                <i class="ri-arrow-right-s-line text-muted"></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center mb-3">
                                        <span class="badge badge-soft-primary">
                                            <i class="ri-time-line align-bottom"></i> Fast Service
                                        </span>
                                        <span class="badge badge-soft-success">
                                            <i class="ri-shield-check-line align-bottom"></i> Verified
                                        </span>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('customer.laundress.profile', $laundress->id) }}" 
                                           class="btn btn-info btn-sm">
                                            <i class="ri-eye-line align-bottom"></i> Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="ri-information-line me-2 align-middle fs-16"></i>
                                No laundresses available at the moment.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 

@section('script')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ URL::asset('build/js/pages/find-laundress.init.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/distance-sort.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/rating-sort.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/search-filter.js') }}"></script>

<script>
document.getElementById('searchInput').addEventListener('keyup', function(e) {
    const searchText = e.target.value.toLowerCase();
    const items = document.getElementsByClassName('laundress-item');
    
    Array.from(items).forEach(item => {
        const name = item.querySelector('h5').innerText.toLowerCase();
        const address = item.querySelector('.text-muted').innerText.toLowerCase();
        
        if (name.includes(searchText) || address.includes(searchText)) {
            item.style.display = '';
        } else {
            item.style.display = 'none';
        }
    });
});

document.getElementById('locationFilter').addEventListener('click', function() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            // Add location filtering logic
            Swal.fire({
                title: 'Sorting by distance...',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                }
            });
        });
    }
});
</script>
@endsection
