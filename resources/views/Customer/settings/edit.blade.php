@extends('layouts.master')
@section('title') Settings @endsection
@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Change Password</h4>
            </div>

            <div class="card-body">
                <form action="{{ route('customer.settings.update') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('PUT')
                    
                    <div class="row g-3 mb-4">
                        <div class="col-lg-6">
                            <div>
                                <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5" 
                                        id="current_password" 
                                        name="current_password" 
                                        placeholder="Enter current password"
                                        required>
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" 
                                        type="button" id="password-addon">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div>
                                <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" class="form-control pe-5" 
                                        id="password" 
                                        name="password" 
                                        placeholder="Enter new password"
                                        required>
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" 
                                        type="button">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Hidden push notification setting -->
                        <input type="hidden" name="notification_push" value="1">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" id="saveButton">
                            <i class="ri-save-line align-bottom me-1"></i> Update Password
                        </button>
                    </div>
                </form>

                <!-- Information Alert about notifications -->
                <div class="alert alert-info mt-4">
                    <div class="d-flex">
                        <i class="ri-information-line fs-3 me-2"></i>
                        <div>
                            <h6 class="mb-1">Notification Settings</h6>
                            <p class="mb-0">System notifications are enabled by default. Email and SMS notifications will be available soon.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Password visibility toggle
    document.querySelectorAll('.password-addon').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.querySelector('i').classList.toggle('ri-eye-fill');
            this.querySelector('i').classList.toggle('ri-eye-off-fill');
        });
    });

    // Form submission
    document.getElementById('passwordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = this;
        
        Swal.fire({
            title: 'Update Password?',
            text: 'Are you sure you want to change your password?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Update',
            cancelButtonText: 'No, Cancel',
            confirmButtonClass: 'btn btn-primary',
            cancelButtonClass: 'btn btn-danger',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Show success message if exists
    @if(session('success'))
        Swal.fire({
            title: 'Success!',
            text: '{{ session('success') }}',
            icon: 'success',
            confirmButtonClass: 'btn btn-primary'
        });
    @endif

    // Show error message if exists
    @if(session('error'))
        Swal.fire({
            title: 'Error!',
            text: '{{ session('error') }}',
            icon: 'error',
            confirmButtonClass: 'btn btn-primary'
        });
    @endif
});
</script>
@endsection