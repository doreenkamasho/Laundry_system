@extends('layouts.master')
@section('title') New Booking @endsection

@section('css')
<style>
    .service-item {
        transition: all 0.3s ease;
    }
    .service-item:hover {
        background-color: #f8f9fa;
    }
    .price-item {
        cursor: pointer;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        margin-bottom: 8px;
        background-color: #ffffff;
    }
    .price-item:hover {
        background-color: #f8f9fa;
        border-color: #556ee6;
    }
    .price-item.selected {
        border-color: #556ee6;
        background-color: rgba(85, 110, 230, 0.1);
    }
    .badge.bg-soft-primary {
        background-color: #556ee6 !important;
        color: #ffffff !important;
    }
    .price-badge {
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 4px;
    }
    .form-check-label {
        color: #495057;
        font-weight: 500;
    }
    .list-group-item {
        border-radius: 8px !important;
        margin-bottom: 10px;
        transition: all 0.3s ease;
    }
    .list-group-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .list-group-item:active {
        transform: translateY(0);
    }
    .swal2-popup {
        border-radius: 12px;
    }
    
    /* Payment method styles */
    .payment-logo {
        width: 50px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
        border-radius: 4px;
        overflow: hidden;
    }
    
    .payment-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }
    
    /* Provider specific styles */
    .vodacom-logo { background-color: #e60000; }
    .airtel-logo { background-color: #fff; }
    .halotel-logo { background-color: #ff5722; }
    .mixx-logo { background-color: #ffdd00; }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <form id="bookingForm" action="{{ route('customer.bookings.store') }}" method="POST">
        @csrf
        <input type="hidden" name="laundress_id" value="{{ $laundress->id }}">
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Service Categories -->
                <div class="card mb-4">
                    <div class="card-header">
                        <ul class="nav nav-tabs card-header-tabs">
                            @foreach($servicesByCategory as $category => $services)
                            <li class="nav-item">
                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                   data-bs-toggle="tab" 
                                   href="#category-{{ Str::slug($category) }}">
                                    <i class="{{ $services->first()->category_icon }}"></i>
                                    {{ $category }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            @foreach($servicesByCategory as $category => $services)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="category-{{ Str::slug($category) }}">
                                @foreach($services as $service)
                                <div class="service-item mb-4">
                                    <h6 class="mb-3">{{ $service->name }}</h6>
                                    <div class="row">
                                        @foreach($service->price_structure as $item)
                                        <div class="col-md-6">
                                            <div class="price-item" 
                                                 onclick="selectPrice(this, '{{ $service->id }}', '{{ $item['item'] }}', {{ $item['price'] }})">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <div class="form-check">
                                                            <input type="checkbox" 
                                                                   class="form-check-input"
                                                                   name="selected_items[{{ $service->id }}][]" 
                                                                   value="{{ $item['item'] }}"
                                                                   data-price="{{ $item['price'] }}">
                                                            <label class="form-check-label">
                                                                {{ $item['item'] }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <span class="badge bg-soft-primary price-badge">
                                                        Tsh {{ number_format($item['price'], 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Schedule -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Schedule</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Select Day</label>
                                    <select class="form-select" name="scheduled_date" required>
                                        <option value="">Choose a day...</option>
                                        @foreach($availableDays as $day)
                                            <option value="{{ $day }}">{{ ucfirst($day) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Time</label>
                                    <input type="time" class="form-control" name="scheduled_time" 
                                           value="08:00" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div id="selectedItems" class="mb-3">
                            <!-- Selected items will appear here -->
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="subtotal">Tsh 0.00</span>
                        </div>
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="pickup_required" 
                                   name="pickup_required" value="1">
                            <label class="form-check-label" for="pickup_required">
                                Pick-up Service (Tsh{{ number_format($pickup_fee, 2) }})
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" id="delivery_required" 
                                   name="delivery_required" value="1">
                            <label class="form-check-label" for="delivery_required">
                                Delivery Service (Tsh{{ number_format($delivery_fee, 2) }})
                            </label>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total:</strong>
                            <strong id="total">Tsh 0.00</strong>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg w-100" onclick="proceedToPaymentPage()">
                            Proceed to Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
let selectedPrices = new Map();

function selectPrice(element, serviceId, itemName, price) {
    const checkbox = element.querySelector('input[type="checkbox"]');
    checkbox.checked = !checkbox.checked;
    
    const key = `${serviceId}-${itemName}`;
    if (checkbox.checked) {
        selectedPrices.set(key, { 
            serviceId: serviceId, // Make sure serviceId is properly set
            itemName: itemName, 
            price: price 
        });
        element.querySelector('.price-badge').classList.add('bg-success');
    } else {
        selectedPrices.delete(key);
        element.querySelector('.price-badge').classList.remove('bg-success');
    }
    
    element.classList.toggle('selected', checkbox.checked);
    updateOrderSummary();
}

function updateOrderSummary() {
    let summary = '';
    let subtotal = 0;
    
    for (let [key, item] of selectedPrices) {
        summary += `
            <div class="d-flex justify-content-between mb-2">
                <span>${item.itemName}</span>
                <span>Tsh ${parseFloat(item.price).toFixed(2)}</span>
            </div>
        `;
        subtotal += parseFloat(item.price);
    }
    
    document.getElementById('selectedItems').innerHTML = summary;
    document.getElementById('subtotal').textContent = `Tsh ${subtotal.toFixed(2)}`;
    
    // Calculate total with pickup/delivery fees
    calculateTotal();
}

function calculateTotal() {
    let subtotal = 0;
    for (let item of selectedPrices.values()) {
        subtotal += parseFloat(item.price);
    }
    
    const pickupFee = document.getElementById('pickup_required').checked ? {{ $pickup_fee }} : 0;
    const deliveryFee = document.getElementById('delivery_required').checked ? {{ $delivery_fee }} : 0;
    
    const total = subtotal + pickupFee + deliveryFee;
    
    // Update the display
    document.getElementById('subtotal').textContent = `Tsh ${subtotal.toFixed(2)}`;
    document.getElementById('total').textContent = `Tsh ${total.toFixed(2)}`;
    
    return {
        subtotal: subtotal,
        pickupFee: pickupFee,
        deliveryFee: deliveryFee,
        total: total
    };
}

// Add event listeners for pickup and delivery checkboxes
document.addEventListener('DOMContentLoaded', function() {
    ['pickup_required', 'delivery_required'].forEach(id => {
        document.getElementById(id).addEventListener('change', function() {
            calculateTotal();
        });
    });
});

function proceedToPaymentPage() {
    // Validate if any items are selected
    if (selectedPrices.size === 0) {
        Swal.fire({
            title: 'Error!',
            text: 'Please select at least one service item',
            icon: 'error'
        });
        return;
    }

    // Get form data
    const form = document.getElementById('bookingForm');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const totals = calculateTotal();
    
    // Get the first selected item's service ID
    const firstSelectedItem = selectedPrices.values().next().value;
    
    // Store booking data
    const bookingData = {
        laundress_id: '{{ $laundress->id }}',
        service_id: firstSelectedItem.serviceId,
        selected_items: Array.from(selectedPrices.values()),
        scheduled_date: form.scheduled_date.value,
        scheduled_time: form.scheduled_time.value,
        pickup_required: form.pickup_required.checked,
        delivery_required: form.delivery_required.checked,
        pickup_fee: totals.pickupFee,
        delivery_fee: totals.deliveryFee,
        total_amount: totals.total
    };
    
    sessionStorage.setItem('bookingData', JSON.stringify(bookingData));

    // Show payment method selection modal
    Swal.fire({
        title: 'Select Payment Method',
        html: `
            <div class="list-group payment-options">
                <button type="button" class="list-group-item list-group-item-action mb-2" onclick="selectPaymentMethod('vodacom')">
                    <div class="d-flex align-items-center">
                        <div class="payment-logo vodacom-logo">
                            <img src="{{ asset('images/logo/voda.png') }}" alt="M-Pesa" height="30" onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Vodacom_logo.svg/320px-Vodacom_logo.svg.png';">
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
                            <img src="{{ asset('images/logo/airtel.png') }}" alt="Airtel Money" height="30" onerror="this.onerror=null; this.src='https://upload.wikimedia.org/wikipedia/commons/thumb/7/72/Airtel_logo.svg/320px-Airtel_logo.svg.png';">
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
                            <img src="{{ asset('images/logo/halotel.png') }}" alt="Halotel" height="30" onerror="this.onerror=null; this.src='https://www.halotel.co.tz/assets/images/logo.png';">
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
                            <img src="{{ asset('images/logo/tigo.png') }}" alt="Mixx by YAS" height="30" onerror="this.onerror=null; this.src='https://vas.tzvas.com/tz/media/logos/mixx_logo.png';">
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0">Mixx by YAS</h6>
                            <small class="text-muted">Pay with Mixx mobile wallet</small>
                        </div>
                    </div>
                </button>
            </div>
        `,
        showCancelButton: true,
        showConfirmButton: false,
        cancelButtonText: 'Close',
        width: '400px',
        didOpen: () => {
            // Add CSS styles to handle image display
            const style = document.createElement('style');
            style.textContent = `
                .payment-options .payment-logo {
                    width: 50px;
                    height: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .payment-options .payment-logo img {
                    max-width: 100%;
                    max-height: 100%;
                    object-fit: contain;
                }
                .vodacom-logo { background-color: #e60000; border-radius: 4px; padding: 3px; }
                .airtel-logo { background-color: #fff; border-radius: 4px; padding: 3px; }
                .halotel-logo { background-color: #ff5722; border-radius: 4px; padding: 3px; }
                .mixx-logo { background-color: #ffdd00; border-radius: 4px; padding: 3px; }
            `;
            document.head.appendChild(style);
        }
    });
}

function processPayment(phoneNumber, method) {
    const bookingData = JSON.parse(sessionStorage.getItem('bookingData'));
    
    // Ensure pickup and delivery values are properly set as booleans
    bookingData.pickup_required = !!bookingData.pickup_required;
    bookingData.delivery_required = !!bookingData.delivery_required;
    
    return fetch('{{ route("customer.payment.process") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            phone_number: phoneNumber,
            amount: bookingData.total_amount,
            provider: method,
            booking_data: bookingData
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    });
}

function selectPaymentMethod(method) {
    const bookingData = JSON.parse(sessionStorage.getItem('bookingData'));
    
    Swal.fire({
        title: `Enter ${method.toUpperCase()} Number`,
        input: 'tel',
        inputLabel: 'Enter your phone number',
        inputPlaceholder: '255XXXXXXXXX',
        showCancelButton: true,
        confirmButtonText: 'Pay Now',
        inputValidator: (value) => {
            if (!value) {
                return 'Phone number is required!';
            }
            if (!/^255[0-9]{9}$/.test(value)) {
                return 'Please enter a valid Tanzania phone number';
            }
        },
        preConfirm: (phoneNumber) => {
            Swal.showLoading();
            return processPayment(phoneNumber, method)
                .catch(error => {
                    Swal.showValidationMessage(error.message);
                    throw error;
                });
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Clear booking data from session
            sessionStorage.removeItem('bookingData');
            
            Swal.fire({
                icon: 'success',
                title: 'Payment Successful!',
                text: `Transaction Reference: ${result.value.transaction}`,
                confirmButtonText: 'View Booking'
            }).then(() => {
                window.location.href = `{{ route('customer.bookings.show', '') }}/${result.value.booking_id}`;
            });
        }
    }).catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Payment Failed',
            text: error.message
        });
    });
}
</script>
@endsection