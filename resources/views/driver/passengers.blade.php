@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-people-fill text-success me-2"></i>
                Passengers
            </h2>
            <p class="text-muted mb-0">View passenger bookings for your assigned bus.</p>
        </div>
    </div>

    <div class="card-box p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">{{ $bus->bus_number ?? 'No Bus Assigned' }}</h5>
            <span class="badge bg-success">{{ $passengers->count() }} bookings</span>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Seat</th>
                        <th>Passenger</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Journey Date</th>
                        <th>Booked At</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($passengers as $passenger)
                        <tr>
                            <td>{{ $passenger->seat_no }}</td>
                            <td class="fw-semibold">{{ $passenger->passenger_name }}</td>
                            <td>{{ $passenger->passenger_phone ?? 'No phone' }}</td>
                            <td>{{ $passenger->passenger_email }}</td>
                            <td>{{ $passenger->journey_date }}</td>
                            <td>{{ \Carbon\Carbon::parse($passenger->created_at)->format('Y-m-d h:i A') }}</td>
                            <td>
                                <span class="badge {{ $passenger->status === 'cancelled' ? 'bg-danger' : 'bg-success' }}">
                                    {{ ucfirst($passenger->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                No passenger bookings found for your bus.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
