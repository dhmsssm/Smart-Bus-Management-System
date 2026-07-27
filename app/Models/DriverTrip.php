<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverTrip extends Model
{
    protected $fillable = [
        'driver_id',
        'bus_id',
        'route_id',
        'start_time',
        'end_time',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}
