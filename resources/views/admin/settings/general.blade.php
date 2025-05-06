@extends('layouts.master')
@section('title') General Settings @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">General Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.general.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Site Name</label>
                            <input type="text" class="form-control" name="site_name" 
                                   value="{{ setting('site_name', config('app.name')) }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Email</label>
                            <input type="email" class="form-control" name="contact_email" 
                                   value="{{ setting('contact_email') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Contact Phone</label>
                            <input type="text" class="form-control" name="contact_phone" 
                                   value="{{ setting('contact_phone') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection