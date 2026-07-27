
@extends('layouts.app')

@section('content')



<div class="card-box p-4 mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <h2 class="fw-bold">
                Welcome Back,
                {{ Auth::user()->name }} 👋
            </h2>

            <p class="text-muted mb-0">
                Manage your bookings, search buses and track your journeys.
            </p>

        </div>

        <div class="col-lg-4 text-end">

            <i class="bi bi-bus-front-fill"
               style="font-size:75px; color: #3b82f6;"></i>

        </div>

    </div>

</div>

<div class="row g-4">

    <!-- Total Bookings -->

    <div class="col-lg-3 col-md-6">

        <div class="card-box p-4">

            <div class="d-flex justify-content-between">

                <div>

                    <small class="text-muted">
                        Total Bookings
                    </small>

                    <h2 class="fw-bold mt-2">
                        {{ $bookingsCount }}
                    </h2>

                </div>

                <div class="avatar">

                    <i class="bi bi-ticket-perforated-fill"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Upcoming Trips -->

    <div class="col-lg-3 col-md-6">

        <div class="card-box p-4">

            <div class="d-flex justify-content-between">

                <div>

                    <small class="text-muted">

                        Upcoming Trips

                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $upcomingTrips }}

                    </h2>

                </div>

                <div class="avatar bg-warning">

                    <i class="bi bi-calendar-event-fill"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Completed Trips -->

    <div class="col-lg-3 col-md-6">

        <div class="card-box p-4">

            <div class="d-flex justify-content-between">

                <div>

                    <small class="text-muted">

                        Completed Trips

                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $completedTrips }}

                    </h2>

                </div>

                <div class="avatar bg-primary">

                    <i class="bi bi-check-circle-fill"></i>

                </div>

            </div>

        </div>

    </div>

    <!-- Notifications -->

    <div class="col-lg-3 col-md-6">

        <div class="card-box p-4">

            <div class="d-flex justify-content-between">

                <div>

                    <small class="text-muted">

                        Notifications

                    </small>

                    <h2 class="fw-bold mt-2">

                        {{ $notificationsCount }}

                    </h2>

                </div>

                <div class="avatar bg-danger">

                    <i class="bi bi-bell-fill"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row mt-5">

    <!-- Recent Bookings -->

    <div class="col-lg-8">

        <div class="card-box p-4">

           <div class="d-flex justify-content-between align-items-center mb-3">

    <h5 class="fw-bold mb-0">
        Recent Bookings
    </h5>

    <a href="/my-bookings"
       class="btn btn-outline-primary btn-sm">

        <i class="bi bi-eye"></i>
        View All

    </a>

</div>

            <table class="table align-middle">

                <thead>

                <tr>

                    <th>Bus</th>

                    <th>Route</th>

                    <th>Status</th>

                </tr>

                </thead>

                <tbody>

                @foreach($recentBookings as $booking)

                <tr>

                    <td>

                        {{ $booking->bus_number }}

                    </td>

                    <td>

                        {{ $booking->start_location }}

                        →

                        {{ $booking->end_location }}

                    </td>

                    <td>

                        <span class="badge bg-{{ strtolower($booking->status) === 'cancelled' ? 'danger' : 'success' }}">
                            {{ ucfirst($booking->status) }}
                        </span>

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <!-- Quick Search -->

    <div class="col-lg-4">

        <div class="card-box p-4">

            <h5 class="mb-4">

                Quick Search

            </h5>

            <form method="POST" action="/search-buses">

                @csrf

                <select
                    class="form-select mb-3"
                    name="from">

                    @foreach($routes as $route)

                    <option>

                        {{ $route->start_location }}

                    </option>

                    @endforeach

                </select>

                <select
                    class="form-select mb-3"
                    name="to">

                    @foreach($routes as $route)

                    <option>

                        {{ $route->end_location }}

                    </option>

                    @endforeach

                </select>

                <button
                    class="btn btn-primary w-100" style="background-color: #3b82f6; border-color: #3b82f6;">

                    Search Bus

                </button>

            </form>

        </div>

    </div>

</div>


<div class="row mt-4">

    <!-- Recent Notifications -->

    <div class="col-lg-6">

        <div class="card-box p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="fw-bold">
                    Recent Notifications
                </h5>

                <a href="/notifications" class="text-success text-decoration-none">
                    View All
                </a>

            </div>

            @forelse($notifications as $notification)

                <div class="d-flex align-items-start mb-3 pb-3 border-bottom">

                    <div class="me-3">

                        <div class="avatar" style="width:45px;height:45px;">
                            <i class="bi bi-bell-fill"></i>
                        </div>

                    </div>

                    <div>

                        <div class="fw-semibold">
                            {{ $notification->message }}
                        </div>

                        <small class="text-muted">

                            {{ $notification->created_at->diffForHumans() }}

                        </small>

                    </div>

                </div>

            @empty

                <div class="text-muted">

                    No notifications available

                </div>

            @endforelse

        </div>

    </div>

    <!-- Weekly Activity -->

    <div class="col-lg-6">

        <div class="card-box p-4">

            <h5 class="fw-bold mb-4">

                Weekly Booking Activity

            </h5>

            <canvas id="bookingChart" height="180"></canvas>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('bookingChart');

new Chart(ctx,{

    type:'line',

    data:{

        labels:[
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
            'Sun'
        ],

        datasets:[{

    label:'Bookings',

    data:@json($weeklyBookings),

    borderColor:'#16C47F',

    backgroundColor:'rgba(22,196,127,.15)',

    fill:true,

    tension:.4

        }]

    },

    options:{

        responsive:true,

        plugins:{

            legend:{
                display:false
            }

        }



        
    }

});

</script>


@endsection

