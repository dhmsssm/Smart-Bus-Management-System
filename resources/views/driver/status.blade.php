@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-check-circle-fill text-success me-2"></i>
                Bus Status
            </h2>
            <p class="text-muted mb-0">Update your assigned bus duty status.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card-box p-4 h-100">
                <h5 class="fw-bold mb-4">Current Status</h5>

                @if($bus)
                    <div class="d-flex justify-content-between border-bottom py-3">
                        <span class="text-muted">Bus</span>
                        <strong>{{ $bus->bus_number }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-3">
                        <span class="text-muted">Duty Status</span>
                        <span class="badge bg-success">{{ ucfirst($bus->status) }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-3">
                        <span class="text-muted">Running Status</span>
                        <strong>{{ $location->status ?? 'Not updated' }}</strong>
                    </div>
                @else
                    <p class="text-muted mb-0">No bus is assigned to your account.</p>
                @endif
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card-box p-4">
                <h5 class="fw-bold mb-4">Update Duty Status</h5>

                @if($bus)
                    <form method="POST" action="/driver/status">
                        @csrf

                        <label class="form-label">Bus Status</label>
                        <select class="form-select mb-4" name="status">
                            <option value="active" {{ $bus->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="maintenance" {{ $bus->status === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="inactive" {{ $bus->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>

                        <button class="btn btn-success">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Save Status
                        </button>
                    </form>
                @else
                    <p class="text-muted mb-0">Status update is disabled until a bus is assigned.</p>
                @endif
            </div>
        </div>
    </div>

</div>

@endsection
