@extends('layouts.master')

@section('title', 'Edit Service')

@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    /* Card styling */
    .card {
        border-radius: 15px;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        border: none;
    }
    
    .card-body {
        padding: 2rem;
    }

    /* Form controls */
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.6rem 1rem;
        border-color: #e9ecef;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #556ee6;
        box-shadow: 0 0 0 0.2rem rgba(85, 110, 230, 0.1);
    }

    .input-group-text {
        border-radius: 8px 0 0 8px;
        background-color: #f8f9fa;
        border-color: #e9ecef;
    }

    /* Price structure items */
    .price-item {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 10px;
        margin-bottom: 1rem !important;
        transition: all 0.3s ease;
        animation: slideIn 0.3s ease-out;
    }

    .price-item:hover {
        background-color: #fff;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }

    /* Form labels */
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-label.required::after {
        content: '*';
        color: #f46a6a;
        margin-left: 4px;
    }

    /* Switch styling */
    .form-switch {
        padding-left: 3rem;
    }

    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.5em;
        margin-left: -3rem;
    }

    .form-check-input:checked {
        background-color: #34c38f;
        border-color: #34c38f;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Edit Service</h4>
                <div class="page-title-right">
                    <a href="{{ route('laundress.services.index') }}" class="btn btn-secondary">
                        <i class="las la-arrow-left me-1"></i> Back to Services
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('laundress.services.update', $service->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="category_name" class="form-label required">Service Category</label>
                                <input type="text" class="form-control" value="{{ $service->category_name }}" disabled>
                                <input type="hidden" name="category_name" value="{{ $service->category_name }}">
                                <input type="hidden" name="category_icon" value="{{ $service->category_icon }}">
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label required">Service Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $service->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3">{{ old('description', $service->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label required">Price Structure</label>
                            <div id="price-items-container">
                                @foreach($service->price_structure as $index => $item)
                                <div class="row mb-2 price-item">
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" 
                                               name="price_structure[{{ $index }}][item]" 
                                               value="{{ $item['item'] }}" required>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="number" step="0.01" class="form-control" 
                                                   name="price_structure[{{ $index }}][price]" 
                                                   value="{{ $item['price'] }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger remove-price-item" 
                                                {{ $index === 0 ? 'disabled' : '' }}>
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" id="add-price-item" class="btn btn-success mt-2">
                                <i class="las la-plus"></i> Add Item
                            </button>
                        </div>

                        <div class="mb-3 form-check form-switch">
                            <input class="form-check-input" type="checkbox" 
                                   id="is_active" 
                                   name="is_active" 
                                   {{ $service->is_active ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Service</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('price-items-container');
    const addButton = document.getElementById('add-price-item');
    let itemCount = container.children.length;

    addButton.addEventListener('click', function() {
        const newItem = document.createElement('div');
        newItem.className = 'row mb-2 price-item';
        newItem.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control" name="price_structure[${itemCount}][item]" required>
            </div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="number" step="0.01" class="form-control" name="price_structure[${itemCount}][price]" required>
                </div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-price-item">Remove</button>
            </div>
        `;
        container.appendChild(newItem);
        itemCount++;
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-price-item')) {
            e.target.closest('.price-item').remove();
        }
    });
});
</script>
@endsection