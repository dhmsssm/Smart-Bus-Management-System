<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bus;
use App\Models\Route;
use App\Models\User;
use App\Models\Booking;
use App\Models\Notification;
use App\Models\BusLocation;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    private function authorizeAdmin()
    {
        //if (! Auth::check()) {
          //  return redirect('/admin/login');
        //}

        //if (Auth::user()->role !== 'admin') {
          //  abort(403, 'Admin access only.');
        //}

        return null;
    }

    // ==========================
    // Admin Dashboard
    // ==========================

   public function dashboard()
    {
        if ($response = $this->authorizeAdmin()) {
          return $response;
        }

       $busesCount = Bus::count();

        $routesCount = Route::count();

        $driversCount = User::where('role', 'driver')->count();

        $passengersCount = User::where('role', 'passenger')->count();

        $bookingsCount = Booking::count();

        $notificationsCount = Notification::count();

        $recentBookings = Booking::join(
                'buses',
                'bookings.bus_id',
                '=',
                'buses.id'
            )
            ->join(
                'users',
                'bookings.user_id',
                '=',
                'users.id'
            )
            ->select(
                'bookings.*',
                'buses.bus_number',
                'users.name'
            )
            ->latest('bookings.created_at')
            ->take(5)
            ->get();

        $buses = Bus::with('location')->get();

        return view(
            'admin.dashboard',
            compact(
                'busesCount',
                'routesCount',
                'driversCount',
                'passengersCount',
                'bookingsCount',
                'notificationsCount',
                'recentBookings',
                'buses'
            )
       );
    }

    // ==========================
    // Bus Location Page
    // ==========================

    public function busLocation()
    {
        if ($response = $this->authorizeAdmin()) {
            return $response;
        }

        $buses = Bus::with('location')->get();

        return view(
            'admin.bus-location',
            compact('buses')
        );
    }

    // ==========================
    // Save Bus Location
    // ==========================

    public function saveBusLocation(Request $request)
    {
        if ($response = $this->authorizeAdmin()) {
            return $response;
        }

        $request->validate([
            'bus_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'speed' => 'required',
            'status' => 'required'
        ]);

        BusLocation::updateOrCreate(

            [
                'bus_id' => $request->bus_id
            ],

            [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'speed' => $request->speed,
                'status' => $request->status
            ]

        );

        return back()->with(
            'success',
            'Bus location updated successfully.'
        );
    }


























    // ==========================
// Manage Buses
// ==========================

public function buses()
{
    $buses = \App\Models\Bus::all();

    return view('admin.manage-buses', compact('buses'));
}

public function createBus()
{
    $routes = \App\Models\Route::all();

    $drivers = \App\Models\User::where('role','driver')->get();

    return view('admin.add-bus', compact('routes','drivers'));
}






public function storeBus(Request $request)
{
    $request->validate([
        'bus_number' => 'required|unique:buses',
        'capacity' => 'required|numeric',
        'route_id' => 'required',
        'driver_id' => 'nullable',
        'status' => 'required',
        'departure_time' => 'nullable'
    ]);

    \App\Models\Bus::create([
        'bus_number' => $request->bus_number,
        'capacity' => $request->capacity,
        'route_id' => $request->route_id,
        'driver_id' => $request->driver_id,
        'status' => $request->status,
        'departure_time' => $request->departure_time
    ]);

    return redirect('/admin/buses')
        ->with('success', 'Bus Added Successfully');
}






public function editBus($id)
{
    $bus = \App\Models\Bus::findOrFail($id);

    $routes = \App\Models\Route::all();

    $drivers = \App\Models\User::where('role', 'driver')->get();

    return view('admin.edit-bus', compact('bus', 'routes', 'drivers'));
}

public function updateBus(Request $request, $id)
{
    $request->validate([
        'bus_number' => 'required',
        'capacity' => 'required|numeric',
        'route_id' => 'required',
        'driver_id' => 'nullable',
        'status' => 'required',
        'departure_time' => 'nullable'
    ]);

    $bus = \App\Models\Bus::findOrFail($id);

    $bus->update([
        'bus_number' => $request->bus_number,
        'capacity' => $request->capacity,
        'route_id' => $request->route_id,
        'driver_id' => $request->driver_id,
        'status' => $request->status,
        'departure_time' => $request->departure_time
    ]);

    return redirect('/admin/buses')
        ->with('success', 'Bus Updated Successfully');
}





public function deleteBus($id)
{
    $bus = \App\Models\Bus::findOrFail($id);

    $bus->delete();

    return redirect('/admin/buses')
        ->with('success', 'Bus Deleted Successfully');
}




// ==========================
// Manage Routes
// ==========================

public function routes()
{
    $routes = \App\Models\Route::all();

    return view('admin.manage-routes', compact('routes'));
}

public function createRoute()
{
    return view('admin.add-route');
}

public function storeRoute(Request $request)
{
    $request->validate([
        'route_name' => 'required',
        'start_location' => 'required',
        'end_location' => 'required',
        'distance' => 'required|numeric'
    ]);

    \App\Models\Route::create([

        'route_name' => $request->route_name,
        'start_location' => $request->start_location,
        'end_location' => $request->end_location,
        'distance' => $request->distance

    ]);

    return redirect('/admin/routes')
        ->with('success', 'Route Added Successfully');
}






public function editRoute($id)
{
    $route = \App\Models\Route::findOrFail($id);

    return view('admin.edit-route', compact('route'));
}

public function updateRoute(Request $request, $id)
{
    $request->validate([
        'route_name' => 'required',
        'start_location' => 'required',
        'end_location' => 'required',
        'distance' => 'required|numeric'
    ]);

    $route = \App\Models\Route::findOrFail($id);

    $route->update([
        'route_name' => $request->route_name,
        'start_location' => $request->start_location,
        'end_location' => $request->end_location,
        'distance' => $request->distance
    ]);

    return redirect('/admin/routes')
        ->with('success','Route Updated Successfully');
}

public function deleteRoute($id)
{
    $route = \App\Models\Route::findOrFail($id);

    $route->delete();

    return redirect('/admin/routes')
        ->with('success','Route Deleted Successfully');
}





public function drivers()
{
    $drivers = User::where('role', 'driver')->get();

    return view('admin.manage-drivers', compact('drivers'));
}






public function createDriver()
{
    $buses = Bus::all();

    return view('admin.add-driver', compact('buses'));
}

public function storeDriver(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'phone' => 'required',
        'password' => 'required|min:6'
    ]);

    User::create([

        'name' => $request->name,

        'email' => $request->email,

        'phone' => $request->phone,

        'password' => Hash::make($request->password),

        'role' => 'driver'

    ]);

    return redirect('/admin/drivers')
        ->with('success','Driver Added Successfully');
}




//driver edit delete

public function editDriver($id)
{
    $driver = User::findOrFail($id);

    return view('admin.edit-driver', compact('driver'));
}

public function updateDriver(Request $request, $id)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $id,
        'phone' => 'required'
    ]);

    $driver = User::findOrFail($id);

    $driver->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone
    ]);

    return redirect('/admin/drivers')
        ->with('success', 'Driver Updated Successfully');
}

public function deleteDriver($id)
{
    $driver = User::findOrFail($id);

    $driver->delete();

    return redirect('/admin/drivers')
        ->with('success', 'Driver Deleted Successfully');
}

//driver delete edit


public function bookings()
{
    $bookings = Booking::join('users', 'bookings.user_id', '=', 'users.id')
        ->join('buses', 'bookings.bus_id', '=', 'buses.id')
        ->select(
            'bookings.*',
            'users.name',
            'buses.bus_number'
        )
        ->latest()
        ->get();

    return view('admin.manage-bookings', compact('bookings'));
}






public function bookingDetails($id)
{
    $booking = Booking::join('users', 'bookings.user_id', '=', 'users.id')
        ->join('buses', 'bookings.bus_id', '=', 'buses.id')
        ->select(
            'bookings.*',
            'users.name',
            'users.email',
            'users.phone',
            'buses.bus_number'
        )
        ->where('bookings.id', $id)
        ->first();

    return view('admin.booking-details', compact('booking'));
}

public function approveBooking($id)
{
    $booking = Booking::findOrFail($id);
    $booking->status = 'confirmed';
    $booking->save();

    $bus = Bus::find($booking->bus_id);

    Notification::create([
        'user_id' => $booking->user_id,
        'message' => 'Your booking for seat ' . $booking->seat_no . ' on bus ' . ($bus->bus_number ?? '') . ' has been approved.'
    ]);

    return redirect('/admin/bookings')
        ->with('success', 'Booking Approved Successfully and Passenger Notified.');
}

public function cancelBooking(Request $request, $id)
{
    $booking = Booking::findOrFail($id);

    $booking->status = 'cancelled';

    $booking->save();

    // Get the booking bus and route
    $bus = Bus::find($booking->bus_id);
    $reason = $request->query('reason', 'Cancelled by administrator');

    // Find alternative buses for the same route
    $alternatives = collect();
    if ($bus) {
        $alternatives = Bus::where('route_id', $bus->route_id)
            ->where('id', '!=', $bus->id)
            ->where('status', 'active')
            ->get();
    }

    // Prepare the notification message
    $message = "Your booking for seat " . $booking->seat_no . " on bus " . ($bus->bus_number ?? '') . " has been cancelled. Reason: " . $reason . ".";
    
    if ($alternatives->isNotEmpty()) {
        $message .= " Alternative suggestion(s): ";
        $altTexts = [];
        foreach ($alternatives as $alt) {
            $altTexts[] = "Bus " . $alt->bus_number . " departing at " . ($alt->departure_time ? \Carbon\Carbon::parse($alt->departure_time)->format('h:i A') : 'N/A');
        }
        $message .= implode(', ', $altTexts) . ".";
    } else {
        $message .= " Unfortunately, no alternative buses are available on this route at the moment.";
    }

    // Save notification for passenger
    Notification::create([
        'user_id' => $booking->user_id,
        'message' => $message
    ]);

    return redirect('/admin/bookings')
        ->with('success', 'Booking Cancelled Successfully and Passenger Notified.');
}

public function downloadReport()
{
    $bookings = Booking::join('users', 'bookings.user_id', '=', 'users.id')
        ->join('buses', 'bookings.bus_id', '=', 'buses.id')
        ->join('routes', 'buses.route_id', '=', 'routes.id')
        ->select(
            'bookings.id',
            'users.name as passenger_name',
            'users.email as passenger_email',
            'users.phone as passenger_phone',
            'buses.bus_number',
            'routes.start_location',
            'routes.end_location',
            'bookings.seat_no',
            'bookings.journey_date',
            'bookings.status',
            'bookings.created_at'
        )
        ->orderBy('bookings.created_at', 'desc')
        ->get();

    $fileName = 'bookings_report_' . date('Y-m-d_H-i-s') . '.csv';
    $headers = array(
        "Content-type"        => "text/csv",
        "Content-Disposition" => "attachment; filename=$fileName",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0"
    );

    $columns = array('Booking ID', 'Passenger Name', 'Email', 'Phone', 'Bus Number', 'Start Location', 'End Location', 'Seat No', 'Journey Date', 'Status', 'Booked At');

    $callback = function() use($bookings, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($bookings as $booking) {
            fputcsv($file, array(
                $booking->id,
                $booking->passenger_name,
                $booking->passenger_email,
                $booking->passenger_phone,
                $booking->bus_number,
                $booking->start_location,
                $booking->end_location,
                $booking->seat_no,
                $booking->journey_date,
                $booking->status,
                $booking->created_at
            ));
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

public function pdfReport()
{
    $bookings = Booking::join('users', 'bookings.user_id', '=', 'users.id')
        ->join('buses', 'bookings.bus_id', '=', 'buses.id')
        ->join('routes', 'buses.route_id', '=', 'routes.id')
        ->select(
            'bookings.id',
            'users.name as passenger_name',
            'users.email as passenger_email',
            'users.phone as passenger_phone',
            'buses.bus_number',
            'routes.start_location',
            'routes.end_location',
            'bookings.seat_no',
            'bookings.journey_date',
            'bookings.status',
            'bookings.created_at'
        )
        ->orderBy('bookings.created_at', 'desc')
        ->get();

    return view('admin.pdf-report', compact('bookings'));
}






public function passengers()
{
    $passengers = User::where('role', 'passenger')->get();

    return view('admin.manage-passengers', compact('passengers'));
}






public function viewPassenger($id)
{
    $passenger = User::findOrFail($id);

    return view('admin.passenger-details', compact('passenger'));
}

public function deletePassenger($id)
{
    $passenger = User::findOrFail($id);

    if ($passenger->role != 'passenger') {

        return back()->with('error', 'Invalid Passenger');

    }

    $passenger->delete();

    return redirect('/admin/passengers')
        ->with('success', 'Passenger Deleted Successfully');
}

public function users()
{
    if ($response = $this->authorizeAdmin()) {
        return $response;
    }

    $users = User::all();

    return view('admin.manage-users', compact('users'));
}

public function deleteUser($id)
{
    if ($response = $this->authorizeAdmin()) {
        return $response;
    }

    $user = User::findOrFail($id);

    if ($user->role === 'admin') {
        return back()->with('error', 'Cannot delete admin user.');
    }

    $user->delete();

    return redirect('/admin/users')
        ->with('success', 'User Deleted Successfully');
}

public function ticketSalesPrediction()
{
    if ($response = $this->authorizeAdmin()) {
        return $response;
    }

    return view('admin.ticket-sales-prediction');
}

}
