<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//encapsulation
class Bus extends Model
{
    protected $fillable = [
    'bus_number',
    'route_id',
    'driver_id',
    'capacity',
    'status',
    'departure_time'


];



public function location()
{
    return $this->hasOne(BusLocation::class);
}


public function route()
{
    return $this->belongsTo(Route::class);
}

public function driver()
{
    return $this->belongsTo(User::class, 'driver_id');
}













}


