@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

   <h2 class="fw-bold">
    <i class="bi bi-pencil-square text-warning"></i>
    Edit Bus
</h2>

        <a href="/admin/buses" class="btn btn-secondary">
            Back
        </a>

    </div>

    <div class="card shadow-sm border-0 rounded-4">

        <div class="card-body">

           <form action="/admin/buses/update/{{ $bus->id }}" method="POST">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Bus Number
                        </label>

                       <input
type="text"
name="bus_number"
class="form-control"
value="{{ $bus->bus_number }}"
required>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Capacity
                        </label>

                        <input
type="number"
name="capacity"
class="form-control"
value="{{ $bus->capacity }}"
required>
                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Route
                        </label>

                        <select
                            name="route_id"
                            class="form-select"
                            required>

                            <option value="">
                                Select Route
                            </option>

                       @foreach($routes as $route)

<option value="{{ $route->id }}"
{{ $bus->route_id == $route->id ? 'selected' : '' }}>

{{ $route->start_location }}
→
{{ $route->end_location }}

</option>

@endforeach

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Driver
                        </label>

                        <select
                            name="driver_id"
                            class="form-select">

                            <option value="">
                                Select Driver
                            </option>

                          @foreach($drivers as $driver)

<option value="{{ $driver->id }}"
{{ $bus->driver_id == $driver->id ? 'selected' : '' }}>

{{ $driver->name }}

</option>

@endforeach

                        </select>

                    </div>










                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status"
                            class="form-select"
                            required>

                           <option value="active"
{{ $bus->status == 'active' ? 'selected' : '' }}>

Active

</option>

<option value="maintenance"
{{ $bus->status == 'maintenance' ? 'selected' : '' }}>

Maintenance

</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Departure Time
                        </label>

                       <input
type="time"
name="departure_time"
class="form-control"
value="{{ $bus->departure_time }}">

                    </div>

                </div>

                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-success">

                        <i class="bi bi-check-circle"></i>

                        Update Bus

                    </button>

                    <a
                        href="/admin/buses"
                        class="btn btn-secondary">

                        Cancel

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection                    