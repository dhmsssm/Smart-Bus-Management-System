<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Search Buses - BusLink</title>

<!-- Bootstrap 5.3.3 & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --primary: #4f46e5;
        --primary-hover: #4338ca;
        --primary-light: #6366f1;
        --accent: #06b6d4;
        --accent-hover: #0891b2;
        --success: #10b981;
        --dark: #0f172a;
        --slate-100: #f1f5f9;
        --slate-200: #e2e8f0;
        --bg-light: #fafbff;
        --font-main: 'Plus Jakarta Sans', sans-serif;
        --font-heading: 'Outfit', sans-serif;
    }

    body {
        background-color: var(--bg-light);
        color: var(--dark);
        font-family: var(--font-main);
        min-height: 100vh;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: var(--font-heading);
        font-weight: 700;
    }

    .navbar-brand {
        font-family: var(--font-heading);
        font-weight: 800;
        font-size: 1.6rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        background: white;
    }

    .search-card {
        padding: 30px;
        border: 1px solid var(--slate-200);
    }

    .btn-primary-gradient {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-light) 100%);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        color: white;
    }

    .table thead {
        background: var(--slate-100);
        color: var(--dark);
    }

    .table th {
        font-weight: 600;
        border-bottom: 2px solid var(--slate-200);
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 30px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-active {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }

    .status-inactive {
        background-color: rgba(100, 116, 139, 0.1);
        color: #64748b;
    }

    .bus-card {
        transition: all 0.3s ease;
        border: 1px solid var(--slate-200);
    }

    .bus-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        border-color: var(--primary-light);
    }
</style>
</head>
<body>

<!-- Header Navigation -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-bus-front-fill"></i> BusLink
        </a>
        <div class="d-flex gap-2">
            @if(Auth::check())
                <a href="/passenger/dashboard" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-grid-fill me-1"></i> Dashboard
                </a>
            @else
                <a href="/login" class="btn btn-outline-secondary rounded-pill px-4">Login</a>
                <a href="/register" class="btn btn-primary-gradient rounded-pill px-4">Register</a>
            @endif
        </div>
    </div>
</nav>

<div class="container py-4">

    <!-- Title and Search Section -->
    <div class="card search-card mb-5">
        <h4 class="mb-4 text-center text-lg-start"><i class="bi bi-search text-primary me-2"></i>Find Available Buses</h4>
        <form method="POST" action="/search-buses">
            @csrf
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-secondary">Departure Location</label>
                    <select name="from" class="form-select border-2 p-2.5 rounded-3" required>
                        <option value="" disabled selected>Select origin location</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->start_location }}" {{ (isset($buses) && count($buses) > 0 && $buses->first()->route->start_location == $route->start_location) ? 'selected' : '' }}>
                                {{ $route->start_location }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-secondary">Destination Location</label>
                    <select name="to" class="form-select border-2 p-2.5 rounded-3" required>
                        <option value="" disabled selected>Select destination location</option>
                        @foreach($routes as $route)
                            <option value="{{ $route->end_location }}" {{ (isset($buses) && count($buses) > 0 && $buses->first()->route->end_location == $route->end_location) ? 'selected' : '' }}>
                                {{ $route->end_location }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary-gradient w-100 py-2.5 rounded-3 fw-bold">
                        <i class="bi bi-search me-1"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Search Results Section -->
    @isset($buses)
        <div class="mb-4">
            <h4 class="fw-bold mb-4"><i class="bi bi-bus-front text-primary me-2"></i>Matching Search Results</h4>
            
            <div class="row g-4">
                @forelse($buses as $bus)
                    @php
                        // Estimate travel/arrival time
                        $departure = \Carbon\Carbon::parse($bus->departure_time);
                        $distance = $bus->route->distance ?? 100;
                        $durationMinutes = ($distance / 50) * 60; // 50 km/h average
                        $arrival = $departure->copy()->addMinutes($durationMinutes);

                        // Count actual booked seats
                        $bookedCount = \App\Models\Booking::where('bus_id', $bus->id)->count();
                        $availableSeats = max(0, $bus->capacity - $bookedCount);

                        // Price calculation based on distance
                        $ticketPrice = $distance * 8.50;
                    @endphp

                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 bus-card">
                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title fw-bold mb-0" style="color: var(--dark);">
                                        <i class="bi bi-bus-front-fill text-primary me-2"></i>SmartBus {{ $bus->bus_number }}
                                    </h5>
                                    <span class="status-badge {{ $bus->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                        {{ ucfirst($bus->status) }}
                                    </span>
                                </div>

                                <p class="text-secondary small fw-medium mb-4">
                                    <i class="bi bi-signpost-split me-1 text-primary"></i>
                                    {{ $bus->route->start_location }} &rarr; {{ $bus->route->end_location }}
                                </p>

                                <div class="bg-light rounded-3 p-3 mb-4">
                                    <div class="row g-2 text-center">
                                        <div class="col-6 border-end">
                                            <span class="d-block text-secondary small">Departure</span>
                                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                <i class="bi bi-clock me-1 text-primary"></i>{{ $departure->format('h:i A') }}
                                            </span>
                                        </div>
                                        <div class="col-6">
                                            <span class="d-block text-secondary small">Arrival</span>
                                            <span class="fw-bold text-dark" style="font-size: 0.9rem;">
                                                <i class="bi bi-clock-fill me-1 text-accent"></i>{{ $arrival->format('h:i A') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div>
                                        <span class="text-secondary small d-block">Available Seats</span>
                                        <span class="fw-bold text-success" style="font-size: 1.1rem;">
                                            <i class="bi bi-grid-3x3-gap-fill me-1"></i>{{ $availableSeats }} / {{ $bus->capacity }}
                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-secondary small d-block">Ticket Price</span>
                                        <span class="fw-extrabold text-primary" style="font-size: 1.25rem; font-family: var(--font-heading);">
                                            Rs. {{ number_format($ticketPrice, 2) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <a href="/book-seat/{{ $bus->id }}?date={{ $travelDate }}" class="btn btn-primary-gradient w-100 py-2.5 rounded-3 fw-bold">
                                        <i class="bi bi-ticket-perforated me-1"></i> Book Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card p-5 text-center text-muted">
                            <i class="bi bi-exclamation-circle text-warning mb-3" style="font-size: 3rem;"></i>
                            <h5>No buses found for this route</h5>
                            <p class="small">Try searching with other origin or destination locations.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endisset

</div>

</body>
</html>