
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>My Bookings</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>

body{
    background:#f4f6f9;
}

.booking-card{
    border:none;
    border-radius:20px;
    overflow:hidden;
}

.status-badge{
    background:#d1e7dd;
    color:#0f5132;
    padding:8px 14px;
    border-radius:20px;
    font-size:13px;
    font-weight:600;
}

.info-title{
    color:#6c757d;
    font-size:14px;
}

.info-value{
    font-size:22px;
    font-weight:600;
}

</style>

</head>

<body>

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">
            <i class="bi bi-ticket-perforated"></i>
            My Bookings
        </h3>

        <a href="/passenger/dashboard"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left"></i>
            Dashboard

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    @forelse($bookings as $booking)

    <div class="card booking-card shadow-sm mb-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>

                <span class="badge bg-success">
                    {{ $booking->bus_number }}
                </span>

                <span class="ms-3 fw-semibold">

                    {{ $booking->start_location }}
                    →
                    {{ $booking->end_location }}

                </span>

            </div>

            @php
                $status = strtolower($booking->status);
                $isCancelled = $status === 'cancelled';
                $badgeBg = $isCancelled ? '#f8d7da' : '#d1e7dd';
                $badgeColor = $isCancelled ? '#842029' : '#0f5132';
            @endphp
            <span class="status-badge" style="background: {{ $badgeBg }}; color: {{ $badgeColor }};">
                ● {{ ucfirst($booking->status) }}
            </span>

        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">

                    <div class="info-title">
                        Departure
                    </div>

                    <div class="info-value">

                        {{ date('g:i A', strtotime($booking->departure_time)) }}

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="info-title">
                        Seat No
                    </div>

                    <div class="info-value">
                        #{{ $booking->seat_no }}
                    </div>

                </div>

                <div class="col-md-2">

                    <div class="info-title">
                        Journey Date
                    </div>

                    <div class="info-value">
                        {{ $booking->journey_date }}
                    </div>

                </div>

                <div class="col-md-2">

                    <div class="info-title">
                        Booked At
                    </div>

                    <div class="info-value" style="font-size: 15px; margin-top: 5px;">
                        {{ \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d h:i A') }}
                    </div>

                </div>

                <div class="col-md-2">

                    <div class="info-title">
                        Booking ID
                    </div>

                    <div class="info-value">
                        #{{ $booking->id }}
                    </div>

                </div>

            </div>

            <div class="mt-4">

              <a href="/booking-details/{{ $booking->id }}"
              class="btn btn-primary btn-sm">
              View Details
              </a>

              @if(!$isCancelled)
              <a href="/cancel-booking/{{ $booking->id }}"
              class="btn btn-danger btn-sm"
              onclick="return confirm('Are you sure you want to cancel this booking?')">
              Cancel Booking
              </a>
              @endif


            </div>

        </div>

    </div>

    @empty

    <div class="alert alert-info">

        No Bookings Found

    </div>

    @endforelse

</div>

</body>
</html>

