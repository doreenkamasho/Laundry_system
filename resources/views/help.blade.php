@extends('layouts.master')
@section('title') Help & Support @endsection
@section('content')

<div class="row">
    <div class="col-xxl-12">
        <!-- About Us Card -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="text-center">
                    <i class="ri-service-line text-primary display-4 mb-3"></i>
                    <h4 class="mb-3">Welcome to Our Laundry Platform</h4>
                    <p class="text-muted">
                        We are your trusted bridge between customers and laundresses, making laundry services 
                        accessible, secure, and efficient. Our platform ensures:
                    </p>
                </div>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <i class="ri-shield-check-line text-success display-5 mb-2"></i>
                            <h5>Secure Process</h5>
                            <p>Protected transactions and verified laundresses for your peace of mind</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <i class="ri-map-pin-time-line text-warning display-5 mb-2"></i>
                            <h5>Time-Saving</h5>
                            <p>Find nearby laundresses instantly with our location-based system</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center p-3">
                            <i class="ri-customer-service-2-line text-info display-5 mb-2"></i>
                            <h5>24/7 Support</h5>
                            <p>Dedicated support team ready to assist you anytime</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Help Options -->
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Help & Support Options</h4>
            </div>

            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="card border shadow-none">
                            <div class="card-body text-center">
                                <i class="ri-question-line text-primary display-5 mb-2"></i>
                                <h5>FAQ</h5>
                                <p class="text-muted mb-3">Find answers to frequently asked questions</p>
                                <a href="#" class="btn btn-soft-primary btn-sm">View FAQs</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card border shadow-none">
                            <div class="card-body text-center">
                                <i class="ri-mail-send-line text-success display-5 mb-2"></i>
                                <h5>Email Support</h5>
                                <p class="text-muted mb-3">Get in touch with our support team</p>
                                <a href="mailto:support@example.com" class="btn btn-soft-success btn-sm">Email Us</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card border shadow-none">
                            <div class="card-body text-center">
                                <i class="ri-whatsapp-line text-success display-5 mb-2"></i>
                                <h5>WhatsApp Support</h5>
                                <p class="text-muted mb-3">Direct chat with admin support</p>
                                <a href="https://wa.me/255754318464" target="_blank" class="btn btn-soft-success btn-sm">
                                    <i class="ri-whatsapp-line align-middle me-1"></i> Chat Now
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="card border shadow-none">
                            <div class="card-body text-center">
                                <i class="ri-guide-line text-warning display-5 mb-2"></i>
                                <h5>User Guide</h5>
                                <p class="text-muted mb-3">Learn how to use our platform</p>
                                <a href="#" class="btn btn-soft-warning btn-sm">View Guide</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="alert alert-info alert-additional mt-4">
                    <div class="alert-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-error-warning-line fs-16 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-2">Need Urgent Help?</h5>
                                <p class="mb-0">For immediate assistance or emergencies, please contact our support team via WhatsApp:</p>
                                <a href="https://wa.me/2555754318464" target="_blank" 
                                    class="btn btn-soft-dark btn-sm mt-2">
                                    <i class="ri-whatsapp-line align-middle me-1"></i> +255 754318464
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection