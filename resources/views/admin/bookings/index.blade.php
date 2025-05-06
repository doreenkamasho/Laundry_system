@extends('layouts.master')
@section('title') Customers @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Bookings</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Laundress</th>
                                    <th>Status</th>
                                    <th>Transaction Amount</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->customer->name }}</td>
                                    <td>{{ $booking->laundress->name }}</td>
                                    <td>
                                        @php
                                            $statusColor = match($booking->status) {
                                                'pending' => 'warning',
                                                'completed' => 'success',
                                                'cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge rounded-pill fs-12 fw-medium bg-{{ $statusColor }} bg-opacity-10 text-{{ $statusColor }}">
                                            <i class="mdi mdi-circle-medium me-1"></i>
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>Tsh{{ number_format($booking->transaction->amount ?? 0, 2) }}</td>
                                    <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show', $booking) }}" 
                                           class="btn btn-sm btn-info">
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection