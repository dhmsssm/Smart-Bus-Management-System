@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">
            <i class="bi bi-person-badge-fill text-success me-2"></i>My Profile
        </h3>
        <a href="/driver/dashboard" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #198754 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill text-success fs-5 me-2"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #dc3545 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-5 me-2"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #dc3545 !important;">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-5 me-2 mt-1"></i>
                <div>
                    <span class="fw-bold">Please check the details below:</span>
                    <ul class="mb-0 mt-2 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Driver Details Card -->
        <div class="col-lg-6">
            <div class="card-box p-4 h-100">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-pencil-square text-success me-2"></i>Driver Details
                </h5>

                <form method="POST" action="/driver/profile" autocomplete="off">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Full Name</label>
                            <input type="text" class="form-control form-control-lg border-2" name="name" value="{{ old('name', $driver->name) }}" required style="font-size: 15px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Email Address</label>
                            <input type="email" class="form-control form-control-lg border-2" name="email" value="{{ old('email', $driver->email) }}" required style="font-size: 15px;">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Phone Number</label>
                            <input type="text" class="form-control form-control-lg border-2" name="phone" value="{{ old('phone', $driver->phone) }}" style="font-size: 15px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">License Number</label>
                            <input type="text" class="form-control form-control-lg border-2" name="license_no" value="{{ old('license_no', $driverProfile->license_no ?? '') }}" required style="font-size: 15px;">
                        </div>
                    </div>

                    <div class="card bg-light border-0 p-3 mb-4 rounded-3">
                        <h6 class="fw-bold mb-2 text-dark">
                            <i class="bi bi-shield-lock-fill text-warning me-1"></i>Security Settings
                        </h6>
                        <p class="text-muted small mb-3">Leave password fields blank if you do not want to change your current password.</p>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">New Password</label>
                                <input type="password" class="form-control border-2" name="password" placeholder="Min. 6 characters" style="font-size: 14px;">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Confirm New Password</label>
                                <input type="password" class="form-control border-2" name="password_confirmation" placeholder="Retype password" style="font-size: 14px;">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success btn-lg px-4" style="font-size: 16px; font-weight: 500;">
                            <i class="bi bi-check-circle-fill me-2"></i>Update Driver Details
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Assigned Bus Details Card -->
        <div class="col-lg-6">
            <div class="card-box p-4 h-100">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-bus-front text-success me-2"></i>Assigned Bus Details
                </h5>

                @if($bus)
                    <form method="POST" action="/driver/bus-details">
                        @csrf

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Bus Number</label>
                                <input type="text" class="form-control form-control-lg border-2" name="bus_number" value="{{ old('bus_number', $bus->bus_number) }}" required style="font-size: 15px;">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Capacity (Seats)</label>
                                <input type="number" class="form-control form-control-lg border-2" name="capacity" min="1" max="120" value="{{ old('capacity', $bus->capacity) }}" required style="font-size: 15px;">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Departure Time</label>
                                <input type="time" class="form-control form-control-lg border-2" name="departure_time" value="{{ old('departure_time', $bus->departure_time) }}" style="font-size: 15px;">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary">Bus Status</label>
                                <select class="form-select form-select-lg border-2" name="status" required style="font-size: 15px;">
                                    <option value="active" {{ old('status', $bus->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="maintenance" {{ old('status', $bus->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="inactive" {{ old('status', $bus->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Assigned Route</label>
                            <div class="p-3 bg-light rounded border border-2 d-flex align-items-center">
                                <i class="bi bi-signpost-split-fill text-success fs-4 me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Route Information</small>
                                    <span class="fw-bold text-dark">{{ $bus->route->start_location ?? 'N/A' }} to {{ $bus->route->end_location ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-success btn-lg px-4" style="font-size: 16px; font-weight: 500;">
                                <i class="bi bi-save2-fill me-2"></i>Update Bus Details
                            </button>
                        </div>
                    </form>
                @else
                    <div class="text-center py-5 h-100 d-flex flex-column align-items-center justify-content-center">
                        <div class="avatar shadow mb-3" style="width: 80px; height: 80px; font-size: 32px; background: #e2e8f0; color: #64748b; margin: 0 auto; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                            <i class="bi bi-info-circle-fill"></i>
                        </div>
                        <h5 class="fw-bold">No Bus Assigned</h5>
                        <p class="text-muted mb-0">Please contact the administrator to assign a bus to your profile before updating details.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
