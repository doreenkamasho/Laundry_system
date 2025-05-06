@extends('layouts.master')
@section('title') Booking Details @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Booking #{{ $booking->id }}</h4>
                    <div>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Back to List</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Customer Details</h5>
                            <table class="table">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $booking->customer->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $booking->customer->email }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Laundress Details</h5>
                            <table class="table">
                                <tr>
                                    <th>Name:</th>
                                    <td>{{ $booking->laundress->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td>{{ $booking->laundress->email }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Booking Details</h5>
                            <table class="table">
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @php
                                            $statusColor = match($booking->status) {
                                                'pending' => 'warning',
                                                'confirmed', 'completed' => 'success',
                                                'cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created At:</th>
                                    <td>{{ $booking->created_at->format('M d, Y H:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Transaction Details</h5>
                            <table class="table">
                                <tr>
                                    <th>Amount:</th>
                                    <td>Tsh{{ number_format($booking->transaction->amount ?? 0, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <td>
                                        @php
                                            $transactionStatus = $booking->transaction->status ?? 'N/A';
                                            $statusColor = match(strtolower($transactionStatus)) {
                                                'pending' => 'warning',
                                                'successful', 'completed' => 'success',
                                                'failed', 'cancelled' => 'danger',
                                                default => 'secondary'
                                            };
                                        @endphp
                                        <span class="badge bg-{{ $statusColor }}">
                                            {{ ucfirst($transactionStatus) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Update Status</h5>
                            <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select d-inline-block w-auto">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="btn btn-primary ms-2">Update Status</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection