@extends('layouts.master')

@section('title') Earnings Overview @endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <div class="row">
                <!-- Total Earnings Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate bg-primary">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-uppercase fw-medium text-white-50 mb-0">Total Earnings</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary text-white mb-4">
                                        Tsh {{ number_format($totalEarnings, 2) }}
                                    </h4>
                                    <span class="text-white-50">
                                        {{ $totalOrders }} Total Orders
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Current Month Card -->
                <div class="col-xl-3 col-md-6">
                    <div class="card card-animate bg-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-uppercase fw-medium text-white-50 mb-0">This Month</p>
                                </div>
                            </div>
                            <div class="d-flex align-items-end justify-content-between mt-4">
                                <div>
                                    <h4 class="fs-22 fw-semibold ff-secondary text-white mb-4">
                                        Tsh {{ number_format($currentMonthEarnings->total_earnings ?? 0, 2) }}
                                    </h4>
                                    <span class="text-white-50">
                                        {{ $currentMonthEarnings->total_orders ?? 0 }} Orders
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Earnings Table -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Monthly Earnings</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Month</th>
                                    <th>Orders</th>
                                    <th>Total Earnings</th>
                                    <th>Average per Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($earnings as $earning)
                                    <tr>
                                        <td>{{ Carbon\Carbon::createFromFormat('Y-m', $earning->month)->format('F Y') }}</td>
                                        <td>{{ $earning->total_orders }}</td>
                                        <td>Tsh {{ number_format($earning->total_earnings, 2) }}</td>
                                        <td>Tsh {{ number_format($earning->total_orders > 0 ? $earning->total_earnings / $earning->total_orders : 0, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">No earnings data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection