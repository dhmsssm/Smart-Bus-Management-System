@extends('layouts.app')

@section('content')

@php
    $assignedRoute = $bus && $bus->route
        ? $bus->route->start_location . ' -> ' . $bus->route->end_location
        : 'Not Assigned';

    $tripStatus = $location->status ?? ($bus ? ucfirst($bus->status) : 'Pending');
@endphp

<div class="card-box p-4 mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <h2 class="fw-bold">
                Welcome Driver,
                {{ $driver->name }}
            </h2>

            <p class="text-muted mb-0">
                Manage your assigned bus, route and daily trips.
            </p>

        </div>

        <div class="col-lg-4 text-end">

            <i class="bi bi-bus-front-fill text-success"
               style="font-size:75px;"></i>

        </div>

    </div>

</div>

<div class="row g-4">

    <!-- Assigned Bus -->

    <div class="col-lg-3 col-md-6">

        <div class="card card-box border-0">

            <div class="card-body p-4 d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Assigned Bus
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $bus?->bus_number ?? 'N/A' }}
                    </h2>

                </div>

                <div class="avatar">

                    <i class="bi bi-bus-front-fill"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Assigned Route -->

    <div class="col-lg-3 col-md-6">

        <div class="card card-box border-0">

            <div class="card-body p-4 d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Assigned Route
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $assignedRoute }}
                    </h2>

                </div>

                <div class="avatar bg-warning">

                    <i class="bi bi-signpost-split-fill"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Trip Status -->

    <div class="col-lg-3 col-md-6">

        <div class="card card-box border-0">

            <div class="card-body p-4 d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Trip Status
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $tripStatus }}
                    </h2>

                </div>

                <div class="avatar bg-primary">

                    <i class="bi bi-check-circle-fill"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Today's Trips -->

    <div class="col-lg-3 col-md-6">

        <div class="card card-box border-0">

            <div class="card-body p-4 d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Today's Trips
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $todayBookings }}
                    </h2>

                </div>

                <div class="avatar bg-danger">

                    <i class="bi bi-calendar-event-fill"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<h3 class="fw-bold mt-5 mb-4 text-dark" style="font-size: 1.5rem;">
    <i class="bi bi-grid-3x3-gap-fill text-success me-2"></i> Quick Actions
</h3>

<div class="row g-4 mb-4">
    <!-- View Assigned Trips -->
    <div class="col-md-6 col-lg-3">
        <a href="/driver/my-trip" class="text-decoration-none">
            <div class="card card-box border-0 h-100 p-3">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-success-subtle text-success p-3 mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="bi bi-calendar-range-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" style="font-size: 1.05rem;">View Assigned Trips</h5>
                    <p class="text-muted small mb-0">Check schedules and active daily trip records.</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Update Trip Status -->
    <div class="col-md-6 col-lg-3">
        <a href="/driver/status" class="text-decoration-none">
            <div class="card card-box border-0 h-100 p-3">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-primary-subtle text-primary p-3 mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" style="font-size: 1.05rem;">Update Trip Status</h5>
                    <p class="text-muted small mb-0">Update bus status to Active or maintenance.</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Share Live Location -->
    <div class="col-md-6 col-lg-3">
        <a href="/driver/share-location" class="text-decoration-none">
            <div class="card card-box border-0 h-100 p-3">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-info-subtle text-info p-3 mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" style="font-size: 1.05rem;">Share Live Location</h5>
                    <p class="text-muted small mb-0">Broadcast live GPS tracking coordinates.</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Receive Schedule Updates -->
    <div class="col-md-6 col-lg-3">
        <a href="/driver/notifications" class="text-decoration-none">
            <div class="card card-box border-0 h-100 p-3">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-warning-subtle text-warning p-3 mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" style="font-size: 1.05rem;">Receive Updates</h5>
                    <p class="text-muted small mb-0">Get notifications on route changes and news.</p>
                </div>
            </div>
        </a>
    </div>

    <!-- Passenger Bookings -->
    <div class="col-md-6 col-lg-3">
        <a href="/driver/passengers" class="text-decoration-none">
            <div class="card card-box border-0 h-100 p-3">
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-center">
                    <div class="rounded-circle bg-success-subtle text-success p-3 mb-3" style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2" style="font-size: 1.05rem;">Passenger Bookings</h5>
                    <p class="text-muted small mb-0">View bookings and passenger details for your bus.</p>
                </div>
            </div>
        </a>
    </div>
</div>

@endsection
