@extends('layouts.master')

@section('title') Account Settings @endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Change Password</h4>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('laundress.settings.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="current_password" class="form-label">Current Password</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" 
                                           class="form-control pe-5 @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password" 
                                           placeholder="Enter current password"
                                           required>
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" 
                                            type="button">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="password" class="form-label">New Password</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" 
                                           class="form-control pe-5 @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Enter new password"
                                           required>
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" 
                                            type="button">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <div class="position-relative auth-pass-inputgroup">
                                    <input type="password" 
                                           class="form-control pe-5" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           placeholder="Confirm new password"
                                           required>
                                    <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" 
                                            type="button">
                                        <i class="ri-eye-fill align-middle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-success">Update Password</button>
                                <button type="reset" class="btn btn-light ms-1">Reset</button>
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
    // Password show/hide buttons
    document.querySelectorAll('.password-addon').forEach(function(button) {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('ri-eye-fill', 'ri-eye-off-fill');
            } else {
                input.type = 'password';
                icon.classList.replace('ri-eye-off-fill', 'ri-eye-fill');
            }
        });
    });
</script>
@endsection