@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark">
            <i class="bi bi-person-gear text-primary me-2"></i>My Profile
        </h3>
        <a href="/passenger/dashboard" class="btn btn-outline-secondary">
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
        <!-- Profile Overview Card -->
        <div class="col-lg-4">
            <div class="card-box p-4 text-center h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="mb-4">
                    <div class="avatar shadow" style="width: 100px; height: 100px; font-size: 40px; background: linear-gradient(135deg, #3b82f6, #1d4ed8); margin: 0 auto;">
                        {{ strtoupper(substr($passenger->name, 0, 1)) }}
                    </div>
                </div>

                <h4 class="fw-bold mb-1">{{ $passenger->name }}</h4>
                <p class="text-muted mb-3">{{ $passenger->email }}</p>

                <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
                    <span class="badge bg-primary px-3 py-2 rounded-pill">
                        <i class="bi bi-person-badge-fill me-1"></i>Passenger
                    </span>
                    @if($passengerProfile && $passengerProfile->nic)
                        <span class="badge bg-secondary px-3 py-2 rounded-pill">
                            <i class="bi bi-card-text me-1"></i>NIC: {{ $passengerProfile->nic }}
                        </span>
                    @endif
                </div>

                <hr class="w-100 my-4 text-muted opacity-25">

                <div class="w-100 text-start">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light p-2 rounded me-3">
                            <i class="bi bi-telephone-fill text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Phone Number</small>
                            <span class="fw-semibold text-dark">{{ $passenger->phone ?? 'Not set' }}</span>
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-0">
                        <div class="bg-light p-2 rounded me-3">
                            <i class="bi bi-clock-history text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Member Since</small>
                            <span class="fw-semibold text-dark">{{ $passenger->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form Card -->
        <div class="col-lg-8">
            <div class="card-box p-4 h-100">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Profile Details
                </h5>

                <form method="POST" action="/passenger/profile" autocomplete="off">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Full Name</label>
                            <input type="text" class="form-control form-control-lg border-2" name="name" value="{{ old('name', $passenger->name) }}" required style="font-size: 15px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Email Address</label>
                            <input type="email" class="form-control form-control-lg border-2" name="email" value="{{ old('email', $passenger->email) }}" required style="font-size: 15px;">
                        </div>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Phone Number</label>
                            <input type="text" class="form-control form-control-lg border-2" name="phone" value="{{ old('phone', $passenger->phone) }}" required style="font-size: 15px;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">NIC Number</label>
                            <input type="text" class="form-control form-control-lg border-2" name="nic" value="{{ old('nic', $passengerProfile->nic ?? '') }}" placeholder="Enter NIC Number" style="font-size: 15px;">
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
                        <button type="submit" class="btn btn-primary btn-lg px-4" style="font-size: 16px; font-weight: 500;">
                            <i class="bi bi-check-circle-fill me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
