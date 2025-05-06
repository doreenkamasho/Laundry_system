@extends('layouts.master')
@section('title')
    Edit Profile
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="position-relative d-inline-block">
                                    <div class="avatar-xl">
                                        @if(auth()->user()->avatar)
                                            <img src="{{ \App\Helpers\AvatarHelper::getAvatarUrl(auth()->user()->avatar) }}" 
                                                alt="{{ auth()->user()->name }}" 
                                                class="rounded-circle img-thumbnail"
                                                style="width: 100px; height: 100px; object-fit: cover;"
                                                id="preview-avatar">
                                        @else
                                            <div class="avatar-xl rounded-circle bg-primary text-white">
                                                <span class="avatar-title" style="font-size: 48px;">
                                                    {{ substr(auth()->user()->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="avatar-xs position-absolute bottom-0 end-0">
                                        <button type="button" 
                                            class="btn btn-light btn-sm rounded-circle" 
                                            onclick="document.getElementById('avatar-input').click();">
                                            <i class="ri-camera-fill"></i>
                                        </button>
                                    </div>
                                </div>
                                <h5 class="fs-16 mt-3 mb-1">Profile Picture</h5>
                                <p class="text-muted mb-0">Max file size 2MB</p>
                                <form id="avatar-form" action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="d-none">
                                    @csrf
                                    @method('PUT')
                                    <input type="file" 
                                        id="avatar-input" 
                                        name="avatar" 
                                        accept="image/*"
                                        onchange="submitAvatarForm()">
                                </form>
                                @error('avatar')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('customer.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                    value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" 
                                    value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">+255</span>
                                    <input type="text" class="form-control" id="phone" name="phone" 
                                        value="{{ old('phone', auth()->user()->phone) }}" 
                                        required
                                        pattern="[0-9]{9}"
                                        title="Please enter 9 digits (e.g., 712345678)"
                                        placeholder="712345678">
                                </div>
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address" name="address" 
                                    value="{{ old('address', auth()->user()->address) }}" 
                                    required
                                    placeholder="Enter your full address">
                                @error('address')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('customer.profile') }}" class="btn btn-light me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/profile-avatar.init.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Profile avatar script loaded');
            
            // Debug image path
            @if(auth()->user()->avatar)
                console.log('Avatar path:', '{{ auth()->user()->avatar }}');
                console.log('Full URL:', '{{ Storage::url(auth()->user()->avatar) }}');
                console.log('Exists:', '{{ Storage::disk("public")->exists(auth()->user()->avatar) ? "Yes" : "No" }}');
            @else
                console.log('No avatar set');
            @endif
        });
    </script>
@endsection