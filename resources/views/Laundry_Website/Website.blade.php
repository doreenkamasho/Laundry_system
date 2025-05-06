@extends('layouts.master-without-nav')
@section('title')
    Laundry System - Find & Book Nearby Laundry Services
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('css/custom.css') }}" rel="stylesheet" type="text/css" />
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection
@section('body')
<body data-bs-spy="scroll" data-bs-target="#navbar">
@endsection
@section('content')
    <!-- Begin page -->
    <div class="layout-wrapper landing">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-landing fixed-top" id="navbar">
            <div class="container">
                <a class="navbar-brand" href="/">
                    <h3 class="text-primary">LaundryHub</h3>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active fw-semibold" href="#home">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="#services">
                                <i class="fas fa-tshirt me-1"></i>Services
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold" href="#how-it-works">
                                <i class="fas fa-info-circle me-1"></i>How It Works
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="btn btn-soft-primary dropdown-toggle ms-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>Login / Register
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-2"></i>Register
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Hero Section -->
        <section class="section pb-0 hero-section" id="home">
            <div class="container">
            <div class="row align-items-center">
            <div class="col-lg-6">
            <div class="mt-5">
                <div class="badge bg-soft-primary text-primary fs-5 mb-3">Professional & Reliable</div>
                <h1 class="display-5 fw-semibold mb-3">Find & Book Nearby 
                <span class="text-primary">Laundry Services</span></h1>
                <p class="lead text-muted mb-4">Book reliable laundry services near you. Track your laundry in real-time and get doorstep delivery.</p>
                
                <!-- Features List -->
                <div class="mb-4">
                <div class="d-flex align-items-center mb-2">
                <i class="fas fa-check-circle text-success me-2"></i>
                <span>Free Pickup & Delivery</span>
                </div>
                <div class="d-flex align-items-center mb-2">
                <i class="fas fa-check-circle text-success me-2"></i>
                <span>Premium Quality Service</span>
                </div>
                <div class="d-flex align-items-center mb-3">
                <i class="fas fa-check-circle text-success me-2"></i>
                <span>24/7 Customer Support</span>
                </div>
                </div>

                <div class="d-flex gap-2 pb-4">
                    <a href="{{ route('register') }}" class="btn btn-soft-warning btn-md">
                        <i class="fas fa-search me-2"></i>Find Laundry Services
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-light btn-md">
                        <i class="fas fa-map-marker-alt me-2"></i>Track Order
                    </a>
                </div>
            </div>
            </div>
            <div class="col-lg-6">
            <div class="position-relative">
                <div class="hero-carousel">
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset('images/Laundry_Website/web1.png') }}" alt="Laundry Service" class="img-fluid rounded-3 shadow-lg">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('images/Laundry_Website/web2.png') }}" alt="Laundry Service" class="img-fluid rounded-3 shadow-lg">
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('images/Laundry_Website/web3.png') }}" alt="Laundry Service" class="img-fluid rounded-3 shadow-lg">
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
                <div class="position-absolute top-0 start-0 translate-middle p-3 rounded-circle discount-badge" 
                     style="background: linear-gradient(45deg, #ff6b6b, #ffa502);
                            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
                            animation: gentleBounce 3s ease-in-out infinite;">
                    <div class="text-center text-white">
                        <h4 class="mb-0 fw-bold">20%</h4>
                        <small>OFF</small>
                    </div>
                </div>
            </div>
            </div>
            </div>
            </div>
        </section>

        <!-- Services Section -->
        <section class="section" id="services" style="background-image: url('{{ asset('images/Laundry_Website/bg-pattern.png') }}');">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <span class="badge bg-soft-primary text-primary mb-3 fs-5 px-4 py-2">Our Services</span>
                        <h2 class="mb-4 fw-bold">Professional Laundry Services</h2>
                        <p class="text-muted mb-5">Experience premium laundry care with our comprehensive range of services</p>
                    </div>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4">
                        <div class="card service-card border-0 shadow-sm hover-lift">
                            <div class="card-body text-center p-4">
                                <div class="service-icon mx-auto mb-4">
                                    <i class="fas fa-tshirt fs-2"></i>
                                </div>
                                <h5 class="service-title mb-3">Wash & Fold</h5>
                                <p class="text-muted mb-4">Professional washing and folding services for your everyday clothes</p>
                                <div class="service-features mb-4">
                                    <ul class="list-unstyled">
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Same-day service</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Eco-friendly detergents</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Fabric care expertise</span>
                                        </li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-soft-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card service-card border-0 shadow-sm hover-lift">
                            <div class="card-body text-center p-4">
                                <div class="service-icon mx-auto mb-4">
                                    <i class="fas fa-tint fs-2"></i>
                                </div>
                                <h5 class="service-title mb-3">Dry Cleaning</h5>
                                <p class="text-muted mb-4">Expert dry cleaning for your delicate and special garments</p>
                                <div class="service-features mb-4">
                                    <ul class="list-unstyled">
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Premium care</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Stain removal</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Gentle processing</span>
                                        </li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-soft-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card service-card border-0 shadow-sm hover-lift">
                            <div class="card-body text-center p-4">
                                <div class="service-icon mx-auto mb-4">
                                    <i class="fas fa-truck fs-2"></i>
                                </div>
                                <h5 class="service-title mb-3">Pickup & Delivery</h5>
                                <p class="text-muted mb-4">Convenient doorstep pickup and delivery services</p>
                                <div class="service-features mb-4">
                                    <ul class="list-unstyled">
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Real-time tracking</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Flexible scheduling</span>
                                        </li>
                                        <li class="mb-2 d-flex align-items-center">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            <span>Contact-free delivery</span>
                                        </li>
                                    </ul>
                                </div>
                                <a href="#" class="btn btn-soft-primary">Learn More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- How It Works -->
        <section class="section" id="how-it-works" style="background-image: url('{{ asset('images/Laundry_Website/marketplace.png') }}');">
            <div class="container">
            <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
            <span class="badge bg-soft-primary text-primary mb-3 fs-5 px-4 py-2">Simple Process</span>
            <h2 class="mb-4 fw-bold">How It Works</h2>
            <p class="text-muted mb-5 lead">Four easy steps to get your laundry done</p>
            </div>
            </div>
            <div class="row g-4">
            <div class="col-lg-3">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body text-center">
                <div class="process-icon-box mb-4">
                <i class="fas fa-calendar-check text-primary fs-2"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">1</span>
                </div>
                <h5 class="card-title">Book Service</h5>
                <p class="card-text text-muted">Schedule your pickup time and choose your preferred services</p>
                <div class="d-none d-lg-block text-primary mt-4">
                <i class="fas fa-arrow-right"></i>
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-3">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body text-center">
                <div class="process-icon-box mb-4">
                <i class="fas fa-people-carry text-primary fs-2"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">2</span>
                </div>
                <h5 class="card-title">Pickup</h5>
                <p class="card-text text-muted">Our professional team collects your clothes from your doorstep</p>
                <div class="d-none d-lg-block text-primary mt-4">
                <i class="fas fa-arrow-right"></i>
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-3">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body text-center">
                <div class="process-icon-box mb-4">
                <i class="fas fa-soap text-primary fs-2"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">3</span>
                </div>
                <h5 class="card-title">Processing</h5>
                <p class="card-text text-muted">Your clothes are cleaned with care using premium products</p>
                <div class="d-none d-lg-block text-primary mt-4">
                <i class="fas fa-arrow-right"></i>
                </div>
                </div>
            </div>
            </div>
            <div class="col-lg-3">
            <div class="card h-100 border-0 shadow-sm hover-lift">
                <div class="card-body text-center">
                <div class="process-icon-box mb-4">
                <i class="fas fa-box-open text-primary fs-2"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-primary">4</span>
                </div>
                <h5 class="card-title">Delivery</h5>
                <p class="card-text text-muted">Fresh, clean clothes delivered right to your doorstep</p>
                </div>
            </div>
            </div>
            </div>
            </div>
        </section>

        <!-- start cta -->
        <section class="py-5 bg-primary position-relative">
            <div class="bg-overlay bg-overlay-pattern opacity-50"></div>
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-sm">
                        <div>
                            <h4 class="text-white mb-0 fw-semibold">Get Fresh, Clean Laundry Delivered to Your Doorstep!</h4>
                            <p class="text-white-50 mt-2 mb-0">Join thousands of satisfied customers who trust our laundry services</p>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-sm-auto">
                        <div>
                            <a href="#" class="btn bg-gradient btn-light">
                                <i class="fas fa-tshirt align-middle me-1"></i> Start Your Laundry
                            </a>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </section>
        <!-- end cta -->

        <!-- Start footer -->
        <footer class="custom-footer bg-dark py-5 position-relative">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mt-4">
                        <div>
                            <div class="footer-logo">
                                <h3 class="text-white">LaundryHub</h3>
                            </div>
                            <div class="mt-4 fs-13">
                                <p>Your Trusted Laundry Service Partner</p>
                                <p class="ff-secondary">We provide professional laundry and dry cleaning services with free pickup and delivery to your doorstep. Quality care for your garments, guaranteed satisfaction.</p>
                            </div>
                            <div class="footer-contact mt-4">
                                <p class="text-white-50 mb-2"><i class="fas fa-phone me-2"></i> +1 234 567 8900</p>
                                <p class="text-white-50 mb-2"><i class="fas fa-envelope me-2"></i> contact@laundryhub.com</p>
                                <p class="text-white-50"><i class="fas fa-map-marker-alt me-2"></i> 123 Laundry Street, City, State 12345</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-7 ms-lg-auto">
                        <div class="row">
                            <div class="col-sm-4 mt-4">
                                <h5 class="text-white mb-0">Services</h5>
                                <div class="text-muted mt-3">
                                    <ul class="list-unstyled ff-secondary footer-list fs-14">
                                        <li><a href="#wash-fold">Wash & Fold</a></li>
                                        <li><a href="#dry-cleaning">Dry Cleaning</a></li>
                                        <li><a href="#ironing">Ironing Service</a></li>
                                        <li><a href="#stain-removal">Stain Removal</a></li>
                                        <li><a href="#express-service">Express Service</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-4">
                                <h5 class="text-white mb-0">Quick Links</h5>
                                <div class="text-muted mt-3">
                                    <ul class="list-unstyled ff-secondary footer-list fs-14">
                                        <li><a href="#pricing">Pricing</a></li>
                                        <li><a href="#schedule">Schedule Pickup</a></li>
                                        <li><a href="#tracking">Track Order</a></li>
                                        <li><a href="#membership">Membership</a></li>
                                        <li><a href="#locations">Service Areas</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-4 mt-4">
                                <h5 class="text-white mb-0">Support</h5>
                                <div class="text-muted mt-3">
                                    <ul class="list-unstyled ff-secondary footer-list fs-14">
                                        <li><a href="#about">About Us</a></li>
                                        <li><a href="#contact">Contact</a></li>
                                        <li><a href="#faq">FAQ</a></li>
                                        <li><a href="#privacy">Privacy Policy</a></li>
                                        <li><a href="#terms">Terms of Service</a></li>
                                    </ul>
                                    <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                                    <a href="{{ route('register') }}" class="nav-link">Sign Up</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row text-center text-sm-start align-items-center mt-5 pt-4 border-top border-secondary">
                    <div class="col-sm-6">
                        <div>
                            <p class="copy-rights mb-0">
                                © <script>document.write(new Date().getFullYear())</script> LaundryHub. All rights reserved.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end mt-3 mt-sm-0">
                            <ul class="list-inline mb-0 footer-social-link">
                                <li class="list-inline-item">
                                    <a href="#" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="fab fa-facebook-f"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="fab fa-instagram"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="fab fa-twitter"></i>
                                        </div>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="#" class="avatar-xs d-block">
                                        <div class="avatar-title rounded-circle">
                                            <i class="fab fa-whatsapp"></i>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end footer -->
    </div>
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('js/hero-carousel.js') }}"></script>
@endsection
