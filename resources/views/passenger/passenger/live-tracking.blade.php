@extends('layouts.app')

@section('content')

<style>

.live-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.live-title{
    font-size:30px;
    font-weight:700;
}

.live-status{
    background:#16C47F;
    color:#fff;
    padding:8px 18px;
    border-radius:30px;
    font-size:14px;
    font-weight:600;
}

.map-card{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 10px 25px rgba(0,0,0,.08);
}

.map-header{
    padding:18px 25px;
    border-bottom:1px solid #eee;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.map-title{
    font-size:22px;
    font-weight:600;
}

#map{
    width:100%;
    height:550px;
}

.bottom-section{
    margin-top:25px;
}

.bus-card{
    background:#fff;
    border-radius:18px;
    padding:20px;
    box-shadow:0 8px 20px rgba(0,0,0,.06);
    margin-bottom:20px;
}

.bus-card h5{
    font-weight:700;
    margin-bottom:15px;
}

.bus-info{
    display:flex;
    justify-content:space-between;
    padding:8px 0;
    border-bottom:1px solid #eee;
}

.status-on{
    color:#16C47F;
    font-weight:600;
}

</style>

<div class="container-fluid">

    <div class="live-header">

        <div>

            <div class="live-title">
                Live Bus Tracking
            </div>

            <small class="text-muted">
                Real-time monitoring of all buses
            </small>

        </div>

        <div class="live-status">
            LIVE
        </div>

    </div>

    <div class="map-card">

        <div class="map-header">

            <div class="map-title">
                Live Map
            </div>

            <div>

                Active Buses :
                <strong>{{ $locations->count() }}</strong>

            </div>

        </div>

        <div id="map"></div>

    </div>

    <div class="row bottom-section">

        @forelse($locations as $location)

            <div class="col-lg-4 col-md-6">

                <div class="bus-card">

                    <h5>
                        {{ $location->bus->bus_number ?? 'Bus' }}
                    </h5>

                    <div class="bus-info">
                        <span>Latitude</span>
                        <strong>{{ $location->latitude }}</strong>
                    </div>

                    <div class="bus-info">
                        <span>Longitude</span>
                        <strong>{{ $location->longitude }}</strong>
                    </div>

                    <div class="bus-info">
                        <span>Status</span>
                        <strong class="status-on">{{ $location->status }}</strong>
                    </div>

                </div>

            </div>

        @empty

            <div class="col-lg-12">

                <div class="card-box p-4 text-muted">
                    No live bus locations available.
                </div>

            </div>

        @endforelse

    </div>

</div>

<link rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>

var map = L.map('map').setView(
    [6.9271, 79.8612],
    11
);

L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution: 'OpenStreetMap'
    }
).addTo(map);

var busIcon = L.icon({
    iconUrl: 'https://cdn-icons-png.flaticon.com/512/3448/3448339.png',
    iconSize: [38, 38],
    iconAnchor: [19, 38],
    popupAnchor: [0, -38]
});

@foreach($locations as $location)

    L.marker(
        [
            {{ $location->latitude }},
            {{ $location->longitude }}
        ],
        {
            icon: busIcon
        }
    )
    .addTo(map)
    .bindPopup(`
        <div style="width:220px;">
            <h6 class="fw-bold text-success">
                {{ $location->bus->bus_number ?? 'Bus' }}
            </h6>
            <hr>
            <b>Latitude</b><br>
            {{ $location->latitude }}
            <br><br>
            <b>Longitude</b><br>
            {{ $location->longitude }}
            <br><br>
            <b>Status</b><br>
            <span style="color:green;">
                {{ $location->status }}
            </span>
        </div>
    `);

@endforeach

@if($locations->count())

    map.setView(
        [
            {{ $locations->first()->latitude }},
            {{ $locations->first()->longitude }}
        ],
        13
    );

@endif

</script>

@endsection
