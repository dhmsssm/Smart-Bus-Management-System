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
                My Bus
            </h2>

            <p class="text-muted mb-3">
                View your assigned bus details and route information.
            </p>

            <div class="mb-2">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBusModal">
                    <i class="bi bi-plus-circle me-1"></i> Add Bus
                </button>
            </div>

        </div>

        <div class="col-lg-4 text-end">

            <i class="bi bi-bus-front-fill text-success"
               style="font-size:75px;"></i>

        </div>

    </div>

</div>

@if($bus)

    <div class="row g-4">

        <!-- Bus Number -->

        <div class="col-lg-3 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Bus Number
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $bus->bus_number }}
                        </h2>

                    </div>

                    <div class="avatar">

                        <i class="bi bi-bus-front-fill"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Capacity -->

        <div class="col-lg-3 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Capacity
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $bus->capacity }}
                        </h2>

                    </div>

                    <div class="avatar bg-warning">

                        <i class="bi bi-people-fill"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Route -->

        <div class="col-lg-3 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Route
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $bus->route->start_location ?? 'N/A' }}
                            ->
                            {{ $bus->route->end_location ?? 'N/A' }}
                        </h2>

                    </div>

                    <div class="avatar bg-primary">

                        <i class="bi bi-signpost-split-fill"></i>

                    </div>

                </div>

            </div>

        </div>

        <!-- Departure Time -->

        <div class="col-lg-3 col-md-6">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between">

                    <div>

                        <small class="text-muted">
                            Departure Time
                        </small>

                        <h2 class="fw-bold mt-2">
                            {{ $bus->departure_time ?? 'Not Set' }}
                        </h2>

                    </div>

                    <div class="avatar bg-danger">

                        <i class="bi bi-clock-fill"></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-5">

        <div class="col-lg-12">

            <div class="card-box p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="fw-bold mb-0">
                        Bus Information
                    </h5>

                    <span class="badge bg-success">
                        {{ ucfirst($bus->status) }}
                    </span>

                </div>

                <div class="table-responsive">

                    <table class="table align-middle">

                        <tbody>

                            <tr>
                                <th>Bus Number</th>
                                <td>{{ $bus->bus_number }}</td>
                            </tr>

                            <tr>
                                <th>Capacity</th>
                                <td>{{ $bus->capacity }}</td>
                            </tr>

                            <tr>
                                <th>Route</th>
                                <td>
                                    {{ $bus->route->start_location ?? 'N/A' }}
                                    ->
                                    {{ $bus->route->end_location ?? 'N/A' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Departure Time</th>
                                <td>{{ $bus->departure_time ?? 'Not Set' }}</td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge bg-success">
                                        {{ ucfirst($bus->status) }}
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>

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
            No Bus Assigned
        </h5>

        <p class="text-muted mb-0">
            Ask the admin to assign a bus to your driver account.
        </p>

    </div>

@endif

<!-- Add Bus Modal -->
<div class="modal fade" id="addBusModal" tabindex="-1" aria-labelledby="addBusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('driver.add-bus') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="addBusModalLabel">Add New Bus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label for="bus_number" class="form-label">Bus Number</label>
                        <input type="text" class="form-control" id="bus_number" name="bus_number" placeholder="e.g. ND-1234" required>
                    </div>
                    <div class="mb-3">
                        <label for="capacity" class="form-label">Capacity</label>
                        <input type="number" class="form-control" id="capacity" name="capacity" min="1" max="120" placeholder="e.g. 52" required>
                    </div>
                    <div class="mb-3">
                        <label for="route_id" class="form-label">Assign Route</label>
                        <select class="form-select" id="route_id" name="route_id" required>
                            <option value="">Select a Route</option>
                            @foreach($routes as $r)
                                <option value="{{ $r->id }}">{{ $r->route_name }} ({{ $r->start_location }} to {{ $r->end_location }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="departure_time" class="form-label">Departure Time</label>
                        <input type="time" class="form-control" id="departure_time" name="departure_time">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save Bus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
