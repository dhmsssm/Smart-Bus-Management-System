<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
protected $fillable = [
    'user_id',
    'bus_id',
    'seat_no',
    'journey_date',
    'status'
];
}
