@extends('layouts.master')
@section('title') New Booking @endsection

@php
    if (!auth()->check()) {
        return redirect()->route('login');
    }
@endphp

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
        <input type="hidden" name="customer_id" value="{{ auth()->id() }}">
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
                                            <option value="{{ strtolower($day) }}">{{ ucfirst($day) }}</option>
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
                        
                        <button type="button" class="btn btn-primary btn-lg w-100" onclick="submitOrder()">
                            <i class="ri-send-plane-line align-middle me-1"></i>
                            Submit Order Request
                        </button>
                        
                        <div class="mt-3 text-center text-muted small">
                            <i class="ri-information-line me-1"></i>
                            Payment will be required after the laundress accepts your order
                        </div>
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

function submitOrder() {
    // Validate if any items are selected
    if (selectedPrices.size === 0) {
        Swal.fire({
            title: 'Error!',
            text: 'Please select at least one service item',
            icon: 'error'
        });
        return;
    }

    // Get form data and validate date
    const form = document.getElementById('bookingForm');
    const selectedDate = form.scheduled_date.value;
    
    // Format the date to YYYY-MM-DD
    const today = new Date();
    const formattedDate = new Date(today.getFullYear(), today.getMonth(), today.getDate() + getDayOffset(selectedDate))
        .toISOString().split('T')[0];

    const totals = calculateTotal();
    const firstSelectedItem = selectedPrices.values().next().value;
    
    // Store booking data with all required fields
    const bookingData = {
        customer_id: {{ auth()->id() }},
        laundress_id: {{ $laundress->id }},
        service_id: firstSelectedItem.serviceId,
        selected_items: Array.from(selectedPrices.values()),
        scheduled_date: formattedDate,
        scheduled_time: form.scheduled_time.value,
        pickup_required: form.pickup_required.checked,
        delivery_required: form.delivery_required.checked,
        pickup_fee: totals.pickupFee,
        delivery_fee: totals.deliveryFee,
        total_amount: totals.total,
        payment_status: 'pending'
    };

    // Show confirmation dialog
    Swal.fire({
        title: 'Confirm Order',
        html: `
            <p>Total Amount: Tsh ${totals.total.toFixed(2)}</p>
            <p class="text-muted small">You can pay after the laundress accepts your order.</p>
        `,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Submit Order',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form directly
            submitBookingData(bookingData);
        }
    });
}

function submitBookingData(bookingData) {
    // Submit booking data to server
    fetch('{{ route("customer.bookings.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(bookingData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Order Submitted Successfully!',
                text: 'You will be notified when the laundress accepts your order.',
                confirmButtonText: 'View Booking'
            }).then(() => {
                window.location.href = `{{ route('customer.bookings.show', '') }}/${data.booking_id}`;
            });
        } else {
            throw new Error(data.message || 'Failed to submit order');
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Order Submission Failed',
            text: error.message
        });
    });
}

// Add this helper function to calculate day offset
function getDayOffset(dayName) {
    const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
    const today = new Date().getDay();
    const targetDay = days.indexOf(dayName.toLowerCase());
    
    if (targetDay === -1) return 0;
    
    let offset = targetDay - today;
    if (offset <= 0) {
        offset += 7; // Move to next week if day has passed
    }
    
    return offset;
}
</script>
@endsection