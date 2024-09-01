<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table = 'bookings'; 

    protected $fillable = [
        'user_id',
        'facility_id',
        'booking_status',
        'event_type',
        'attendees',
        'special_requirements',
        'start_datetime',
        'end_datetime'
    ];

    public function facilities()
    {
        return $this->belongsTo(Facilities::class, 'facility_id');
    }

    public function refBookingStatuses()
    {
        return $this->belongsTo(RefBookingStatuses::class, 'booking_status');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}