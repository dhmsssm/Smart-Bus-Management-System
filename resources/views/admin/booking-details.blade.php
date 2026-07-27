@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            🎫 Booking Details

        </h2>

        <a href="/admin/bookings"
        class="btn btn-secondary">

            Back

        </a>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-body">

            <table class="table">

                <tr>
                    <th width="250">Passenger Name</th>
                    <td>{{ $booking->name }}</td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td>{{ $booking->email }}</td>
                </tr>

                <tr>
                    <th>Phone</th>
                    <td>{{ $booking->phone }}</td>
                </tr>

                <tr>
                    <th>Bus Number</th>
                    <td>{{ $booking->bus_number }}</td>
                </tr>

                <tr>
                    <th>Seat Number</th>
                    <td>{{ $booking->seat_no }}</td>
                </tr>

                <tr>
                    <th>Journey Date</th>
                    <td>{{ $booking->journey_date }}</td>
                </tr>

                <tr>
                    <th>Booked At</th>
                    <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d h:i A') }}</td>
                </tr>

                <tr>
                    <th>Status</th>

                    <td>

                        <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : 'bg-danger' }}">

                            {{ ucfirst($booking->status) }}

                        </span>

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>

@endsection