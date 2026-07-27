<?php
namespace App\Http\Controllers;
use App\Models\BusLocation;
use App\Models\Booking;
use App\Models\Bus;
use App\Models\Route;
use App\Models\Notification;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PassengerController extends Controller
{
   public function dashboard()
{
    $bookingsCount = Booking::where(
        'user_id',
        Auth::id()
    )->count();

    $upcomingTrips = Booking::where(
        'user_id',
        Auth::id()
    )
    ->whereDate('journey_date', '>=', now())
    ->count();

    $completedTrips = Booking::where(
        'user_id',
        Auth::id()
    )
    ->where('status', 'confirmed')
    ->count();

    $busesCount = Bus::count();

    $routesCount = Route::count();

    $notificationsCount = Notification::where(
        'user_id',
        Auth::id()
    )->count();

    $notifications = Notification::where(
        'user_id',
        Auth::id()
    )
    ->latest()
    ->take(5)
    ->get();

    $recentBookings = Booking::join(
            'buses',
            'bookings.bus_id',
            '=',
            'buses.id'
        )
        ->join(
            'routes',
            'buses.route_id',
            '=',
            'routes.id'
        )
        ->where(
            'bookings.user_id',
            Auth::id()
        )
        ->select(
            'bookings.*',
            'buses.bus_number',
            'routes.start_location',
            'routes.end_location'
        )
        ->latest()
        ->take(5)
        ->get();

    $routes = Route::all();

//new




$weeklyBookings = [];

for ($i = 6; $i >= 0; $i--) {

    $weeklyBookings[] = Booking::where('user_id', Auth::id())
        ->whereDate(
            'created_at',
            now()->subDays($i)->toDateString()
        )
        ->count();

}



//new

    return view('passenger.dashboard', compact(
    'bookingsCount',
    'upcomingTrips',
    'completedTrips',
    'busesCount',
    'routesCount',
    'notificationsCount',
    'notifications',
    'recentBookings',
    'routes',
    'weeklyBookings'
    ));
}
    public function searchPage()
    {
        $routes = Route::all();

        return view('passenger.search-buses', compact('routes'));
    }

    public function searchBus(Request $request)
    {
        $request->validate([
            'from' => 'required',
            'to' => 'required'
        ]);

        $buses = Bus::with('route')
            ->whereHas('route', function($query) use ($request) {
                $query->where('start_location', $request->from)
                      ->where('end_location', $request->to);
            })
            ->get();

        $routes = Route::all();
        $travelDate = $request->input('travel_date', date('Y-m-d'));

        return view(
            'passenger.search-buses',
            compact('buses', 'routes', 'travelDate')
        );
    }






    public function bookSeat(Request $request, int $id)
    {
        if (!Auth::check()) {
            session(['url.intended' => url()->current() . '?' . http_build_query($request->all())]);
            return redirect('/login')->with('error', 'Please login to book a seat.');
        }

        $bus = Bus::findOrFail($id);
        $travelDate = $request->query('date', date('Y-m-d'));

        $bookedSeats = Booking::where('bus_id', $id)
            ->where('journey_date', $travelDate)
            ->whereIn('status', ['confirmed', 'pending'])
            ->pluck('seat_no')
            ->toArray();

        return view(
            'passenger.book-seat',
            compact(
                'bus',
                'bookedSeats',
                'travelDate'
            )
        );
    }

    public function getBookedSeats(Request $request)
    {
        $busId = $request->query('bus_id');
        $date = $request->query('date');

        $bookedSeats = Booking::where('bus_id', $busId)
            ->where('journey_date', $date)
            ->whereIn('status', ['confirmed', 'pending'])
            ->pluck('seat_no')
            ->toArray();

        return response()->json($bookedSeats);
    }




    public function myBookings()
    {$bookings = Booking::join('buses', 'bookings.bus_id', '=', 'buses.id')
        ->join('routes', 'buses.route_id', '=', 'routes.id')
        ->where('bookings.user_id', Auth::id())
        ->select(
            'bookings.*',
            'buses.bus_number',
            'buses.departure_time',
            'routes.start_location',
            'routes.end_location'
        )
        ->latest()
        ->get();

    return view(
        'passenger.my-bookings',
        compact('bookings')
    );
    }





    public function saveBooking(Request $request)
    {
        $exists = Booking::where('bus_id', $request->bus_id)
        ->where('journey_date', $request->journey_date)
        ->where('seat_no', $request->seat_no)
        ->whereIn('status', ['confirmed', 'pending'])
        ->exists();

    if ($exists) {

        return back()->with(
            'error',
            'This seat is already booked. Please select another seat.'
        );

    }

    Booking::create([

        'user_id' => Auth::id(),

        'bus_id' => $request->bus_id,

        'seat_no' => $request->seat_no,

        'journey_date' => $request->journey_date,

        'status' => 'pending'

    ]);

    Notification::create([

        'user_id' => Auth::id(),

        'message' => 'Your booking has been placed and is pending admin approval.'

    ]);

    return redirect('/my-bookings')

        ->with(
            'success',
            'Booking placed successfully. Pending admin approval.'
        );
    }






        public function cancelBooking(int $id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update([
            'status' => 'cancelled'
        ]);

    return redirect('/my-bookings')
        ->with('success','Booking Cancelled Successfully');
}
     





    public function bookingDetails(int $id)
    {
        $booking = Booking::join('buses', 'bookings.bus_id', '=', 'buses.id')
            ->join('routes', 'buses.route_id', '=', 'routes.id')
            ->where('bookings.id', $id)
            ->select(
                'bookings.*',
                'buses.bus_number',
                'buses.departure_time',
                'routes.start_location',
                'routes.end_location'
            )
            ->firstOrFail();

        return view('passenger.booking-details',
            compact('booking'));
    }



//notifications

public function notifications()
{
    $notifications = Notification::where(
        'user_id',
        Auth::id()
    )
    ->latest()
    ->get();

    return view(
        'passenger.notifications',
        compact('notifications')
    );
}
//notifications end





public function liveTracking()
{
    $locations = BusLocation::with('bus')->get();

    return view(
        'passenger.passenger.live-tracking',
        compact('locations')
    );
}

public function profile()
{
    $passenger = Auth::user();
    $passengerProfile = Passenger::where('user_id', Auth::id())->first();

    return view('passenger.profile', compact(
        'passenger',
        'passengerProfile'
    ));
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($user->id)
        ],
        'phone' => 'required|string|max:30',
        'nic' => 'nullable|string|max:50',
        'password' => 'nullable|string|min:6|confirmed'
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone
    ]);

    if ($request->filled('password')) {
        $user->update([
            'password' => Hash::make($request->password)
        ]);
    }

    Passenger::updateOrCreate(
        [
            'user_id' => $user->id
        ],
        [
            'nic' => $request->nic
        ]
    );

    return back()->with('success', 'Profile updated successfully.');
}

}




