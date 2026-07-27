@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">

            🎫 Manage Bookings

        </h2>

    </div>

    <div class="card shadow-sm">

        <div class="card-body">

            <table class="table table-bordered table-hover">

                <thead class="table-success">

                    <tr>

                        <th>ID</th>
                        <th>Passenger</th>
                        <th>Bus</th>
                        <th>Seat</th>
                        <th>Journey Date</th>
                        <th>Booked At</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($bookings as $booking)

                    <tr>

                        <td>{{ $booking->id }}</td>

                        <td>{{ $booking->name }}</td>

                        <td>{{ $booking->bus_number }}</td>

                        <td>{{ $booking->seat_no }}</td>

                        <td>{{ $booking->journey_date }}</td>

                        <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('Y-m-d h:i A') }}</td>

                        <td>

                            <span class="badge {{ $booking->status === 'confirmed' ? 'bg-success' : ($booking->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">

                                {{ ucfirst($booking->status) }}

                            </span>

                        </td>

                        <td>

                            <a href="/admin/bookings/details/{{ $booking->id }}"
                               class="btn btn-info btn-sm text-white">

                                View

                            </a>

                            @if($booking->status === 'pending')
                            <a href="/admin/bookings/approve/{{ $booking->id }}"
                               class="btn btn-success btn-sm"
                               onclick="return confirm('Are you sure you want to approve this booking?');">

                                Approve

                            </a>
                            @endif

                            <a href="/admin/bookings/cancel/{{ $booking->id }}"
                               class="btn btn-danger btn-sm"
                               onclick="let reason = prompt('Enter cancellation reason:', 'Schedule changed'); if (reason === null) return false; if (!reason.trim()) reason = 'Cancelled by administrator'; this.href = '/admin/bookings/cancel/{{ $booking->id }}?reason=' + encodeURIComponent(reason); return confirm('Are you sure you want to cancel this booking?');">

                                Cancel

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="text-center">

                            No Bookings Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection