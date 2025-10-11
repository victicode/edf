<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    //
    use SoftDeletes;
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
    public $appends  =   ['booking_hour'];

    public function comunArea(): BelongsTo {
        return $this->belongsTo(ComunArea::class, 'comun_area_id', 'id');
    }
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function getBookingHourAttribute(){
        $hour = intval(substr($this->time_to, 0, 2)) - intval(substr($this->time_from, 0, 2));
        return  $hour;
        
    }
}
