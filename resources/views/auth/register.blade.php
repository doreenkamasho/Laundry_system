@extends('layouts.master-without-nav')
@section('title')
    Register - LaundryHub
@endsection
@section('content')
<div class="auth-page-wrapper pt-5">

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                    <div>
                            <a href="/" class="d-inline-block auth-logo">
                                <span class="position-relative">
                                    <i class="fas fa-tshirt fa-3x" style="color: #4169E1;"></i>
                                    <i class="fas fa-sun position-absolute" style="color: #FF69B4; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 1.2em;"></i>
                                </span>
                            </a>
                        </div>
                        <p class="mt-3 fs-15 fw-medium text-info">Your Trusted Laundry Service Partner</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4 border-0 shadow-lg">
                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Create New Account</h5>
                                <p class="text-muted">Get started with LaundryHub</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form class="needs-validation" novalidate method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                    @csrf
                                    <!-- Name Field -->
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" id="username"
                                            placeholder="Enter your full name" required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Email Field -->
                                    <div class="mb-3">
                                        <label for="useremail" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" id="useremail"
                                                placeholder="Enter email address" required>
                                        </div>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Phone Number Field -->
                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <div class="position-relative">
                                            <input type="text" class="form-control @error('phone_number') is-invalid @enderror"
                                                name="phone_number" value="{{ old('phone_number') }}" id="phone_number"
                                                placeholder="Enter phone number" required>
                                        </div>
                                        @error('phone_number')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Address Field -->
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <div class="position-relative">
                                            <textarea class="form-control @error('address') is-invalid @enderror"
                                                name="address" id="address" rows="3"
                                                placeholder="Enter your address">{{ old('address') }}</textarea>
                                        </div>
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Password Fields -->
                                    <div class="mb-3">
                                        <label class="form-label" for="userpassword">Password <span class="text-danger">*</span></label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" class="form-control pe-5 @error('password') is-invalid @enderror" 
                                                name="password" placeholder="Enter password" id="userpassword" required>
                                            <button class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none text-muted" 
                                                type="button" id="password-addon">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="confirm-password">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="position-relative auth-pass-inputgroup">
                                            <input type="password" class="form-control pe-5" name="password_confirmation" 
                                                placeholder="Confirm password" id="confirm-password" required>
                                            <button class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-decoration-none text-muted" 
                                                type="button" id="confirm-password-addon">
                                                <i class="fas fa-eye-slash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Avatar Field -->
                                    <div class="mb-3">
                                        <label for="avatar" class="form-label">Profile Picture</label>
                                        <div class="position-relative">
                                            <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                                                name="avatar" id="avatar" accept="image/*">
                                        </div>
                                        @error('avatar')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Terms and Conditions -->
                                    <div class="mb-4">
                                        <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the LaundryHub 
                                            <a href="{{ route('terms') }}" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a>
                                        </p>
                                    </div>

                                    <!-- Social Login -->
                                    <div class="d-flex gap-3 justify-content-center mb-4">
                                        <a href="#" class="btn btn-icon btn-google">
                                            <svg class="google-icon" viewBox="0 0 48 48">
                                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                            </svg>
                                        </a>
                                        <a href="#" class="btn btn-icon btn-github">
                                            <svg class="social-icon" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M12 2C6.477 2 2 6.477 2 12c0 4.42 2.865 8.17 6.839 9.49.5.092.682-.217.682-.482 0-.237-.008-.866-.013-1.7-2.782.604-3.369-1.34-3.369-1.34-.454-1.156-1.11-1.462-1.11-1.462-.908-.62.069-.608.069-.608 1.003.07 1.531 1.03 1.531 1.03.892 1.529 2.341 1.087 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.11-4.555-4.943 0-1.091.39-1.984 1.029-2.683-.103-.253-.446-1.27.098-2.647 0 0 .84-.269 2.75 1.025A9.578 9.578 0 0112 6.836c.85.004 1.705.114 2.504.336 1.909-1.294 2.747-1.025 2.747-1.025.546 1.377.203 2.394.1 2.647.64.699 1.028 1.592 1.028 2.683 0 3.842-2.339 4.687-4.566 4.935.359.309.678.919.678 1.852 0 1.336-.012 2.415-.012 2.743 0 .267.18.578.688.481C19.138 20.167 22 16.418 22 12c0-5.523-4.477-10-10-10z"/>
                                            </svg>
                                        </a>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-primary w-100" type="submit">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center signup-section">
                        <p class="mb-0">Already have an account? 
                            <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline">Sign in</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">
                            &copy; <script>document.write(new Date().getFullYear())</script> LaundryHub. 
                            All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/form-validation.init.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection
