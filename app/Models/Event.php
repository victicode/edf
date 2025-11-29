<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'date',
        'time_from',
        'time_to',
        'location',
        'assists',
        'not_assits',
        'booking_id'
    ];
}
