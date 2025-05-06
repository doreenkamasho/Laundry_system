@extends('layouts.master')

@section('title') My Bookings @endsection

@section('css')
<style>
    .status-badge {
        min-width: 100px;
        text-align: center;
    }
    
    /* Custom badge colors */
    .bg-purple {
        background-color: #6f42c1 !important;
        color: #fff;
    }
    
    .bg-indigo {
        background-color: #4263eb !important;
        color: #fff;
    }
    
    /* If you're using dark theme, adjust hover states */
    .bg-purple:hover {
        background-color: #5e35b1 !important;
    }
    
    .bg-indigo:hover {
        background-color: #364fc7 !important;
    }
</style>
<link href="{{ asset('css/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">My Bookings</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($bookings->isEmpty())
                        <div class="text-center p-4">
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-light rounded-circle text-primary display-5">
                                    <i class="las la-calendar-times"></i>
                                </div>
                            </div>
                            <h4>No Bookings Found</h4>
                            <p class="text-muted">You haven't made any bookings yet.</p>
                            <a href="{{ route('customer.find-laundress') }}" class="btn btn-primary">Find a Laundress</a>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">Booking ID</th>
                                        <th scope="col">Service</th>
                                        <th scope="col">Laundress</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Payment</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>#{{ $booking->id }}</td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>{{ $booking->laundress->name }}</td>
                                        <td>
                                            @if($booking->scheduled_date)
                                                {{ \Carbon\Carbon::parse($booking->scheduled_date)->format('M d, Y') }}<br>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($booking->scheduled_time)->format('g:i A') }}
                                                </small>
                                            @else
                                                <span class="text-muted">Not scheduled</span>
                                            @endif
                                        </td>
                                        <td>Tsh {{ number_format($booking->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge status-badge bg-{{ 
                                                $booking->status === 'pending' ? 'warning' : 
                                                ($booking->status === 'confirmed' ? 'info' :
                                                ($booking->status === 'washing' ? 'primary' :
                                                ($booking->status === 'drying' ? 'secondary' :
                                                ($booking->status === 'ironing' ? 'purple' :
                                                ($booking->status === 'packaging' ? 'indigo' :
                                                ($booking->status === 'completed' ? 'success' : 'danger'))))))
                                            }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge status-badge bg-{{ $booking->payment_status === 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('customer.bookings.show', $booking) }}" 
                                                   class="btn btn-soft-primary btn-sm" 
                                                   data-bs-toggle="tooltip" 
                                                   title="View Details">
                                                    <i class="ri-eye-fill"></i>
                                                </a>

                                                @if($booking->status === 'pending' && $booking->payment_status !== 'paid')
                                                    <a href="#" 
                                                       class="btn btn-soft-success btn-sm"
                                                       data-bs-toggle="tooltip"
                                                       title="Pay Now">
                                                        <i class="ri-money-dollar-circle-fill"></i>
                                                    </a>
                                                @endif

                                                @if($booking->status === 'pending')
                                                    <button type="button"
                                                            class="btn btn-soft-danger btn-sm"
                                                            onclick="confirmCancel({{ $booking->id }})"
                                                            data-bs-toggle="tooltip"
                                                            title="Cancel Booking">
                                                        <i class="ri-close-circle-fill"></i>
                                                    </button>

                                                    <form id="cancel-form-{{ $booking->id }}" 
                                                          action="{{ route('customer.bookings.cancel', $booking) }}" 
                                                          method="POST" class="d-none">
                                                        @csrf
                                                        @method('PATCH')
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-3">
                            {{ $bookings->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    function confirmCancel(bookingId) {
        Swal.fire({
            title: 'Cancel Booking?',
            text: 'Are you sure you want to cancel this booking? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-light ms-1'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancel-form-' + bookingId).submit();
            }
        });
    }
</script>
@endsection