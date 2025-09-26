<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComunArea extends Model
{
    //
    protected $table = "comun_areas";

    protected $fillable = [
        "name",
        "capacity",
        "price",
        "warranty_price",
        "description",
        "max_time_reserve",
        "timeFrom",
        "timeTo",
        "rules"
    ];
}
