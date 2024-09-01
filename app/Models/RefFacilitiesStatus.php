<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefFacilitiesStatus extends Model
{
    use HasFactory;

    protected $table = 'ref_facilities_statuses';

    protected $fillable = [
        'name',
        'active',
    ];
}
