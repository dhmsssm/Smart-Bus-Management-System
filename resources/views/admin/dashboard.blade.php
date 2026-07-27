@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold">
                <i class="bi bi-speedometer2" style="color: #6366f1;"></i>
                Admin Dashboard
            </h2>

            <p class="text-muted">
                Welcome back, Administrator.
            </p>

        </div>

        <div class="d-flex gap-2">
            <a href="/admin/report/download" class="btn btn-success rounded-3">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="/admin/report/pdf" target="_blank" class="btn btn-danger rounded-3">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
            <a href="/admin/bus-location" class="btn btn-primary rounded-3" style="background-color: #6366f1; border-color: #6366f1;">
                <i class="bi bi-geo-alt-fill"></i> Update Bus Location
            </a>
        </div>

    </div>

    <div class="row g-4">

        <!-- Total Buses -->

        <div class="col-lg-2 col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Total Buses
                            </small>

                            <h2 class="fw-bold">
                                {{ $busesCount }}
                            </h2>

                        </div>

                        <div class="fs-1" style="color: #6366f1;">

                            <i class="bi bi-bus-front-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Routes -->

        <div class="col-lg-2 col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Routes
                            </small>

                            <h2 class="fw-bold">
                                {{ $routesCount }}
                            </h2>

                        </div>

                        <div class="fs-1 text-primary">

                            <i class="bi bi-signpost-split-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Drivers -->

        <div class="col-lg-2 col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Drivers
                            </small>

                            <h2 class="fw-bold">
                                {{ $driversCount }}
                            </h2>

                        </div>

                        <div class="fs-1 text-warning">

                            <i class="bi bi-person-badge-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Passengers -->

        <div class="col-lg-2 col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Passengers
                            </small>

                            <h2 class="fw-bold">
                                {{ $passengersCount }}
                            </h2>

                        </div>

                        <div class="fs-1 text-info">

                            <i class="bi bi-people-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Bookings -->

        <div class="col-lg-2 col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Bookings
                            </small>

                            <h2 class="fw-bold">
                                {{ $bookingsCount }}
                            </h2>

                        </div>

                        <div class="fs-1 text-danger">

                            <i class="bi bi-ticket-perforated-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- Notifications -->

        <div class="col-lg-2 col-md-4">

            <div class="card shadow-sm border-0 rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <small class="text-muted">
                                Notifications
                            </small>

                            <h2 class="fw-bold">
                                {{ $notificationsCount }}
                            </h2>

                        </div>

                        <div class="fs-1 text-secondary">

                            <i class="bi bi-bell-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Fleet Status & Recent Bookings -->

<div class="row mt-4">

    <!-- Fleet Status -->

    <div class="col-lg-5 mb-4">

        <div class="card shadow-sm border-0 rounded-4 h-100">

            <div class="card-header bg-white border-0">

                <h5 class="fw-bold mb-0">

                    🚍 Fleet Status

                </h5>

            </div>

            <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                @forelse($buses as $bus)
                    @php
                        $location = $bus->location;
                        $status = $location ? $location->status : 'Stopped';
                        $speed = $location ? $location->speed : 0;
                        
                        $statusClass = 'text-secondary';
                        $badgeClass = 'bg-secondary';
                        
                        $normalizedStatus = strtolower($status);
                        if (in_array($normalizedStatus, ['moving', 'on time', 'active'])) {
                            $statusClass = 'text-success';
                            $badgeClass = 'bg-success';
                        } elseif (in_array($normalizedStatus, ['delayed', 'warning'])) {
                            $statusClass = 'text-warning';
                            $badgeClass = 'bg-warning text-dark';
                        } elseif (in_array($normalizedStatus, ['stopped', 'inactive', 'cancelled'])) {
                            $statusClass = 'text-danger';
                            $badgeClass = 'bg-danger';
                        }
                    @endphp
                    <div class="d-flex justify-content-between align-items-center @if(!$loop->last) border-bottom @endif py-3">
                        <div>
                            <strong>{{ $bus->bus_number }}</strong><br>
                            <small class="{{ $statusClass }}">{{ ucfirst($status) }}</small>
                        </div>
                        <span class="badge {{ $badgeClass }}">
                            {{ $speed }} km/h
                        </span>
                    </div>
                @empty
                    <div class="text-center py-3">
                        <small class="text-muted">No buses available.</small>
                    </div>
                @endforelse
            </div>

        </div>

    </div>

    <!-- Recent Bookings -->

    <div class="col-lg-7 mb-4">

        <div class="card shadow-sm border-0 rounded-4 h-100">

            <div class="card-header bg-white border-0">

                <h5 class="fw-bold mb-0">

                    🎫 Recent Bookings

                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>

                                <th>Passenger</th>

                                <th>Bus</th>

                                <th>Seat</th>

                                <th>Booked At</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($recentBookings as $booking)

                            <tr>

                                <td>{{ $booking->name }}</td>

                                <td>{{ $booking->bus_number }}</td>

                                <td>{{ $booking->seat_no }}</td>

                                <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d h:i A') }}</td>

                                <td>
                                    <span class="badge bg-{{ strtolower($booking->status) === 'cancelled' ? 'danger' : (strtolower($booking->status) === 'pending' ? 'warning text-dark' : 'success') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4" class="text-center">

                                    No Bookings Found

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>



<div class="row">

    <!-- Weekly Booking Chart -->

    <div class="col-lg-8 mb-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white border-0">

                <h5 class="fw-bold mb-0">

                    📊 Weekly Booking Overview

                </h5>

            </div>

            <div class="card-body">

                <canvas id="bookingChart" height="100"></canvas>

            </div>

        </div>

    </div>

    <!-- Quick Actions -->

    <div class="col-lg-4 mb-4">

        <div class="card shadow-sm border-0 rounded-4">

            <div class="card-header bg-white border-0">

                <h5 class="fw-bold mb-0">

                    ⚡ Quick Actions

                </h5>

            </div>

            <div class="card-body d-grid gap-3">

                <a href="/admin/bus-location"
                class="btn btn-success">

                    <i class="bi bi-geo-alt-fill me-2"></i>

                    Update Bus Location

                </a>

            <a href="/admin/buses"
class="btn btn-primary">

    <i class="bi bi-bus-front-fill me-2"></i>

    Manage Buses

</a>

              <a href="/admin/routes"
class="btn btn-warning text-white">

    <i class="bi bi-signpost-split-fill me-2"></i>

    Manage Routes

</a>

            <a href="/admin/users"
class="btn btn-dark">

    <i class="bi bi-people-fill me-2"></i>

    Manage Users

</a>

            </div>

        </div>

    </div>

</div>





<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('bookingChart');

if(ctx){

new Chart(ctx,{

type:'bar',

data:{

labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],

datasets:[{

label:'Bookings',

data:[12,18,10,22,15,25,19],

backgroundColor:'#198754',

borderRadius:8

}]

},

options:{

responsive:true,

plugins:{

legend:{

display:false

}

},

scales:{

y:{

beginAtZero:true

}

}

}

});

}

</script>


@endsection