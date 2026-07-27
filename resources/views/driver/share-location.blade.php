@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h5 class="fw-bold mb-4">Share Location</h5>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">Please check the location details and try again.</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card-box p-4 h-100">
                <h6 class="fw-bold mb-4">Current Trip</h6>

                @if($bus)
                    <div class="d-flex justify-content-between border-bottom py-3">
                        <span class="text-muted">Bus</span>
                        <strong>{{ $bus->bus_number }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-3">
                        <span class="text-muted">Route</span>
                        <strong>{{ $bus->route->start_location ?? 'N/A' }} to {{ $bus->route->end_location ?? 'N/A' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom py-3">
                        <span class="text-muted">Last Status</span>
                        <strong>{{ $location->status ?? 'Not shared' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between py-3">
                        <span class="text-muted">Last Update</span>
                        <strong>{{ $location ? $location->updated_at->diffForHumans() : 'Never' }}</strong>
                    </div>
                @else
                    <p class="text-muted mb-0">No bus is assigned to your account.</p>
                @endif
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card-box p-4">
                <h6 class="fw-bold mb-4">Live Location</h6>

                @if($bus)
                    <form method="POST" action="/driver/location">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Latitude</label>
                                <input id="latitude" type="text" class="form-control" name="latitude" value="{{ old('latitude', $location->latitude ?? '6.927079') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Longitude</label>
                                <input id="longitude" type="text" class="form-control" name="longitude" value="{{ old('longitude', $location->longitude ?? '79.861244') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Speed (km/h)</label>
                                <input type="number" class="form-control" name="speed" min="0" max="160" value="{{ old('speed', $location->speed ?? 0) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status" required>
                                    <option {{ old('status', $location->status ?? '') === 'On Time' ? 'selected' : '' }}>On Time</option>
                                    <option {{ old('status', $location->status ?? '') === 'Delayed' ? 'selected' : '' }}>Delayed</option>
                                    <option {{ old('status', $location->status ?? '') === 'Stopped' ? 'selected' : '' }}>Stopped</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex flex-wrap gap-2 mt-4">
                            <button type="button" class="btn btn-outline-success" id="useGps">
                                <i class="bi bi-crosshair me-2"></i>
                                Use My GPS
                            </button>

                            <button class="btn btn-success">
                                <i class="bi bi-geo-alt-fill me-2"></i>
                                Share Location
                            </button>
                        </div>
                    </form>
                @else
                    <p class="text-muted mb-0">Location sharing is disabled until a bus is assigned.</p>
                @endif
            </div>
        </div>
    </div>

</div>

<script>
const gpsButton = document.getElementById('useGps');

if (gpsButton) {
    gpsButton.addEventListener('click', function () {
        if (!navigator.geolocation) {
            alert('GPS is not available in this browser.');
            return;
        }

        navigator.geolocation.getCurrentPosition(function (position) {
            document.getElementById('latitude').value = position.coords.latitude.toFixed(7);
            document.getElementById('longitude').value = position.coords.longitude.toFixed(7);
        }, function () {
            alert('Unable to read your GPS location.');
        });
    });
}
</script>

@endsection
