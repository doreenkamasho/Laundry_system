@extends('layouts.master')
@section('title') Customers @endsection
@section('content')

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Customers List</h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Customers</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        @if($customer->avatar)
                                            <img src="{{ asset('storage/'.$customer->avatar) }}" alt="" class="avatar-xs rounded-circle">
                                        @else
                                            <div class="avatar-xs">
                                                <span class="avatar-title rounded-circle bg-primary text-white">
                                                    {{ substr($customer->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        {{ $customer->name }}
                                    </div>
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    <span class="badge bg-{{ $customer->is_active ? 'success' : 'danger' }}">
                                        {{ $customer->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $customer->created_at->format('d M, Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="#" class="btn btn-sm btn-soft-primary">View</a>
                                        <a href="#" class="btn btn-sm btn-soft-warning">Edit</a>
                                        <button type="button" class="btn btn-sm btn-soft-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">No customers found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $customers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection