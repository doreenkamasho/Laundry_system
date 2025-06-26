@extends('layouts.master')
@section('title') Customer Reviews @endsection

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Laundress @endslot
    @slot('title') Customer Reviews @endslot
@endcomponent

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">All Reviews</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Comment</th>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    {{-- <th>Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $review)
                                    <tr>
                                        <td>{{ $review->customer->name }}</td>
                                        <td>
                                            <div class="text-warning">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="ri-star-{{ $i <= $review->rating ? 'fill' : 'line' }}"></i>
                                                @endfor
                                            </div>
                                        </td>
                                        <td>{{ Str::limit($review->comment, 100) }}</td>
                                        <td>
                                            @if($review->booking)
                                                <a href="{{ route('laundress.orders.show', $review->booking) }}" 
                                                   class="link-primary">#{{ $review->booking->id }}</a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $review->is_published ? 'success' : 'warning' }}">
                                                {{ $review->is_published ? 'Published' : 'Pending' }}
                                            </span>
                                        </td>
                                        {{-- <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('laundress.reviews.show', $review) }}" 
                                                   class="btn btn-sm btn-soft-primary">
                                                    <i class="ri-eye-line align-middle"></i>
                                                </a>
                                                <form action="{{ route('laundress.reviews.publish', $review) }}" 
                                                      method="POST" 
                                                      class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-soft-{{ $review->is_published ? 'warning' : 'success' }}">
                                                        <i class="ri-{{ $review->is_published ? 'eye-off-line' : 'eye-line' }} align-middle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No reviews found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $reviews->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection