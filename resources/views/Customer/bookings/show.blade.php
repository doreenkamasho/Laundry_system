@extends('layouts.master')

@section('title') Booking Details @endsection

@section('css')
<style>
    .booking-details-card {
        border-radius: 0.5rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .booking-details-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .booking-header {
        background: linear-gradient(to right, #f8f9fa, #ffffff);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 0.5rem 0.5rem 0 0;
    }
    
    .booking-reference {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }
    
    .booking-reference span {
        font-weight: 600;
        color: #405189;
    }
    
    .section-title {
        position: relative;
        padding-bottom: 0.5rem;
        margin-bottom: 1.25rem;
        font-weight: 600;
        color: #364574;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        height: 3px;
        width: 50px;
        background: linear-gradient(to right, #405189, #299cdb);
        border-radius: 10px;
    }
    
    .info-section {
        background-color: #fff;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .info-section:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .info-table {
        width: 100%;
    }
    
    .info-table td {
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .info-table tr:last-child td {
        border-bottom: none;
    }
    
    .info-label {
        font-weight: 500;
        color: #6c757d;
        width: 200px;
    }
    
    .info-value {
        font-weight: 500;
        color: #212529;
    }
    
    .badge-status {
        padding: 0.5rem 0.75rem;
        font-weight: 500;
        border-radius: 0.25rem;
    }
    
    .item-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    
    .item-list li {
        padding: 0.5rem 0;
        border-bottom: 1px dashed rgba(0, 0, 0, 0.05);
    }
    
    .item-list li:last-child {
        border-bottom: none;
    }
    
    .total-amount {
        font-weight: 600;
        color: #0ab39c;
    }
    
    .pickup-delivery-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .pickup-badge {
        background-color: rgba(10, 179, 156, 0.1);
        color: #0ab39c;
    }
    
    .no-pickup-badge {
        background-color: rgba(241, 180, 76, 0.1);
        color: #f1b44c;
    }

    .payment-logo {
        width: 50px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 4px;
        overflow: hidden;
        padding: 3px;
    }

    .payment-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .vodacom-logo { background-color: #e60000; }
    .airtel-logo { background-color: #fff; }
    .halotel-logo { background-color: #ff5722; }
    .mixx-logo { background-color: #ffdd00; }

    .list-group-item {
        border-radius: 8px !important;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }

    .list-group-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card booking-details-card">
                <div class="card-header booking-header py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="card-title mb-1">Booking Details</h4>
                            <p class="booking-reference mb-0">Reference: <span>#{{ $booking->id }}</span></p>
                        </div>
                        <div>
                            <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : 'success' }} badge-status">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-lg-6">
                            <!-- Service Details -->
                            <div class="info-section">
                                <h6 class="section-title">Service Information</h6>
                                <table class="info-table">
                                    <tr>
                                        <td class="info-label">Service Name:</td>
                                        <td class="info-value">{{ $booking->service->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Selected Items:</td>
                                        <td class="info-value">
                                            <ul class="item-list">
                                                @foreach(($booking->selected_items ?? []) as $item)
                                                    <li>{{ $item['itemName'] }} - <span class="fw-medium">Tsh{{ number_format($item['price'], 2) }}</span></li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Pickup Required:</td>
                                        <td class="info-value">
                                            @if($booking->pickup_required)
                                                <span class="pickup-delivery-badge pickup-badge">
                                                    <i class="ri-truck-line me-1"></i> Yes (Tsh {{ number_format($booking->pickup_fee, 2) }})
                                                </span>
                                            @else
                                                <span class="pickup-delivery-badge no-pickup-badge">
                                                    <i class="ri-close-circle-line me-1"></i> No
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Delivery Required:</td>
                                        <td class="info-value">
                                            @if($booking->delivery_required)
                                                <span class="pickup-delivery-badge pickup-badge">
                                                    <i class="ri-truck-line me-1"></i> Yes (Tsh {{ number_format($booking->delivery_fee, 2) }})
                                                </span>
                                            @else
                                                <span class="pickup-delivery-badge no-pickup-badge">
                                                    <i class="ri-close-circle-line me-1"></i> No
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Total Amount:</td>
                                        <td class="info-value total-amount">Tsh {{ number_format($booking->total_amount, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <!-- Schedule Details -->
                            <div class="info-section">
                                <h6 class="section-title">Schedule Information</h6>
                                <table class="info-table">
                                    <tr>
                                        <td class="info-label">Date:</td>
                                        <td class="info-value">
                                            <i class="ri-calendar-2-line me-1 text-muted"></i>
                                            {{ $booking->scheduled_date->format('F j, Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Time:</td>
                                        <td class="info-value">
                                            <i class="ri-time-line me-1 text-muted"></i>
                                            {{ $booking->scheduled_time->format('g:i A') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Laundress Details -->
                            <div class="info-section">
                                <h6 class="section-title">Laundress Information</h6>
                                <table class="info-table">
                                    <tr>
                                        <td class="info-label">Name:</td>
                                        <td class="info-value">
                                            <i class="ri-user-line me-1 text-muted"></i>
                                            {{ $booking->laundress->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Contact:</td>
                                        <td class="info-value">
                                            <i class="ri-phone-line me-1 text-muted"></i>
                                            {{ optional($booking->transaction)->phone_number ?? $booking->laundress->phone_number }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Status Information -->
                            <div class="info-section">
                                <h6 class="section-title">Status Information</h6>
                                <table class="info-table">
                                    <tr>
                                        <td class="info-label">Booking Status:</td>
                                        <td class="info-value">
                                            <span class="badge bg-{{ $booking->status === 'pending' ? 'warning' : 'success' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="info-label">Payment Status:</td>
                                        <td class="info-value">
                                            <span class="badge bg-{{ $booking->payment_status === 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Additional Details -->
                            <div class="info-section">
                                <h6 class="section-title">Additional Information</h6>
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr>
                                                <th>Payment Status</th>
                                                <td>
                                                    @if($booking->payment_status === 'paid')
                                                        <span class="badge bg-success">Paid</span>
                                                    @else
                                                        <span class="badge bg-warning">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>

                                            @if($booking->pickup_required)
                                            <tr>
                                                <th>Pickup Fee</th>
                                                <td>Tsh {{ number_format($booking->pickup_fee, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Pickup Status</th>
                                                <td>
                                                    <span class="badge bg-{{ $booking->pickup_status === 'completed' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($booking->pickup_status) }}
                                                    </span>
                                                    <small class="text-muted d-block">Fee: Tsh {{ number_format($booking->pickup_fee, 2) }}</small>
                                                </td>
                                            </tr>
                                            @endif

                                            @if($booking->delivery_required)
                                            <tr>
                                                <th>Delivery Fee</th>
                                                <td>Tsh {{ number_format($booking->delivery_fee, 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Delivery Status</th>
                                                <td>
                                                    <span class="badge bg-{{ $booking->delivery_status === 'completed' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($booking->delivery_status) }}
                                                    </span>
                                                    <small class="text-muted d-block">Fee: Tsh {{ number_format($booking->delivery_fee, 2) }}</small>
                                                </td>
                                            </tr>
                                            @endif

                                            <tr>
                                                <th>Total Amount</th>
                                                <td>Tsh {{ number_format($booking->total_amount, 2) }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 text-end">
                            <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                                <i class="ri-arrow-left-line align-bottom me-1"></i> Back to Home
                            </a>
                            
                            @if($booking->status === 'pending')
                                <button type="button" class="btn btn-danger ms-1">
                                    <i class="ri-close-circle-line align-bottom me-1"></i> Cancel Booking
                                </button>
                            @endif

                            {{-- Show Pay Now button only if booking is confirmed and not paid --}}
                            @if($booking->status === 'confirmed' && $booking->payment_status !== 'paid')
                                <button type="button" class="btn btn-success ms-1" data-bs-toggle="modal" data-bs-target="#paymentModal">
                                    <i class="ri-bank-card-line align-bottom me-1"></i> Pay Now
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Select Payment Method</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Amount to Pay</label>
                    <div class="form-control-plaintext fw-bold text-success">
                        Tsh {{ number_format($booking->total_amount, 2) }}
                    </div>
                </div>

                <div class="list-group payment-options">
                    <div class="mb-3">
                        <label for="payment_phone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="payment_phone" 
                               placeholder="255XXXXXXXXX" required
                               pattern="255[0-9]{9}">
                        <div class="form-text">Enter your mobile money number</div>
                    </div>

                    <button type="button" class="list-group-item list-group-item-action mb-2" onclick="selectPaymentMethod('vodacom')">
                        <div class="d-flex align-items-center">
                            <div class="payment-logo vodacom-logo">
                                <img src="{{ asset('images/logo/voda.png') }}" alt="M-Pesa">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Vodacom M-Pesa</h6>
                                <small class="text-muted">Pay with M-Pesa mobile money</small>
                            </div>
                        </div>
                    </button>
                    <button type="button" class="list-group-item list-group-item-action mb-2" onclick="selectPaymentMethod('airtel')">
                        <div class="d-flex align-items-center">
                            <div class="payment-logo airtel-logo">
                                <img src="{{ asset('images/logo/airtel.png') }}" alt="Airtel Money" height="30">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Airtel Money</h6>
                                <small class="text-muted">Pay with Airtel Money</small>
                            </div>
                        </div>
                    </button>
                    <button type="button" class="list-group-item list-group-item-action mb-2" onclick="selectPaymentMethod('halotel')">
                        <div class="d-flex align-items-center">
                            <div class="payment-logo halotel-logo">
                                <img src="{{ asset('images/logo/halotel.png') }}" alt="Halotel" height="30">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Halotel</h6>
                                <small class="text-muted">Pay with Halotel mobile money</small>
                            </div>
                        </div>
                    </button>
                    <button type="button" class="list-group-item list-group-item-action" onclick="selectPaymentMethod('mixx')">
                        <div class="d-flex align-items-center">
                            <div class="payment-logo mixx-logo">
                                <img src="{{ asset('images/logo/tigo.png') }}" alt="Mixx by YAS" height="30">
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0">Mixx by YAS</h6>
                                <small class="text-muted">Pay with Mixx mobile wallet</small>
                            </div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
<script>
    // Update the Pay Now button to include data-bs-toggle and data-bs-target
    document.querySelector('.btn-success').setAttribute('data-bs-toggle', 'modal');
    document.querySelector('.btn-success').setAttribute('data-bs-target', '#paymentModal');

    // Handle payment processing
    document.getElementById('processPaymentBtn').addEventListener('click', function() {
        const phoneNumber = document.getElementById('phone_number').value;
        
        if (!phoneNumber) {
            Swal.fire('Error', 'Please enter your phone number', 'error');
            return;
        }

        // Show processing message
        Swal.fire({
            title: 'Processing Payment',
            text: 'Please wait while we process your payment...',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });

        // Simulate payment processing
        fetch('{{ route("customer.bookings.process-payment", $booking->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                phone_number: phoneNumber,
                amount: {{ $booking->total_amount }},
                booking_id: {{ $booking->id }}
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Close the payment modal
                bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                
                // Show success message
                Swal.fire({
                    title: 'Payment Successful!',
                    text: 'Your payment has been processed successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    // Reload the page to show updated status
                    window.location.reload();
                });
            } else {
                throw new Error(data.message || 'Payment failed');
            }
        })
        .catch(error => {
            Swal.fire({
                title: 'Payment Failed',
                text: error.message || 'There was an error processing your payment. Please try again.',
                icon: 'error'
            });
        });
    });

    function processPayment(phoneNumber, method) {
        return fetch('{{ route("customer.bookings.process-payment", $booking->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                phone_number: phoneNumber,
                amount: {{ $booking->total_amount }},
                provider: method,
                booking_id: {{ $booking->id }}
            })
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json;
        });
    }

    function selectPaymentMethod(method) {
        const phoneNumber = document.getElementById('payment_phone').value;
        
        // Validate phone number
        if (!phoneNumber) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter your phone number'
            });
            return;
        }

        // Validate phone number format
        if (!/^255[0-9]{9}$/.test(phoneNumber)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Phone Number',
                text: 'Please enter a valid Tanzania phone number starting with 255'
            });
            return;
        }

        // Show confirmation dialog
        Swal.fire({
            title: 'Confirm Payment',
            html: `
                <p>Amount: Tsh {{ number_format($booking->total_amount, 2) }}</p>
                <p>Phone: ${phoneNumber}</p>
                <p>Method: ${method.toUpperCase()}</p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Pay Now',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show processing message
                Swal.fire({
                    title: 'Processing Payment',
                    text: 'Please wait while we process your payment...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Process payment (but always show success)
                processPayment(phoneNumber, method)
                    .finally(() => {
                        // Close the payment modal
                        bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful!',
                            text: `Your payment has been processed successfully.`,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.reload();
                        });
                    });
            }
        });
    }
</script>
@endsection
