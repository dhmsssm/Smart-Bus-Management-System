<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookings Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fff;
            color: #333;
            padding: 20px;
        }
        .report-header {
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .print-btn {
            margin-bottom: 20px;
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center print-btn">
            <a href="/admin/dashboard" class="btn btn-secondary">&larr; Back to Dashboard</a>
            <button onclick="window.print()" class="btn btn-primary">Print / Save as PDF</button>
        </div>

        <div class="report-header text-center">
            <h2>SmartBus - Bookings Report</h2>
            <p class="text-muted">Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Booking ID</th>
                    <th>Passenger Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Bus Number</th>
                    <th>Route</th>
                    <th>Seat No</th>
                    <th>Journey Date</th>
                    <th>Status</th>
                    <th>Booked At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->passenger_name }}</td>
                    <td>{{ $booking->passenger_email }}</td>
                    <td>{{ $booking->passenger_phone }}</td>
                    <td>{{ $booking->bus_number }}</td>
                    <td>{{ $booking->start_location }} to {{ $booking->end_location }}</td>
                    <td>{{ $booking->seat_no }}</td>
                    <td>{{ $booking->journey_date }}</td>
                    <td>
                        <span class="badge bg-{{ $booking->status == 'cancelled' ? 'danger' : 'success' }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>{{ $booking->created_at }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No Bookings Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        // Automatically trigger print dialog on page load
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
