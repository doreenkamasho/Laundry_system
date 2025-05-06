@extends('layouts.master')

@section('title') Payment History @endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Payment History</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Service</th>
                                    <th>Transaction Date</th>
                                    <th>Amount</th>
                                    <th>Reference</th>
                                    <th>Provider</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td>#{{ $booking->id }}</td>
                                        <td>{{ $booking->customer->name }}</td>
                                        <td>{{ $booking->service->name }}</td>
                                        <td>{{ $booking->transaction->created_at->format('M d, Y g:i A') }}</td>
                                        <td>Tsh {{ number_format($booking->total_amount, 2) }}</td>
                                        <td>{{ $booking->transaction->reference }}</td>
                                        <td>{{ ucfirst($booking->transaction->provider) }}</td>
                                        <td>
                                            <span class="badge bg-success">Completed</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('laundress.orders.show', $booking) }}" 
                                               class="btn btn-sm btn-soft-primary">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No transaction history available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection