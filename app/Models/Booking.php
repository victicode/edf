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
        "booking_number",
        "date", 
        "time_from", 
        "time_to", 
        "amount", 
        "note", 
        "status",
        "is_exclusive"
    ];
    public $appends  =   ["booking_hour", "status_label", "status_color"];

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
    public function getStatusLabelAttribute(){
        $status= [
            "Cancelada",
            "Pago pendiente",
            "Pendiente de aprob.",
            "Exitoso"
        ];
        return  $status[$this->status];
    }
    public function getStatusColorAttribute(){
        $status= [
            "negative",
            "warning",
            "warning",
            "positive"
        ];
        return  $status[$this->status];
    }
}
