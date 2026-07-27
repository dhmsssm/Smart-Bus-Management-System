@extends('layouts.app')

@section('content')
<!-- Leaflet Map CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">
                <i class="bi bi-geo-alt-fill text-danger"></i> Live Fleet Tracking
            </h2>
            <p class="text-muted">Real-time bus tracking and location simulation</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Sidebar - Bus Status List & Update Form -->
        <div class="col-lg-4">
            <!-- Active Fleet List -->
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">🚍 Active Fleet List</h5>
                </div>
                <div class="card-body p-0" style="max-height: 300px; overflow-y: auto;">
                    <div class="list-group list-group-flush">
                        @forelse($buses as $bus)
                            @php
                                $loc = $bus->location;
                                $lat = $loc ? $loc->latitude : 6.927079;
                                $lng = $loc ? $loc->longitude : 79.861244;
                                $speed = $loc ? $loc->speed : 0;
                                $status = $loc ? $loc->status : 'Stopped';
                                
                                $statusClass = 'bg-secondary';
                                if (in_array(strtolower($status), ['moving', 'on time', 'active'])) {
                                    $statusClass = 'bg-success';
                                } elseif (in_array(strtolower($status), ['delayed', 'warning'])) {
                                    $statusClass = 'bg-warning text-dark';
                                } elseif (in_array(strtolower($status), ['stopped', 'inactive'])) {
                                    $statusClass = 'bg-danger';
                                }
                            @endphp
                            <button class="list-group-item list-group-item-action p-3 d-flex justify-content-between align-items-center border-0 border-bottom"
                                    onclick="focusBus({{ $lat }}, {{ $lng }}, '{{ $bus->bus_number }}', '{{ $status }}', {{ $speed }})">
                                <div>
                                    <strong class="text-primary">{{ $bus->bus_number }}</strong>
                                    <div class="text-muted small mt-1">
                                        <i class="bi bi-pin-map-fill text-danger"></i> {{ number_format($lat, 4) }}, {{ number_format($lng, 4) }}
                                    </div>
                                </div>
                                <div class="text-end">
                                    <span class="badge {{ $statusClass }} rounded-pill mb-1">{{ ucfirst($status) }}</span>
                                    <div class="text-muted small">{{ $speed }} km/h</div>
                                </div>
                            </button>
                        @empty
                            <div class="p-3 text-center text-muted">No buses registered.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Update Location Simulator -->
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">⚡ Update / Simulate Location</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="/admin/bus-location">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Select Bus</label>
                            <select class="form-select rounded-3" name="bus_id" id="simulate_bus_id">
                                @foreach($buses as $bus)
                                    <option value="{{ $bus->id }}" data-lat="{{ $bus->location->latitude ?? 6.927079 }}" data-lng="{{ $bus->location->longitude ?? 79.861244 }}" data-speed="{{ $bus->location->speed ?? 45 }}" data-status="{{ $bus->location->status ?? 'On Time' }}">
                                        {{ $bus->bus_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Latitude</label>
                                <input type="text" class="form-control rounded-3" name="latitude" id="simulate_lat" value="6.927079" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Longitude</label>
                                <input type="text" class="form-control rounded-3" name="longitude" id="simulate_lng" value="79.861244" required>
                            </div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">Speed (km/h)</label>
                                <input type="number" class="form-control rounded-3" name="speed" id="simulate_speed" value="45" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Status</label>
                                <select class="form-select rounded-3" name="status" id="simulate_status">
                                    <option value="On Time">On Time</option>
                                    <option value="Delayed">Delayed</option>
                                    <option value="Stopped">Stopped</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-3 py-2">
                            <i class="bi bi-arrow-repeat"></i> Update Location
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-2">
                    <div id="map" style="height: 575px; border-radius: 12px; z-index: 1;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet Map JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialize the Map centered on Colombo
    const map = L.map('map').setView([6.9271, 79.8612], 12);

    // Map style / tile provider (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Store markers in an object
    const markers = {};

    // Bus Locations Data from database
    const busesData = [
        @foreach($buses as $bus)
            @php
                $loc = $bus->location;
                $lat = $loc ? $loc->latitude : null;
                $lng = $loc ? $loc->longitude : null;
                $speed = $loc ? $loc->speed : 0;
                $status = $loc ? $loc->status : 'Stopped';
            @endphp
            @if($lat && $lng)
            {
                id: {{ $bus->id }},
                bus_number: "{{ $bus->bus_number }}",
                lat: {{ $lat }},
                lng: {{ $lng }},
                speed: {{ $speed }},
                status: "{{ $status }}"
            },
            @endif
        @endforeach
    ];

    // Create markers for each bus
    busesData.forEach(bus => {
        const statusColor = getStatusColor(bus.status);
        
        // Custom marker icon
        const busIcon = L.divIcon({
            html: `<div style="background-color: ${statusColor}; width: 24px; height: 24px; border-radius: 50%; border: 3px solid white; box-shadow: 0 0 8px rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; color: white; font-size: 10px; font-weight: bold;"><i class="bi bi-bus-front"></i></div>`,
            className: 'custom-bus-marker',
            iconSize: [24, 24],
            iconAnchor: [12, 12]
        });

        const marker = L.marker([bus.lat, bus.lng], { icon: busIcon })
            .bindPopup(`
                <div style="font-family: 'Poppins', sans-serif;">
                    <h6 class="fw-bold mb-1">${bus.bus_number}</h6>
                    <p class="mb-0 text-muted small">Status: <strong>${bus.status}</strong></p>
                    <p class="mb-0 text-muted small">Speed: <strong>${bus.speed} km/h</strong></p>
                    <p class="mb-0 text-muted small">Coords: ${bus.lat.toFixed(4)}, ${bus.lng.toFixed(4)}</p>
                </div>
            `)
            .addTo(map);

        markers[`${bus.lat}_${bus.lng}`] = marker;
    });

    function getStatusColor(status) {
        const lower = status.toLowerCase();
        if (lower === 'moving' || lower === 'on time' || lower === 'active') return '#198754'; // success
        if (lower === 'delayed' || lower === 'warning') return '#ffc107'; // warning
        return '#dc3545'; // danger/stopped
    }

    // Function to pan map and zoom to clicked bus
    function focusBus(lat, lng, busNo, status, speed) {
        map.setView([lat, lng], 15);
        
        // Find existing marker or create a temporary one to open popup
        const key = `${lat}_${lng}`;
        if (markers[key]) {
            markers[key].openPopup();
        } else {
            L.popup()
                .setLatLng([lat, lng])
                .setContent(`
                    <div style="font-family: 'Poppins', sans-serif;">
                        <h6 class="fw-bold mb-1">${busNo}</h6>
                        <p class="mb-0 text-muted small">Status: <strong>${status}</strong></p>
                        <p class="mb-0 text-muted small">Speed: <strong>${speed} km/h</strong></p>
                    </div>
                `)
                .openOn(map);
        }
    }

    // Autofill simulation inputs when select box changes
    const simulateSelect = document.getElementById('simulate_bus_id');
    function updateSimulationFields() {
        const selectedOpt = simulateSelect.options[simulateSelect.selectedIndex];
        if (selectedOpt) {
            document.getElementById('simulate_lat').value = selectedOpt.getAttribute('data-lat');
            document.getElementById('simulate_lng').value = selectedOpt.getAttribute('data-lng');
            document.getElementById('simulate_speed').value = selectedOpt.getAttribute('data-speed');
            document.getElementById('simulate_status').value = selectedOpt.getAttribute('data-status');
        }
    }
    simulateSelect.addEventListener('change', updateSimulationFields);
    
    // Call initially to set values
    updateSimulationFields();
</script>
@endsection