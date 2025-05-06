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
                                                @foreach($booking->selected_items as $item)
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
                            
                            <!-- @if($booking->payment_status !== 'paid')
                                <button type="button" class="btn btn-success ms-1">
                                    <i class="ri-bank-card-line align-bottom me-1"></i> Pay Now
                                </button>
                            @endif -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
