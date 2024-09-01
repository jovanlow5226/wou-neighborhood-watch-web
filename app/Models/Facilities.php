<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facilities extends Model
{
    protected $table = 'facilities'; 

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'image_url',
        'active'
    ];

    public function bookings()
    {
        return $this->hasMany(Bookings::class, 'facility_id');
    }

    public function status()
    {
        return $this->belongsTo(RefFacilitiesStatus::class, 'status_id');
    }
}