<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefBookingStatuses extends Model
{
    protected $table = 'ref_booking_statuses'; 

    protected $fillable = [
        'name',
        'active'
    ];

    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'booking_status');
    }
}