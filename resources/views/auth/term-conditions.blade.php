@extends('layouts.master-without-nav')
@section('title')
    Terms & Conditions - LaundryHub
@endsection
@section('content')
<div class="auth-page-wrapper pt-5">

    <div class="auth-page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card mt-4">
                        <div class="card-body p-4">
                            <div class="text-center">
                                <h3 class="text-primary">LaundryHub Terms & Conditions</h3>
                                <p class="text-muted">Last Updated: April 24, 2025</p>
                            </div>
                            <div>
                                <h5>Welcome to LaundryHub!</h5>
                                <p class="text-muted">These terms and conditions outline the rules and regulations for using LaundryHub's services and website. By accessing our platform, you agree to these terms.</p>
                            </div>

                            <div class="mt-4">
                                <h5>Service Terms</h5>
                                <ul class="text-muted vstack gap-2">
                                    <li>LaundryHub provides laundry and dry cleaning services through our platform</li>
                                    <li>Users must provide accurate information when scheduling services</li>
                                    <li>Payment is required before service completion</li>
                                    <li>Cancellations must be made at least 24 hours before scheduled pickup</li>
                                </ul>
                            </div>

                            <div class="mt-4">
                                <h5>User Responsibilities</h5>
                                <ul class="text-muted vstack gap-2">
                                    <li>Properly bag and label all items for cleaning</li>
                                    <li>Declare any special care requirements or delicate items</li>
                                    <li>Ensure someone is available during pickup/delivery windows</li>
                                    <li>Report any issues within 24 hours of delivery</li>
                                </ul>
                            </div>

                            <div class="mt-4">
                                <h5>Service Guarantee</h5>
                                <p class="text-muted">LaundryHub strives to provide quality cleaning services. However:</p>
                                <ul class="text-muted vstack gap-2">
                                    <li>We are not responsible for items that are already damaged</li>
                                    <li>Color bleeding from improper dye processes</li>
                                    <li>Damage due to incorrect care labels</li>
                                    <li>Loss of items not properly declared in the order</li>
                                </ul>
                            </div>

                            <div class="mt-4">
                                <h5>Privacy & Data</h5>
                                <p class="text-muted">We collect and process your data according to our privacy policy, including:</p>
                                <ul class="text-muted vstack gap-2">
                                    <li>Contact information for service coordination</li>
                                    <li>Address details for pickup and delivery</li>
                                    <li>Payment information for processing orders</li>
                                    <li>Service history to improve user experience</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary">Accept & Continue</a>
                        <button type="button" class="btn btn-soft-dark ms-1" onclick="window.history.back()">
                            <i class="fas fa-arrow-left me-1"></i> Go Back
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
@endsection
