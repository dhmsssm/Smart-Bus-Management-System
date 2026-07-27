@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Header with Back Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Ticket Details</h3>
            <p class="text-muted mb-0">View information for your seat reservation.</p>
        </div>
        <a href="/my-bookings" class="btn btn-outline-secondary d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back to Bookings
        </a>
    </div>

    <!-- Booking Details Card -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card-box p-4 border-0 shadow-sm position-relative overflow-hidden">
                <!-- Ticket Top Header Ribbon/Theme -->
                <div class="bg-primary text-white p-3 mx-n4 mt-n4 mb-4 text-center">
                    <span class="fs-5 fw-bold tracking-wider">BOARDING PASS</span>
                </div>

                <!-- Ticket Details -->
                <div class="mb-4 text-center">
                    <span class="text-secondary small d-block text-uppercase mb-1">Route</span>
                    <h4 class="fw-bold text-dark">
                        {{ $booking->start_location }} 
                        <i class="bi bi-arrow-right text-primary mx-2"></i> 
                        {{ $booking->end_location }}
                    </h4>
                </div>

                <hr class="my-4 text-secondary opacity-25">

                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-secondary small d-block mb-1">Bus Number</span>
                            <span class="fw-bold text-primary fs-5">{{ $booking->bus_number }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-secondary small d-block mb-1">Seat Number</span>
                            <span class="fw-bold text-dark fs-5">Seat {{ $booking->seat_no }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-secondary small d-block mb-1">Journey Date</span>
                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($booking->journey_date)->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-secondary small d-block mb-1">Departure Time</span>
                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($booking->departure_time)->format('h:i A') }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3">
                            <span class="text-secondary small d-block mb-1">Booked At</span>
                            <span class="fw-bold text-dark">{{ \Carbon\Carbon::parse($booking->created_at)->format('M d, Y h:i A') }}</span>
                        </div>
                    </div>
                </div>

                <hr class="my-4 text-secondary opacity-25">

                <!-- Ticket Footer Details -->
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-secondary small d-block">Booking Status</span>
                        <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : ($booking->status === 'cancelled' ? 'bg-danger' : 'bg-warning') }} px-3 py-2 rounded-pill fs-7">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                    <div class="text-end">
                        <span class="text-secondary small d-block">Ticket ID</span>
                        <span class="fw-mono text-dark fw-bold">#{{ $booking->id }}</span>
                    </div>
                </div>

                @if($booking->status === 'confirmed')
                <div class="mt-4 pt-2 text-center">
                    <button onclick="window.print()" class="btn btn-outline-primary d-inline-flex align-items-center gap-2">
                        <i class="bi bi-printer"></i> Print Ticket
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection