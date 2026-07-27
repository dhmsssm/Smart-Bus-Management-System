@extends('layouts.app')

@section('content')

<div class="card-box p-4 mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <h2 class="fw-bold">
                Trip Management
            </h2>

            <p class="text-muted mb-0">
                Start and complete your assigned bus trip.
            </p>

        </div>

        <div class="col-lg-4 text-end">

            <i class="bi bi-play-circle-fill text-success"
               style="font-size:75px;"></i>

        </div>

    </div>

</div>

@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif

@if(session('error'))

    <div class="alert alert-danger">
        {{ session('error') }}
    </div>

@endif

<div class="row g-4">

    <div class="col-lg-4 col-md-6">

        <div class="card card-box border-0">

            <div class="card-body p-4 d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Assigned Bus
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $bus->bus_number ?? 'N/A' }}
                    </h2>

                </div>

                <div class="avatar">

                    <i class="bi bi-bus-front-fill"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 col-md-6">

        <div class="card card-box border-0">

            <div class="card-body p-4 d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Trip Status
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $activeTrip ? 'Started' : 'Not Started' }}
                    </h2>

                </div>

                <div class="avatar bg-warning">

                    <i class="bi bi-clock-history"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-lg-4 col-md-6">

        <div class="card card-box border-0">

            <div class="card-body p-4 d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Start Time
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $activeTrip ? $activeTrip->start_time->format('h:i A') : 'N/A' }}
                    </h2>

                </div>

                <div class="avatar bg-primary">

                    <i class="bi bi-calendar-event-fill"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row mt-5">

    <div class="col-lg-12">

        <div class="card-box p-4">

            <h5 class="fw-bold mb-4">
                Trip Actions
            </h5>

            @if($bus)

                <div class="d-flex flex-wrap gap-2">

                    <form method="POST" action="{{ route('driver.trip.start') }}">
                        @csrf

                        <button
                            class="btn btn-success"
                            {{ $activeTrip ? 'disabled' : '' }}>

                            <i class="bi bi-play-circle-fill me-2"></i>
                            Start Trip

                        </button>

                    </form>

                    <form method="POST" action="{{ route('driver.trip.end') }}">
                        @csrf

                        <button
                            class="btn btn-danger"
                            {{ $activeTrip ? '' : 'disabled' }}
                            onclick="return confirm('End this trip now?')">

                            <i class="bi bi-stop-circle-fill me-2"></i>
                            End Trip

                        </button>

                    </form>

                </div>

            @else

                <p class="text-muted mb-0">
                    Ask the admin to assign a bus before starting a trip.
                </p>

            @endif

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-lg-12">

        <div class="card-box p-4">

            <h5 class="fw-bold mb-3">
                Recent Trips
            </h5>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Bus</th>
                            <th>Route</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentTrips as $trip)

                            <tr>
                                <td>{{ $trip->bus->bus_number ?? 'N/A' }}</td>
                                <td>
                                    {{ $trip->route->start_location ?? 'N/A' }}
                                    ->
                                    {{ $trip->route->end_location ?? 'N/A' }}
                                </td>
                                <td>{{ $trip->start_time ? $trip->start_time->format('Y-m-d h:i A') : 'N/A' }}</td>
                                <td>{{ $trip->end_time ? $trip->end_time->format('Y-m-d h:i A') : 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $trip->status === 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                        {{ $trip->status }}
                                    </span>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No trips found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection
