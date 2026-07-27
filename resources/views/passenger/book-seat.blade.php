@extends('layouts.app')

@section('content')
<style>
    :root {
        --primary-color: #3b82f6;
        --primary-hover: #2563eb;
        --primary-light: #eff6ff;
        --success-color: #10b981;
        --success-light: #ecfdf5;
    }

    /* Bus Cabin Design */
    .bus-cabin-wrapper {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 24px;
        padding: 20px;
        max-width: 300px;
        margin: 0 auto;
        position: relative;
    }

    .bus-front-indicator {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px dashed #e2e8f0;
        padding-bottom: 12px;
        margin-bottom: 20px;
    }

    .steering-wheel-container {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
    }

    .seat-grid-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        align-items: center;
    }

    .seat-aisle {
        height: 100%;
        min-height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .seat-aisle::after {
        content: '';
        width: 2px;
        height: 100%;
        background: repeating-linear-gradient(
            to bottom,
            transparent,
            transparent 4px,
            #e2e8f0 4px,
            #e2e8f0 8px
        );
    }

    .seat-empty {
        width: 35px;
        height: 35px;
    }

    /* Bus Seats styling */
    .seat-btn {
        position: relative;
        width: 36px;
        height: 36px;
        margin: 0 auto;
        border: 2px solid;
        border-radius: 6px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
        padding: 0;
        outline: none;
    }

    /* Available Seat State */
    .seat-available {
        border-color: var(--success-color);
        color: #047857;
        background-color: var(--success-light);
    }

    .seat-available:hover {
        transform: translateY(-2px);
        border-color: var(--primary-color);
        color: var(--primary-color);
        background-color: var(--primary-light);
    }

    /* Selected Seat State */
    .seat-selected {
        border-color: var(--primary-color) !important;
        color: #ffffff !important;
        background-color: var(--primary-color) !important;
        transform: scale(1.05);
    }

    /* Booked Seat State */
    .seat-booked {
        border-color: #e2e8f0 !important;
        color: #94a3b8 !important;
        background-color: #f1f5f9 !important;
        cursor: not-allowed;
    }

    /* Legend Indicator */
    .legend-badge {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 10px 15px;
    }

    .legend-indicator {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        border: 2px solid;
        display: inline-block;
    }
    .legend-available {
        border-color: var(--success-color);
        background-color: var(--success-light);
    }
    .legend-selected {
        border-color: var(--primary-color);
        background-color: var(--primary-color);
    }
    .legend-booked {
        border-color: #e2e8f0;
        background-color: #f1f5f9;
    }

    /* Selection Preview Box */
    .selection-preview-box {
        background-color: var(--primary-light);
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        border: 1px dashed rgba(59, 130, 246, 0.3);
        margin-bottom: 20px;
    }

    .btn-gradient-confirm {
        background: var(--primary-color);
        color: #ffffff;
        border: none;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        width: 100%;
        transition: all 0.2s;
    }

    .btn-gradient-confirm:hover:not(:disabled) {
        background: var(--primary-hover);
        color: #ffffff;
    }

    .btn-gradient-confirm:disabled {
        background: #cbd5e1;
        color: #94a3b8;
        cursor: not-allowed;
    }
</style>

<div class="container-fluid p-0">
    <!-- Top Back Navigation -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Select Seats</h3>
            <p class="text-muted mb-0">Choose your seat for the journey.</p>
        </div>
        <a href="/search-buses" class="btn btn-outline-secondary d-flex align-items-center gap-2">
            <i class="bi bi-arrow-left"></i> Back to Search
        </a>
    </div>

    <!-- Error Alerts -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert" style="border-left: 4px solid #dc3545 !important;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-5 me-2"></i>
                <div class="fw-medium">{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- LEFT: Seat Layout Map -->
        <div class="col-lg-6">
            <div class="card-box p-4 h-100 text-center">
                <h5 class="fw-bold mb-4 text-start">Bus Cabin Seat Layout</h5>
                
                <div class="bus-cabin-wrapper mb-4">
                    <div class="bus-front-indicator">
                        <span class="small text-muted fw-semibold">FRONT</span>
                        <div class="steering-wheel-container">
                            <i class="bi bi-shield-shaded" title="Driver Area"></i>
                        </div>
                    </div>

                    <div class="seat-grid-container">
                        @php
                            $capacity = $bus->capacity ?? 50;
                            $rows = ceil($capacity / 4);
                        @endphp
                        
                        @for ($row = 0; $row < $rows; $row++)
                            @for ($col = 1; $col <= 5; $col++)
                                @if ($col == 3)
                                    <div class="seat-aisle" title="Walkway Aisle"></div>
                                @else
                                    @php
                                        $offset = $col > 3 ? $col - 1 : $col;
                                        $seatNumber = ($row * 4) + $offset;
                                    @endphp
                                    
                                    @if ($seatNumber <= $capacity)
                                        <div>
                                            @if (in_array($seatNumber, $bookedSeats))
                                                <button type="button" class="seat-btn seat-booked" disabled data-seat="{{ $seatNumber }}" title="Seat {{ $seatNumber }} (Booked)">
                                                    {{ $seatNumber }}
                                                </button>
                                            @else
                                                <button type="button" class="seat-btn seat-available seat-btn-action" data-seat="{{ $seatNumber }}" title="Seat {{ $seatNumber }} (Available)">
                                                    {{ $seatNumber }}
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <div class="seat-empty"></div>
                                    @endif
                                @endif
                            @endfor
                        @endfor
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-center legend-badge mx-auto" style="max-width: 300px;">
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-indicator legend-available"></span>
                        <span class="small text-secondary fw-medium">Available</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-indicator legend-selected"></span>
                        <span class="small text-secondary fw-medium">Selected</span>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="legend-indicator legend-booked"></span>
                        <span class="small text-secondary fw-medium">Booked</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Booking Details & Info -->
        <div class="col-lg-6">
            <div class="card-box p-4 h-100">
                <h5 class="fw-bold mb-4">Journey & Ticket Details</h5>

                <!-- Simple Bus Info Table/Rows -->
                <div class="mb-4">
                    <div class="p-3 bg-light rounded-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">Route</span>
                            <span class="fw-bold">
                                @if($bus->route)
                                    {{ $bus->route->start_location }} to {{ $bus->route->end_location }}
                                @else
                                    Not Assigned
                                @endif
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">Bus Number</span>
                            <span class="fw-bold text-primary">{{ $bus->bus_number }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">Departure Time</span>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($bus->departure_time)->format('h:i A') }}</span>
                        </div>
                        @if($bus->route)
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary small">Distance</span>
                            <span class="fw-bold">{{ $bus->route->distance ?? 'N/A' }} km</span>
                        </div>
                        @endif
                    </div>
                </div>

                <form method="POST" action="/save-booking" id="bookingForm" autocomplete="off">
                    @csrf
                    <input type="hidden" name="bus_id" value="{{ $bus->id }}">
                    <input type="hidden" name="seat_no" id="seat_no" required>

                    <!-- Selection Preview Box -->
                    <div class="selection-preview-box">
                        <span class="d-block text-secondary small fw-semibold text-uppercase mb-1">Selected Seat</span>
                        <div id="selectedSeat" class="fs-3 fw-bold text-primary">None Selected</div>
                    </div>

                    <!-- Date Picker -->
                    <div class="mb-4">
                        <label for="journey_date" class="form-label fw-semibold text-secondary">Journey Date</label>
                        <input type="date" name="journey_date" id="journey_date" class="form-control" min="{{ date('Y-m-d') }}" value="{{ $travelDate }}" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-gradient-confirm w-100" id="confirmBtn" disabled>
                        <i class="bi bi-ticket-perforated-fill me-2"></i> Confirm Booking
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputSeatNo = document.getElementById('seat_no');
    const displaySeatVal = document.getElementById('selectedSeat');
    const confirmBtn = document.getElementById('confirmBtn');
    const journeyDateInput = document.getElementById('journey_date');

    function updateSeats(date) {
        fetch(`/get-booked-seats?bus_id={{ $bus->id }}&date=${date}`)
            .then(res => res.json())
            .then(bookedSeats => {
                // Clear selection
                inputSeatNo.value = "";
                displaySeatVal.innerHTML = "None Selected";
                confirmBtn.disabled = true;

                const buttons = document.querySelectorAll('.seat-btn');
                buttons.forEach(btn => {
                    const seatNo = parseInt(btn.dataset.seat);
                    if (!isNaN(seatNo)) {
                        if (bookedSeats.includes(seatNo)) {
                            btn.disabled = true;
                            btn.className = "seat-btn seat-booked";
                            btn.title = `Seat ${seatNo} (Booked)`;
                        } else {
                            btn.disabled = false;
                            btn.className = "seat-btn seat-available seat-btn-action";
                            btn.title = `Seat ${seatNo} (Available)`;
                        }
                    }
                });
                
                bindSeatListeners();
            });
    }

    function bindSeatListeners() {
        const activeButtons = document.querySelectorAll('.seat-btn-action');
        activeButtons.forEach(btn => {
            // Clone button to remove old event listeners to avoid duplicates
            const newBtn = btn.cloneNode(true);
            btn.replaceWith(newBtn);
            
            newBtn.addEventListener('click', function() {
                const isAlreadySelected = this.classList.contains('seat-selected');
                
                // Clear current selections on active buttons
                document.querySelectorAll('.seat-btn-action').forEach(b => {
                    b.classList.remove('seat-selected');
                    b.classList.add('seat-available');
                });
                
                if (isAlreadySelected) {
                    inputSeatNo.value = "";
                    displaySeatVal.innerHTML = "None Selected";
                    confirmBtn.disabled = true;
                } else {
                    this.classList.remove('seat-available');
                    this.classList.add('seat-selected');
                    
                    const selectedSeatNo = this.dataset.seat;
                    inputSeatNo.value = selectedSeatNo;
                    displaySeatVal.innerHTML = "Seat #" + selectedSeatNo;
                    confirmBtn.disabled = false;
                }
            });
        });
    }

    if (journeyDateInput) {
        journeyDateInput.addEventListener('change', function() {
            updateSeats(this.value);
        });
    }

    // Initial bind
    bindSeatListeners();
});
</script>
@endsection
