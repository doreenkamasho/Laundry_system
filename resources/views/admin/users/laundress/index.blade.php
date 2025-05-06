@extends('layouts.master')
@section('title') Laundress Management @endsection
@section('css')
    <link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Admin @endslot
    @slot('title') Laundress Management @endslot
@endcomponent

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Laundress List</h4>
            <div class="page-title-right">
                <a href="{{ route('admin.laundress.create') }}" class="btn btn-primary">
                    <i class="las la-plus me-1"></i> Add Laundress
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0">
                <div class="d-flex align-items-center">
                    <h5 class="card-title mb-0 flex-grow-1">Laundress</h5>
                    <div class="d-flex gap-2">
                        <!-- Search -->
                        <div class="search-box">
                            <form action="{{ route('admin.laundress.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" 
                                        placeholder="Search name or email..." value="{{ request('search') }}">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="las la-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- Filter Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-soft-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="las la-filter me-1"></i> 
                                {{ request('status') ? ucfirst(request('status')) : 'All Status' }}
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item {{ !request('status') ? 'active' : '' }}" 
                                    href="{{ route('admin.laundress.index') }}">All</a>
                                <a class="dropdown-item {{ request('status') === 'active' ? 'active' : '' }}" 
                                    href="{{ route('admin.laundress.index', ['status' => 'active']) }}">Active</a>
                                <a class="dropdown-item {{ request('status') === 'inactive' ? 'active' : '' }}" 
                                    href="{{ route('admin.laundress.index', ['status' => 'inactive']) }}">Inactive</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-nowrap align-middle mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Joined Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laundresses as $laundress)
                            <tr>
                                <td>{{ $laundress->id }}</td>
                                <td>
                                    <div class="d-flex gap-2 align-items-center">
                                        @if($laundress->avatar)
                                            <img src="{{ \App\Helpers\AvatarHelper::getAvatarUrl($laundress->avatar) }}" 
                                                alt="{{ $laundress->name }}" 
                                                class="avatar-xs rounded-circle"
                                                onerror="this.onerror=null; this.src='{{ asset('build/images/users/default-avatar.png') }}'">
                                        @else
                                            <div class="avatar-xs">
                                                <span class="avatar-title rounded-circle bg-primary text-white text-uppercase">
                                                    {{ substr($laundress->name, 0, 1) }}
                                                </span>
                                            </div>
                                        @endif
                                        <span class="fw-medium">{{ $laundress->name }}</span>
                                    </div>
                                </td>
                                <td>{{ $laundress->email }}</td>
                                <td>{{ $laundress->laundressDetail->phone_number ?? '-' }}</td>
                                <td>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" class="form-check-input" 
                                            id="statusSwitch{{ $laundress->id }}"
                                            {{ $laundress->is_active ? 'checked' : '' }}
                                            data-id="{{ $laundress->id }}"
                                            onchange="updateStatus(this)">
                                    </div>
                                </td>
                                <td>{{ $laundress->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="hstack gap-2">
                                        <a href="{{ route('admin.laundress.show', $laundress->id) }}" 
                                            class="btn btn-sm btn-soft-info">
                                            <i class="las la-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.laundress.edit', $laundress->id) }}" 
                                            class="btn btn-sm btn-soft-warning">
                                            <i class="las la-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-soft-danger" 
                                            onclick="confirmDelete({{ $laundress->id }})">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No laundress found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    {{ $laundresses->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/sweetalert.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/pages/laundress.init.js') }}"></script>
@endsection