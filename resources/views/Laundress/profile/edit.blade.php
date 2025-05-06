@extends('layouts.master')

@section('title') Edit Profile @endsection

@section('css')
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('laundress.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-lg-3">
                                <label for="avatar" class="form-label">Profile Picture</label>
                                <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                                    <img src="{{ auth()->user()->avatar ? Storage::url(auth()->user()->avatar) : asset('images/users/avatar-1.jpg') }}"
                                         class="rounded-circle avatar-xl img-thumbnail user-profile-image"
                                         alt="user-profile-image">
                                    <div class="avatar-xs p-0 rounded-circle profile-photo-edit position-absolute end-0 bottom-0">
                                        <input id="avatar" name="avatar" type="file" class="profile-img-file-input">
                                        <label for="avatar" class="profile-photo-edit avatar-xs">
                                            <span class="avatar-title rounded-circle bg-light text-body">
                                                <i class="ri-camera-fill"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                @error('avatar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', auth()->user()->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', auth()->user()->email) }}"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone', auth()->user()->phone) }}"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" 
                                       class="form-control @error('address') is-invalid @enderror" 
                                       id="address" 
                                       name="address" 
                                       value="{{ old('address', auth()->user()->address) }}"
                                       required>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <h5 class="mb-3">Business Information</h5>
                            </div>
                            <div class="col-lg-6">
                                <label for="business_name" class="form-label">Business Name</label>
                                <input type="text" 
                                       class="form-control @error('business_name') is-invalid @enderror" 
                                       id="business_name" 
                                       name="business_name" 
                                       value="{{ old('business_name', auth()->user()->business_name) }}">
                                @error('business_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <label for="business_address" class="form-label">Business Address</label>
                                <input type="text" 
                                       class="form-control @error('business_address') is-invalid @enderror" 
                                       id="business_address" 
                                       name="business_address" 
                                       value="{{ old('business_address', auth()->user()->business_address) }}">
                                @error('business_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="business_description" class="form-label">Business Description</label>
                                <textarea class="form-control @error('business_description') is-invalid @enderror" 
                                          id="business_description" 
                                          name="business_description" 
                                          rows="4">{{ old('business_description', auth()->user()->business_description) }}</textarea>
                                @error('business_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success">Update Profile</button>
                                <a href="{{ route('laundress.profile.show') }}" class="btn btn-light ms-1">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // Preview uploaded avatar
    document.getElementById('avatar').addEventListener('change', function(e) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.user-profile-image').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);
    });
</script>
@endsection