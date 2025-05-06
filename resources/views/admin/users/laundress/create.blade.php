@extends('layouts.master')
@section('title') Add New Laundress @endsection

@section('css')
    <link href="{{ URL::asset('css/laundress.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        #map { 
            min-height: 400px;
            width: 100%;
            z-index: 1;
        }
        .leaflet-control-geocoder {
            z-index: 2;
        }
    </style>
@endsection

@section('content')

@component('components.breadcrumb')
    @slot('li_1') Laundress @endslot
    @slot('title') Add New Laundress @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Laundress Information</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.laundress.store') }}" method="POST" enctype="multipart/form-data" id="laundressForm">
                    @csrf
                    <div class="row g-3">
                        <!-- Personal Information -->
                        <div class="col-lg-6">
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Personal Details</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                            name="name" value="{{ old('name') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                            name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                            name="phone_number" value="{{ old('phone_number') }}" required>
                                        @error('phone_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" 
                                                class="form-control pe-5 @error('password') is-invalid @enderror" 
                                                name="password" 
                                                id="laundress-password"
                                                required>
                                            <!-- <button class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none text-muted" 
                                                type="button"
                                                id="laundress-password-addon">
                                                <i class="fas fa-eye-slash"></i>
                                            </button> -->
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location & Additional Info -->
                        <div class="col-lg-6">
                            <div class="card border">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Location & Additional Info</h5>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label">Address <span class="text-danger">*</span></label>
                                        <input type="text" id="address-input" class="form-control @error('address') is-invalid @enderror" 
                                            name="address" value="{{ old('address') }}" required>
                                        @error('address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Hidden fields for coordinates -->
                                    <input type="hidden" name="latitude" id="latitude">
                                    <input type="hidden" name="longitude" id="longitude">

                                    <!-- Map Preview -->
                                    <div class="mb-3">
                                        <div id="map" style="height: 300px; width: 100%;" class="rounded border"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Profile Picture</label>
                                        <input type="file" class="form-control @error('avatar') is-invalid @enderror" 
                                            name="avatar" accept="image/*">
                                        @error('avatar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Initial Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" 
                                                name="is_active" checked>
                                            <label class="form-check-label">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <a href="{{ route('admin.laundress.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Laundress</button>
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
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="{{ URL::asset('build/js/pages/laundress-map.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}" defer></script>
@endsection