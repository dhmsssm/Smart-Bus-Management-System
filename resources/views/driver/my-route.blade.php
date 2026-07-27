@extends('layouts.app')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #198754 !important;">
        <div class="fw-medium">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #dc3545 !important;">
        <div class="fw-medium">{{ session('error') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #dc3545 !important;">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card-box p-4 mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <h2 class="fw-bold">
                My Route
            </h2>

            <p class="text-muted mb-3">
                View the route assigned to your current bus.
            </p>

            <div class="mb-2">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addRouteModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Route
                </button>
            </div>

        </div>

        <div class="col-lg-4 text-end">

            <i class="bi bi-signpost-split-fill text-success"
               style="font-size:75px;"></i>

        </div>

    </div>

</div>

@if($route)

    <div class="row g-4">

        <!-- Route Name -->

        <div class="col-lg-4 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Route Name
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $route->route_name ?? 'N/A' }}
                        </h2>

                    </div>

                    <div class="avatar">

                        <i class="bi bi-signpost-split-fill"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Start Location -->

        <div class="col-lg-4 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Start Location
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $route->start_location }}
                        </h2>

                    </div>

                    <div class="avatar bg-warning">

                        <i class="bi bi-geo-alt-fill"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- End Location -->

        <div class="col-lg-4 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            End Location
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $route->end_location }}
                        </h2>

                    </div>

                    <div class="avatar bg-primary">

                        <i class="bi bi-geo-alt-fill"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Distance -->

        <div class="col-lg-4 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Distance
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $route->distance ?? '0' }} km
                        </h2>

                    </div>

                    <div class="avatar bg-danger">

                        <i class="bi bi-map-fill"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Estimated Travel Time -->

        <div class="col-lg-4 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Estimated Travel Time
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $estimatedTime }}
                        </h2>

                    </div>

                    <div class="avatar">

                        <i class="bi bi-clock-fill"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Route Status -->

        <div class="col-lg-4 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Route Status
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $routeStatus ?? 'Inactive' }}
                        </h2>

                    </div>

                    <div class="avatar bg-success">

                        <i class="bi bi-check-circle-fill"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-5">

        <div class="col-lg-12">

            <div class="card-box p-4">

                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">

                    <div class="d-flex align-items-center">

                        <div class="avatar me-3">
                            <i class="bi bi-signpost-split-fill"></i>
                        </div>

                        <div>

                            <h5 class="fw-bold mb-1">
                                {{ $route->route_name ?? 'Assigned Route' }}
                            </h5>

                            <small class="text-muted">
                                {{ $route->start_location }}
                                ->
                                {{ $route->end_location }}
                            </small>

                        </div>

                    </div>

                    <span class="badge px-3 py-2 {{ ($routeStatus ?? 'Inactive') === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ $routeStatus ?? 'Inactive' }}
                    </span>

                </div>

                <div class="row g-4">

                    <div class="col-lg-4 col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted">Route Name</small>
                            <div class="fw-bold mt-1">{{ $route->route_name ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted">Start Location</small>
                            <div class="fw-bold mt-1">{{ $route->start_location }}</div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted">End Location</small>
                            <div class="fw-bold mt-1">{{ $route->end_location }}</div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted">Distance</small>
                            <div class="fw-bold mt-1">{{ $route->distance ?? '0' }} km</div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted">Estimated Travel Time</small>
                            <div class="fw-bold mt-1">{{ $estimatedTime }}</div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="border rounded-3 p-3 h-100">
                            <small class="text-muted">Status</small>
                            <div class="mt-1">
                                <span class="badge {{ ($routeStatus ?? 'Inactive') === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $routeStatus ?? 'Inactive' }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>

@else

    <div class="card-box p-5 text-center">

        <div class="avatar bg-secondary mx-auto mb-3">
            <i class="bi bi-info-circle-fill"></i>
        </div>

        <h5 class="fw-semibold">
            No Route Assigned
        </h5>

        <p class="text-muted mb-0">
            Ask the admin to assign a route to your bus.
        </p>

    </div>

@endif

<!-- Add Route Modal -->
<div class="modal fade" id="addRouteModal" tabindex="-1" aria-labelledby="addRouteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('driver.add-route') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addRouteModalLabel">Add New Route</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label for="route_name" class="form-label">Route Name / Code</label>
                        <input type="text" class="form-control" id="route_name" name="route_name" placeholder="e.g. Route 01" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_location" class="form-label">Start Location</label>
                        <input type="text" class="form-control" id="start_location" name="start_location" placeholder="e.g. Colombo" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_location" class="form-label">End Location</label>
                        <input type="text" class="form-control" id="end_location" name="end_location" placeholder="e.g. Kandy" required>
                    </div>
                    <div class="mb-3">
                        <label for="distance" class="form-label">Distance (km)</label>
                        <input type="number" step="0.1" class="form-control" id="distance" name="distance" min="0.1" placeholder="e.g. 115" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Route</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
