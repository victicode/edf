<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //

    protected $fillable = [
        "user_id", 
        "comun_area_id", 
        "date", 
        "time_from", 
        "time_to", 
        "amount", 
        "vaucher", 
        "reference", 
        "note", 
        "pay_method"
    ];
}
