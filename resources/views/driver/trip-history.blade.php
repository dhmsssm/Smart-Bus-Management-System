@extends('layouts.app')

@section('content')

<div class="card-box p-4 mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <h2 class="fw-bold">
                Trip History
            </h2>

            <p class="text-muted mb-0">
                View your previous and current driver trips.
            </p>

        </div>

        <div class="col-lg-4 text-end">

            <i class="bi bi-clock-history text-success"
               style="font-size:75px;"></i>

        </div>

    </div>

</div>

<div class="card-box p-4">

    <div class="table-responsive">

        <table class="table align-middle">

            <thead>
                <tr>
                    <th>Date</th>
                    <th>Bus</th>
                    <th>Route</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @forelse($trips as $trip)

                    <tr>
                        <td>
                            {{ $trip->start_time ? $trip->start_time->format('Y-m-d') : 'N/A' }}
                        </td>

                        <td>
                            {{ $trip->bus->bus_number ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $trip->route->start_location ?? 'N/A' }}
                            ->
                            {{ $trip->route->end_location ?? 'N/A' }}
                        </td>

                        <td>
                            {{ $trip->start_time ? $trip->start_time->format('h:i A') : 'N/A' }}
                        </td>

                        <td>
                            {{ $trip->end_time ? $trip->end_time->format('h:i A') : 'N/A' }}
                        </td>

                        <td>
                            <span class="badge {{ $trip->status === 'Completed' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $trip->status }}
                            </span>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            No trip history found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection
