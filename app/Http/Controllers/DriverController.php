<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bus;
use App\Models\BusLocation;
use App\Models\Driver;
use App\Models\DriverTrip;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function dashboard()
    {
        $driver = Auth::user();
        $driverProfile = Driver::where('user_id', Auth::id())->first();

        $bus = $this->assignedBus(['route']);

        $today = now()->toDateString();

        $totalBookings = 0;
        $todayBookings = 0;
        $upcomingBookings = 0;
        $recentBookings = collect();
        $todayPassengers = collect();
        $location = null;
        $bookedSeats = 0;
        $availableSeats = 0;
        $occupancyPercent = 0;

        if ($bus) {
            $bookingQuery = Booking::where('bus_id', $bus->id);

            $totalBookings = (clone $bookingQuery)->count();
            $todayBookings = (clone $bookingQuery)
                ->whereDate('journey_date', $today)
                ->where('status', 'confirmed')
                ->count();
            $upcomingBookings = (clone $bookingQuery)
                ->whereDate('journey_date', '>=', $today)
                ->where('status', 'confirmed')
                ->count();

            $todayPassengers = Booking::join('users', 'bookings.user_id', '=', 'users.id')
                ->where('bookings.bus_id', $bus->id)
                ->whereDate('bookings.journey_date', $today)
                ->where('bookings.status', 'confirmed')
                ->select(
                    'bookings.*',
                    'users.name as passenger_name',
                    'users.phone as passenger_phone'
                )
                ->orderBy('bookings.seat_no')
                ->get();

            $recentBookings = Booking::join('users', 'bookings.user_id', '=', 'users.id')
                ->where('bookings.bus_id', $bus->id)
                ->select(
                    'bookings.*',
                    'users.name as passenger_name',
                    'users.phone as passenger_phone'
                )
                ->latest('bookings.created_at')
                ->limit(5)
                ->get();

            $location = BusLocation::where('bus_id', $bus->id)->first();
            $bookedSeats = $todayPassengers->count();
            $availableSeats = max($bus->capacity - $bookedSeats, 0);
            $occupancyPercent = $bus->capacity > 0
                ? round(($bookedSeats / $bus->capacity) * 100)
                : 0;
        }

        return view('driver.dashboard', compact(
            'driver',
            'bus',
            'totalBookings',
            'todayBookings',
            'upcomingBookings',
            'recentBookings',
            'todayPassengers',
            'location',
            'bookedSeats',
            'availableSeats',
            'occupancyPercent',
            'driverProfile'
        ));
    }

    public function location()
    {
        $driver = Auth::user();
        $bus = $this->assignedBus(['route', 'location']);
        $location = $bus?->location;

        return view('driver.location', compact(
            'driver',
            'bus',
            'location'
        ));
    }

    public function myBus()
    {
        $driver = Auth::user();
        $bus = $this->assignedBus(['route']);

        $routes = \App\Models\Route::all();

        return view('driver.my-bus', compact(
            'driver',
            'bus',
            'routes'
        ));
    }

    public function addBus(Request $request)
    {
        $request->validate([
            'bus_number' => 'required|string|max:255|unique:buses,bus_number',
            'capacity' => 'required|integer|min:1|max:120',
            'route_id' => 'required|exists:routes,id',
            'departure_time' => 'nullable',
        ]);

        $driverProfile = \App\Models\Driver::where('user_id', Auth::id())->first();

        Bus::create([
            'bus_number' => $request->bus_number,
            'capacity' => $request->capacity,
            'route_id' => $request->route_id,
            'driver_id' => $driverProfile ? $driverProfile->id : null,
            'status' => 'active',
            'departure_time' => $request->departure_time
        ]);

        return back()->with('success', 'Bus added and assigned to you successfully.');
    }

    public function addRoute(Request $request)
    {
        $request->validate([
            'route_name' => 'required|string|max:255',
            'start_location' => 'required|string|max:255',
            'end_location' => 'required|string|max:255',
            'distance' => 'required|numeric|min:0.1'
        ]);

        \App\Models\Route::create([
            'route_name' => $request->route_name,
            'start_location' => $request->start_location,
            'end_location' => $request->end_location,
            'distance' => $request->distance
        ]);

        return back()->with('success', 'Route added successfully.');
    }

    public function myRoute()
    {
        $driver = Auth::user();
        $bus = $this->assignedBus(['route']);

        $route = $bus?->route;
        $estimatedTime = 'Not Available';
        $routeStatus = $bus && $bus->status === 'active'
            ? 'Active'
            : 'Inactive';

        if ($route && isset($route->estimated_travel_time)) {
            $estimatedTime = $route->estimated_travel_time;
        } elseif ($route && $route->distance) {
            $minutes = (int) ceil(((float) $route->distance / 40) * 60);
            $hours = intdiv($minutes, 60);
            $remainingMinutes = $minutes % 60;

            $estimatedTime = $hours > 0
                ? trim($hours . ' hr ' . ($remainingMinutes ? $remainingMinutes . ' min' : ''))
                : $minutes . ' min';
        }

        return view('driver.my-route', compact(
            'driver',
            'bus',
            'route',
            'estimatedTime',
            'routeStatus'
        ));
    }

    public function myTrip()
    {
        $driver = Auth::user();
        $bus = $this->assignedBus(['route']);
        $activeTrip = null;
        $recentTrips = collect();

        if ($bus) {
            $activeTrip = DriverTrip::where('driver_id', Auth::id())
                ->where('bus_id', $bus->id)
                ->where('status', 'Started')
                ->latest('start_time')
                ->first();

            $recentTrips = DriverTrip::with(['bus', 'route'])
                ->where('driver_id', Auth::id())
                ->latest('start_time')
                ->limit(8)
                ->get();
        }

        return view('driver.my-trip', compact(
            'driver',
            'bus',
            'activeTrip',
            'recentTrips'
        ));
    }

    public function tripHistory()
    {
        $driver = Auth::user();

        $trips = DriverTrip::with(['bus', 'route'])
            ->where('driver_id', Auth::id())
            ->latest('start_time')
            ->get();

        return view('driver.trip-history', compact(
            'driver',
            'trips'
        ));
    }

    public function shareLocation()
    {
        $driver = Auth::user();
        $bus = $this->assignedBus(['route']);
        $location = null;

        if ($bus) {
            $location = BusLocation::where('bus_id', $bus->id)->first();
        }

        return view('driver.share-location', compact(
            'driver',
            'bus',
            'location'
        ));
    }

    public function notifications()
    {
        $driver = Auth::user();

        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('driver.notifications', compact(
            'driver',
            'notifications'
        ));
    }

    public function markNotificationAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update([
            'read_at' => now()
        ]);

        return back()->with('success', 'Notification marked as read.');
    }

    public function deleteNotification(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->delete();

        return back()->with('success', 'Notification deleted successfully.');
    }

    public function profile()
    {
        $driver = Auth::user();
        $driverProfile = Driver::where('user_id', Auth::id())->first();
        $bus = $this->assignedBus(['route']);

        return view('driver.profile', compact(
            'driver',
            'driverProfile',
            'bus'
        ));
    }

    public function updateProfile(Request $request)
    {
        $driver = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($driver->id)
            ],
            'phone' => 'nullable|string|max:30',
            'license_no' => 'required|string|max:255',
            'password' => 'nullable|string|min:6|confirmed'
        ]);

        $driver->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);

        if ($request->filled('password')) {
            $driver->update([
                'password' => Hash::make($request->password)
            ]);
        }

        Driver::updateOrCreate(
            [
                'user_id' => $driver->id
            ],
            [
                'license_no' => $request->license_no
            ]
        );

        return back()->with('success', 'Driver profile updated successfully.');
    }

    public function updateBusDetails(Request $request)
    {
        $bus = $this->assignedBus();

        if (! $bus) {
            return back()->with('error', 'No bus is assigned to your account.');
        }

        $request->validate([
            'bus_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('buses', 'bus_number')->ignore($bus->id)
            ],
            'capacity' => 'required|integer|min:1|max:120',
            'departure_time' => 'nullable',
            'status' => 'required|in:active,maintenance,inactive'
        ]);

        $bus->update([
            'bus_number' => $request->bus_number,
            'capacity' => $request->capacity,
            'departure_time' => $request->departure_time,
            'status' => $request->status
        ]);

        return back()->with('success', 'Bus details updated successfully.');
    }

    public function passengers()
    {
        $driver = Auth::user();
        $bus = $this->assignedBus(['route']);
        $passengers = collect();

        if ($bus) {
            $passengers = Booking::join('users', 'bookings.user_id', '=', 'users.id')
                ->where('bookings.bus_id', $bus->id)
                ->select(
                    'bookings.*',
                    'users.name as passenger_name',
                    'users.email as passenger_email',
                    'users.phone as passenger_phone'
                )
                ->orderBy('bookings.journey_date')
                ->orderBy('bookings.seat_no')
                ->get();
        }

        return view('driver.passengers', compact(
            'driver',
            'bus',
            'passengers'
        ));
    }

    public function status()
    {
        $driver = Auth::user();
        $bus = $this->assignedBus(['route']);
        $location = null;

        if ($bus) {
            $location = BusLocation::where('bus_id', $bus->id)->first();
        }

        return view('driver.status', compact(
            'driver',
            'bus',
            'location'
        ));
    }

    public function updateStatus(Request $request)
    {
        $bus = $this->assignedBus();

        if (! $bus) {
            return back()->with('error', 'No bus is assigned to your account.');
        }

        $request->validate([
            'status' => 'required|in:active,maintenance,inactive'
        ]);

        $bus->update([
            'status' => $request->status
        ]);

        return redirect('/driver/status')
            ->with('success', 'Bus status updated successfully.');
    }

    public function startTrip(Request $request)
    {
        $bus = $this->assignedBus();

        if (! $bus) {
            return back()->with('error', 'No bus is assigned to your account.');
        }

        $activeTrip = DriverTrip::where('driver_id', Auth::id())
            ->where('bus_id', $bus->id)
            ->where('status', 'Started')
            ->first();

        if ($activeTrip) {
            return back()->with('error', 'A trip is already started for this bus.');
        }

        DriverTrip::create([
            'driver_id' => Auth::id(),
            'bus_id' => $bus->id,
            'route_id' => $bus->route_id,
            'start_time' => now(),
            'status' => 'Started'
        ]);

        $bus->update([
            'status' => 'active'
        ]);

        $this->saveTripLocation($bus, [
            'status' => 'On Time'
        ]);

        return redirect('/driver/my-trip')
            ->with('success', 'Trip started successfully.');
    }

    public function reportDelay()
    {
        $bus = $this->assignedBus();

        if (! $bus) {
            return back()->with('error', 'No bus is assigned to your account.');
        }

        $this->saveTripLocation($bus, [
            'status' => 'Delayed'
        ]);

        return back()->with('success', 'Trip marked as delayed.');
    }

    public function markOnTime()
    {
        $bus = $this->assignedBus();

        if (! $bus) {
            return back()->with('error', 'No bus is assigned to your account.');
        }

        $bus->update([
            'status' => 'active'
        ]);

        $this->saveTripLocation($bus, [
            'status' => 'On Time'
        ]);

        return back()->with('success', 'Trip marked as on time.');
    }

    public function endTrip()
    {
        $bus = $this->assignedBus();

        if (! $bus) {
            return back()->with('error', 'No bus is assigned to your account.');
        }

        $activeTrip = DriverTrip::where('driver_id', Auth::id())
            ->where('bus_id', $bus->id)
            ->where('status', 'Started')
            ->latest('start_time')
            ->first();

        if (! $activeTrip) {
            return back()->with('error', 'No started trip found to complete.');
        }

        $activeTrip->update([
            'end_time' => now(),
            'status' => 'Completed'
        ]);

        $bus->update([
            'status' => 'inactive'
        ]);

        $this->saveTripLocation($bus, [
            'speed' => 0,
            'status' => 'Stopped'
        ]);

        return redirect('/driver/my-trip')
            ->with('success', 'Trip completed successfully.');
    }

    public function updateLocation(Request $request)
    {
        $driver = Auth::user();
        $bus = $this->assignedBus(['location']);

        if (! $bus) {
            return back()->with('error', 'No bus is assigned to your account.');
        }

        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180'
        ]);

        $currentLocation = $bus->location;

        $bus->location()->updateOrCreate(
            [],
            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'speed' => $currentLocation->speed ?? 0,
                'status' => $currentLocation->status ?? 'On Time'
            ]
        );

        return redirect('/driver/location')
            ->with('success', 'Live location updated successfully.');
    }

    private function assignedBus(array $with = [])
    {
        $driverIds = [Auth::id()];
        $driverProfile = Driver::where('user_id', Auth::id())->first();

        if ($driverProfile) {
            $driverIds[] = $driverProfile->id;
        }

        return Bus::with($with)
            ->whereIn('driver_id', array_unique($driverIds))
            ->first();
    }

    private function saveTripLocation(Bus $bus, array $data): void
    {
        $current = BusLocation::where('bus_id', $bus->id)->first();

        BusLocation::updateOrCreate(
            [
                'bus_id' => $bus->id
            ],
            [
                'latitude' => $data['latitude'] ?? $current->latitude ?? 6.927079,
                'longitude' => $data['longitude'] ?? $current->longitude ?? 79.861244,
                'speed' => $data['speed'] ?? $current->speed ?? 0,
                'status' => $data['status'] ?? $current->status ?? 'On Time'
            ]
        );
    }
}
