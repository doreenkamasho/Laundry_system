@extends('layouts.master')
@section('title') System Settings @endsection
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">System Settings</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.settings.system.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="maintenance_mode" 
                                       value="1" {{ setting('maintenance_mode') ? 'checked' : '' }}>
                                <label class="form-check-label">Maintenance Mode</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Default Currency</label>
                            <select name="default_currency" class="form-select">
                                <option value="USD" {{ setting('default_currency') == 'USD' ? 'selected' : '' }}>USD</option>
                                <option value="EUR" {{ setting('default_currency') == 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="GBP" {{ setting('default_currency') == 'GBP' ? 'selected' : '' }}>GBP</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Timezone</label>
                            <select name="timezone" class="form-select">
                                @foreach(timezone_identifiers_list() as $timezone)
                                    <option value="{{ $timezone }}" 
                                            {{ setting('timezone', config('app.timezone')) == $timezone ? 'selected' : '' }}>
                                        {{ $timezone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection