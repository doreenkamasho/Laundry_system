@extends('layouts.master')
@section('title') Payment @endsection

@section('css')
<style>
    .payment-option {
        cursor: pointer;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }

    .payment-option:hover {
        border-color: #556ee6;
        background-color: rgba(85, 110, 230, 0.05);
    }

    .payment-option.selected {
        border-color: #556ee6;
        background-color: rgba(85, 110, 230, 0.1);
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Order Summary Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div id="orderDetails">
                        <!-- Order details will be populated via JavaScript -->
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h5>Total Amount:</h5>
                        <h5 id="totalAmount">Tsh 0.00</h5>
                    </div>
                </div>
            </div>

            <!-- Payment Options Card -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Select Payment Method</h5>
                </div>
                <div class="card-body">
                    <div class="payment-option" onclick="selectPaymentMethod('mpesa')">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ri-smartphone-line fs-2 text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">M-Pesa</h5>
                                <p class="text-muted mb-0">Pay using your M-Pesa mobile money</p>
                            </div>
                        </div>
                    </div>

                    <div class="payment-option" onclick="selectPaymentMethod('cash')">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="ri-money-dollar-box-line fs-2 text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-1">Cash on Delivery</h5>
                                <p class="text-muted mb-0">Pay when your laundry is delivered</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="btn btn-primary btn-lg w-100" id="confirmPayment">
                            Confirm Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Retrieve booking data from session storage
    const bookingData = JSON.parse(sessionStorage.getItem('bookingData'));
    if (!bookingData) {
        // If there's no booking data, redirect back with the laundress ID
        const laundressId = sessionStorage.getItem('laundressId');
        if (laundressId) {
            window.location.href = '{{ url("customer/bookings/create") }}/' + laundressId;
        } else {
            window.location.href = '{{ route("customer.find-laundress") }}';
        }
        return;
    }

    // Display order details
    displayOrderDetails(bookingData);

    let selectedMethod = null;

    window.selectPaymentMethod = function(method) {
        selectedMethod = method;
        document.querySelectorAll('.payment-option').forEach(option => {
            option.classList.remove('selected');
        });
        document.querySelector(`.payment-option[onclick*="${method}"]`).classList.add('selected');
    }

    document.getElementById('confirmPayment').addEventListener('click', function() {
        if (!selectedMethod) {
            alert('Please select a payment method');
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('customer.bookings.store') }}';
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add booking data
        for (let key in bookingData) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = typeof bookingData[key] === 'object' 
                ? JSON.stringify(bookingData[key]) 
                : bookingData[key];
            form.appendChild(input);
        }

        // Add payment method
        const paymentInput = document.createElement('input');
        paymentInput.type = 'hidden';
        paymentInput.name = 'payment_method';
        paymentInput.value = selectedMethod;
        form.appendChild(paymentInput);

        document.body.appendChild(form);
        form.submit();
    });
});

function displayOrderDetails(bookingData) {
    const orderDetails = document.getElementById('orderDetails');
    const totalAmount = document.getElementById('totalAmount');
    
    let html = '<div class="mb-3">';
    
    // Display selected items
    bookingData.selected_items.forEach(item => {
        html += `
            <div class="d-flex justify-content-between mb-2">
                <span>${item.itemName}</span>
                <span>Tsh ${item.price.toFixed(2)}</span>
            </div>
        `;
    });

    // Display delivery options if selected
    if (bookingData.pickup_required) {
        html += `
            <div class="d-flex justify-content-between mb-2">
                <span>Pick-up Service</span>
                <span>Tsh 3,500.00</span>
            </div>
        `;
    }

    if (bookingData.delivery_required) {
        html += `
            <div class="d-flex justify-content-between mb-2">
                <span>Delivery Service</span>
                <span>Tsh 3,500.00</span>
            </div>
        `;
    }

    html += '</div>';
    orderDetails.innerHTML = html;
    totalAmount.textContent = `Tsh ${bookingData.total.toFixed(2)}`;
}
</script>
@endsection