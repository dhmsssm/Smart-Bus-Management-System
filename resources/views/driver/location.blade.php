@extends('layouts.app')

@section('content')

<div class="card-box p-4 mb-4">

    <div class="row align-items-center">

        <div class="col-lg-8">

            <h2 class="fw-bold">
                Update Location
            </h2>

            <p class="text-muted mb-0">
                Update your assigned bus latitude and longitude for passenger live tracking.
            </p>

        </div>

        <div class="col-lg-4 text-end">

            <i class="bi bi-geo-alt-fill text-success"
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

@if($errors->any())

    <div class="alert alert-danger">

        <strong>Please fix these details:</strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<div class="row g-4">

    <div class="col-lg-4">

        <div class="card-box p-4 h-100">

            <h5 class="fw-bold mb-4">
                Assigned Bus
            </h5>

            @if($bus)

                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-muted">Bus Number</span>
                    <strong>{{ $bus->bus_number }}</strong>
                </div>

                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-muted">Route</span>
                    <strong>
                        {{ $bus->route->start_location ?? 'N/A' }}
                        ->
                        {{ $bus->route->end_location ?? 'N/A' }}
                    </strong>
                </div>

                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-muted">Latitude</span>
                    <strong>{{ $location->latitude ?? 'Not Updated' }}</strong>
                </div>

                <div class="d-flex justify-content-between py-3">
                    <span class="text-muted">Longitude</span>
                    <strong>{{ $location->longitude ?? 'Not Updated' }}</strong>
                </div>

            @else

                <div class="text-center py-5">

                    <div class="avatar bg-secondary mx-auto mb-3">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>

                    <h5 class="fw-semibold">
                        No Bus Assigned
                    </h5>

                    <p class="text-muted mb-0">
                        Ask the admin to assign a bus before updating location.
                    </p>

                </div>

            @endif

        </div>

    </div>

    <div class="col-lg-8">

        <div class="card-box p-4">

            <h5 class="fw-bold mb-4">
                Live Bus Location
            </h5>

            @if($bus)

                <form method="POST" action="{{ route('driver.location.update') }}">

                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Latitude
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="latitude"
                                value="{{ old('latitude', $location->latitude ?? '') }}"
                                placeholder="Enter latitude"
                                required>

                        </div>

                        <div class="col-md-6">

                            <label class="form-label">
                                Longitude
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                name="longitude"
                                value="{{ old('longitude', $location->longitude ?? '') }}"
                                placeholder="Enter longitude"
                                required>

                        </div>

                    </div>

                    <button class="btn btn-success mt-4">

                        <i class="bi bi-geo-alt-fill me-2"></i>
                        Update Location

                    </button>

                </form>

            @else

                <p class="text-muted mb-0">
                    Location form is disabled until a bus is assigned to your driver account.
                </p>

            @endif

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const latitudeInput = document.querySelector('input[name="latitude"]');
    const longitudeInput = document.querySelector('input[name="longitude"]');
    const updateButton = document.querySelector('form[action="{{ route('driver.location.update') }}"] button[type="submit"], form[action="{{ route('driver.location.update') }}"] button:not([type])');

    if (!latitudeInput || !longitudeInput || !updateButton) {
        return;
    }

    const locationButton = document.createElement('button');
    locationButton.type = 'button';
    locationButton.className = 'btn btn-outline-success mt-4 me-2';
    locationButton.innerHTML = '<i class="bi bi-crosshair me-2"></i>Get Current Location';

    updateButton.parentNode.insertBefore(locationButton, updateButton);

    locationButton.addEventListener('click', function () {
        if (!navigator.geolocation) {
            alert('Geolocation is not supported by this browser.');
            return;
        }

        locationButton.disabled = true;
        locationButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Getting Location...';

        navigator.geolocation.getCurrentPosition(
            function (position) {
                latitudeInput.value = position.coords.latitude.toFixed(7);
                longitudeInput.value = position.coords.longitude.toFixed(7);

                locationButton.disabled = false;
                locationButton.innerHTML = '<i class="bi bi-crosshair me-2"></i>Get Current Location';
            },
            function () {
                alert('Unable to get your current location. Please allow location access and try again.');

                locationButton.disabled = false;
                locationButton.innerHTML = '<i class="bi bi-crosshair me-2"></i>Get Current Location';
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    });
});
</script>

@endsection
