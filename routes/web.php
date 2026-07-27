<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PassengerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $startLocations = \App\Models\Route::select('start_location')->distinct()->pluck('start_location');
    $endLocations = \App\Models\Route::select('end_location')->distinct()->pluck('end_location');
    
    $busesCount = \App\Models\Bus::count();
    $routesCount = \App\Models\Route::count();
    $driversCount = \App\Models\User::where('role', 'driver')->count();
    $passengersCount = \App\Models\User::where('role', 'passenger')->count();

    return view('welcome', compact('startLocations', 'endLocations', 'busesCount', 'routesCount', 'driversCount', 'passengersCount'));
});


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
});

Route::get('/passenger/dashboard', [PassengerController::class, 'dashboard']);

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/report/download', [AdminController::class, 'downloadReport'])->name('admin.report.download');
    Route::get('/report/pdf', [AdminController::class, 'pdfReport'])->name('admin.report.pdf');
    Route::get('/bus-location', [AdminController::class, 'busLocation']);
    Route::post('/bus-location', [AdminController::class, 'saveBusLocation']);



Route::get('/buses', [AdminController::class, 'buses']);
Route::get('/buses/create', [AdminController::class, 'createBus']);
Route::post('/buses/store', [AdminController::class, 'storeBus']);
Route::get('/buses/edit/{id}', [AdminController::class, 'editBus']);
Route::post('/buses/update/{id}', [AdminController::class, 'updateBus']);
Route::get('/buses/delete/{id}', [AdminController::class, 'deleteBus']);



// Manage Routes
Route::get('/routes', [AdminController::class, 'routes']);
Route::get('/routes/create', [AdminController::class, 'createRoute']);
Route::post('/routes/store', [AdminController::class, 'storeRoute']);
Route::get('/routes/edit/{id}', [AdminController::class, 'editRoute']);
Route::post('/routes/update/{id}', [AdminController::class, 'updateRoute']);
Route::get('/routes/delete/{id}', [AdminController::class, 'deleteRoute']);





// Manage Drivers

Route::get('/drivers', [AdminController::class, 'drivers']);

Route::get('/drivers/create', [AdminController::class, 'createDriver']);

Route::post('/drivers/store', [AdminController::class, 'storeDriver']);

Route::get('/drivers/edit/{id}', [AdminController::class, 'editDriver']);

Route::post('/drivers/update/{id}', [AdminController::class, 'updateDriver']);

Route::get('/drivers/delete/{id}', [AdminController::class, 'deleteDriver']);


});





Route::get('/search-buses', [PassengerController::class, 'searchPage']);
Route::post('/search-buses', [PassengerController::class, 'searchBus']);

Route::get('/book-seat/{id}', [PassengerController::class, 'bookSeat']);
Route::post('/save-booking', [PassengerController::class, 'saveBooking']);

Route::get('/my-bookings', [PassengerController::class, 'myBookings']);
Route::get('/cancel-booking/{id}', [PassengerController::class, 'cancelBooking']);
Route::get('/booking-details/{id}', [PassengerController::class, 'bookingDetails']);
Route::get('/notifications', [PassengerController::class, 'notifications']);
Route::get('/live-tracking', [PassengerController::class, 'liveTracking']);
Route::get('/get-booked-seats', [PassengerController::class, 'getBookedSeats']);





//diver edit update delete


Route::get('/drivers/edit/{id}', [AdminController::class, 'editDriver']);

Route::post('/drivers/update/{id}', [AdminController::class, 'updateDriver']);

Route::get('/drivers/delete/{id}', [AdminController::class, 'deleteDriver']);




Route::prefix('admin')->group(function () {

    // Dashboard


    // Manage Buses
    
    // Manage Routes

    
    // Manage Drivers

    
// Manage Passengers

Route::get('/passengers', [AdminController::class, 'passengers']);

Route::get('/passengers/view/{id}', [AdminController::class, 'viewPassenger']);

Route::get('/passengers/delete/{id}', [AdminController::class, 'deletePassenger']);

// Manage All Users
Route::get('/users', [AdminController::class, 'users']);
Route::get('/users/delete/{id}', [AdminController::class, 'deleteUser']);





    
    // 👇 මෙන්න මෙතන

    Route::get('/bookings', [AdminController::class, 'bookings']);

    Route::get('/bookings/details/{id}', [AdminController::class, 'bookingDetails']);

    Route::get('/bookings/approve/{id}', [AdminController::class, 'approveBooking']);

    Route::get('/bookings/cancel/{id}', [AdminController::class, 'cancelBooking']);

    Route::get('/ticket-sales-prediction', [AdminController::class, 'ticketSalesPrediction']);

});



Route::get('/test', function () {
    return "Working";
});




Route::get('/passengers/create', [AdminController::class, 'createPassenger']);
Route::post('/passengers/store', [AdminController::class, 'storePassenger']);

Route::get('/passengers/edit/{id}', [AdminController::class, 'editPassenger']);
Route::post('/passengers/update/{id}', [AdminController::class, 'updatePassenger']);



use App\Http\Controllers\DriverController;



Route::middleware('auth')->group(function () {

    Route::get('/driver/dashboard', [DriverController::class, 'dashboard']);
    Route::get('/driver/my-trip', [DriverController::class, 'myTrip']);
    Route::get('/driver/trip-history', [DriverController::class, 'tripHistory'])->name('driver.trip-history');
    Route::get('/driver/my-bus', [DriverController::class, 'myBus'])->name('driver.my-bus');
    Route::post('/driver/add-bus', [DriverController::class, 'addBus'])->name('driver.add-bus');
    Route::post('/driver/add-route', [DriverController::class, 'addRoute'])->name('driver.add-route');
    Route::get('/driver/my-route', [DriverController::class, 'myRoute'])->name('driver.my-route');
    Route::get('/driver/passengers', [DriverController::class, 'passengers']);
    Route::get('/driver/share-location', [DriverController::class, 'shareLocation']);
    Route::get('/driver/notifications', [DriverController::class, 'notifications'])->name('driver.notifications');
    Route::post('/driver/notifications/{notification}/read', [DriverController::class, 'markNotificationAsRead'])->name('driver.notifications.read');
    Route::delete('/driver/notifications/{notification}', [DriverController::class, 'deleteNotification'])->name('driver.notifications.delete');
    Route::get('/driver/profile', [DriverController::class, 'profile']);
    Route::get('/driver/location', [DriverController::class, 'location'])->name('driver.location');
    Route::get('/driver/status', [DriverController::class, 'status']);
    Route::post('/driver/profile', [DriverController::class, 'updateProfile']);
    Route::post('/driver/bus-details', [DriverController::class, 'updateBusDetails']);
    Route::post('/driver/trip/start', [DriverController::class, 'startTrip'])->name('driver.trip.start');
    Route::post('/driver/trip/delay', [DriverController::class, 'reportDelay']);
    Route::post('/driver/trip/on-time', [DriverController::class, 'markOnTime']);
    Route::post('/driver/trip/end', [DriverController::class, 'endTrip'])->name('driver.trip.end');
    Route::post('/driver/status', [DriverController::class, 'updateStatus']);
    Route::post('/driver/location', [DriverController::class, 'updateLocation'])->name('driver.location.update');

    // Passenger Profile
    Route::get('/passenger/profile', [PassengerController::class, 'profile']);
    Route::post('/passenger/profile', [PassengerController::class, 'updateProfile']);

});
