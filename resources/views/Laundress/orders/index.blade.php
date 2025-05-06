@extends('layouts.master')

@section('title') 
    {{ ucfirst($status) }} Orders
@endsection

@section('css')
<link href="{{ asset('css/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">{{ ucfirst($status) }} Orders</h4>
                </div>
                <div class="card-body">
                    @if($orders->isEmpty())
                        <div class="text-center py-4">
                            <div class="avatar-md mx-auto mb-4">
                                <div class="avatar-title bg-light rounded-circle text-primary">
                                    <i class="las la-shopping-cart fs-24"></i>
                                </div>
                            </div>
                            <h5 class="mb-2">No {{ strtolower($status) }} orders found</h5>
                            <p class="text-muted">When you receive new orders, they will appear here.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Customer</th>
                                        <th>Service</th>
                                        <th>Schedule</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->customer->name ?? 'N/A' }}</td>
                                        <td>{{ optional($order->service)->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($order->scheduled_date)
                                                {{ \Carbon\Carbon::parse($order->scheduled_date)->format('M d, Y') }}<br>
                                                <small class="text-muted">{{ \Carbon\Carbon::parse($order->scheduled_time)->format('g:i A') }}</small>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>Tsh {{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ 
                                                $order->status === 'pending' ? 'warning' : 
                                                ($order->status === 'completed' ? 'success' : 'info') 
                                            }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('laundress.orders.show', $order) }}" 
                                                   class="btn btn-sm btn-soft-primary">
                                                    View
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-3">
                            {{ $orders->links() }}
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
    function updateStatus(orderId, status) {
        Swal.fire({
            title: 'Accept Order?',
            text: 'Are you sure you want to accept this order?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, accept it!',
            cancelButtonText: 'No, not now',
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-light ms-1'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('status-form-' + orderId).submit();
            }
        });
    }
</script>
@endsection