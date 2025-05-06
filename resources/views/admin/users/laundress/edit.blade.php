@extends('layouts.master')
@section('title') Edit Laundress @endsection

@section('css')
<link href="{{ URL::asset('css/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Admin @endslot
    @slot('title') Edit Laundress @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Edit Laundress Information</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.laundress.update', $laundress->id) }}" 
                    method="POST" 
                    enctype="multipart/form-data" 
                    id="editLaundressForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3">
                        <div class="col-lg-6">
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Basic Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            class="form-control @error('name') is-invalid @enderror" 
                                            name="name" 
                                            value="{{ old('name', $laundress->name) }}"
                                            required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" 
                                            class="form-control @error('email') is-invalid @enderror" 
                                            name="email" 
                                            value="{{ old('email', $laundress->email) }}"
                                            required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            class="form-control @error('phone_number') is-invalid @enderror" 
                                            name="phone_number" 
                                            value="{{ old('phone_number', $laundress->laundressDetail->phone_number) }}"
                                            required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Profile Picture</label>
                                        <input type="file" 
                                            class="form-control @error('avatar') is-invalid @enderror" 
                                            name="avatar"
                                            accept="image/*">
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($laundress->avatar)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/'.$laundress->avatar) }}" 
                                                    alt="Current Avatar" 
                                                    class="avatar-sm rounded">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Location Information</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Address <span class="text-danger">*</span></label>
                                        <input type="text" 
                                            class="form-control @error('address') is-invalid @enderror" 
                                            name="address"
                                            id="address-input"
                                            value="{{ old('address', $laundress->laundressDetail->address) }}"
                                            required>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Current Location</label>
                                        <input type="text" 
                                            class="form-control @error('current_location') is-invalid @enderror" 
                                            name="current_location"
                                            id="current-location"
                                            value="{{ old('current_location', $laundress->laundressDetail->current_location) }}">
                                        @error('current_location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="latitude" id="latitude" 
                                        value="{{ old('latitude', $laundress->laundressDetail->latitude) }}">
                                    <input type="hidden" name="longitude" id="longitude"
                                        value="{{ old('longitude', $laundress->laundressDetail->longitude) }}">

                                    <div class="location-controls">
                                        <button type="button" name="get-current-location" id="get-current-location" class="btn btn-sm btn-primary">
                                            <i class="ri-map-pin-user-line"></i> Get Current Location
                                        </button>
                                    </div>

                                    <div id="map" style="height: 300px;" class="mb-3 rounded"></div>

                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" 
                                                type="checkbox" 
                                                name="availability_status"
                                                {{ $laundress->laundressDetail->availability_status ? 'checked' : '' }}>
                                            <label class="form-check-label">Available for Work</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{ route('admin.laundress.show', $laundress->id) }}" 
                                    class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Laundress</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@push('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the map
            const mapElement = document.getElementById('map');
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const addressInput = document.getElementById('address-input');
            const currentLocationInput = document.getElementById('current-location');
            const getCurrentLocationBtn = document.getElementById('get-current-location');
            
            if (!mapElement) {
                console.error('Map element not found');
                return;
            }
            
            // Default coordinates if none are set (Tanzania)
            let initialLat = latInput.value ? parseFloat(latInput.value) : -6.7924;
            let initialLng = lngInput.value ? parseFloat(lngInput.value) : 39.2083;
            
            // Initialize map
            const map = L.map('map').setView([initialLat, initialLng], 13);
            
            // Add tile layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);
            
            // Add a marker at the initial position
            let marker = L.marker([initialLat, initialLng], {
                draggable: true
            }).addTo(map);
            
            // Add geocoder control
            const geocoder = L.Control.geocoder({
                defaultMarkGeocode: false,
                placeholder: 'Search for address...',
                errorMessage: 'Nothing found.',
                geocoder: L.Control.Geocoder.nominatim()
            }).addTo(map);
            
            // Handle geocoder results
            geocoder.on('markgeocode', function(e) {
                const result = e.geocode;
                const latlng = result.center;
                
                marker.setLatLng(latlng);
                map.setView(latlng, 16);
                
                updateCoordinates(latlng.lat, latlng.lng);
                
                if (!addressInput.value || confirm('Update the address field with the selected location?')) {
                    addressInput.value = result.name;
                    currentLocationInput.value = result.name;
                }
            });
            
            // Update coordinates when marker is dragged
            marker.on('dragend', function(event) {
                const position = marker.getLatLng();
                updateCoordinates(position.lat, position.lng);
                reverseGeocode(position.lat, position.lng);
            });
            
            function updateCoordinates(lat, lng) {
                latInput.value = lat.toFixed(6);
                lngInput.value = lng.toFixed(6);
            }
            
            function reverseGeocode(lat, lng) {
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.display_name) {
                            if (confirm('Update the address with the new location?')) {
                                addressInput.value = data.display_name;
                                currentLocationInput.value = data.display_name;
                            }
                        }
                    })
                    .catch(error => console.error('Error reverse geocoding:', error));
            }
            
            // Get current location functionality
            getCurrentLocationBtn.addEventListener('click', function() {
                if (navigator.geolocation) {
                    this.innerHTML = '<i class="ri-loader-4-line ri-spin me-1"></i> Getting location...';
                    this.disabled = true;
                    
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const lat = position.coords.latitude;
                            const lng = position.coords.longitude;
                            
                            marker.setLatLng([lat, lng]);
                            map.setView([lat, lng], 16);
                            updateCoordinates(lat, lng);
                            reverseGeocode(lat, lng);
                            
                            getCurrentLocationBtn.innerHTML = '<i class="ri-map-pin-user-line me-1"></i> Get Current Location';
                            getCurrentLocationBtn.disabled = false;
                        },
                        function(error) {
                            console.error('Geolocation error:', error);
                            alert('Could not get your location. Please ensure location services are enabled.');
                            
                            getCurrentLocationBtn.innerHTML = '<i class="ri-map-pin-user-line me-1"></i> Get Current Location';
                            getCurrentLocationBtn.disabled = false;
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 10000,
                            maximumAge: 0
                        }
                    );
                } else {
                    alert('Geolocation is not supported by your browser.');
                }
            });
            
            // Address input change handler
            addressInput.addEventListener('change', function() {
                if (this.value) {
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(this.value)}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.length > 0) {
                                const result = data[0];
                                const lat = parseFloat(result.lat);
                                const lng = parseFloat(result.lon);
                                
                                marker.setLatLng([lat, lng]);
                                map.setView([lat, lng], 16);
                                updateCoordinates(lat, lng);
                            }
                        })
                        .catch(error => console.error('Error geocoding address:', error));
                }
            });
            
            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        });
    </script>
@endpush
@endsection