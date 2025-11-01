<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pay extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        "user_id",
        "booking_id",
        "quota_id",
        "amount",
        "vaucher",
        "reference",
        "pay_date",
        "pay_id",
        "pay_method",
        "status"
    ];
    public $appends  =   ["status_label", "status_color", "status_icon", "pay_method_label"];

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function getStatusLabelAttribute()
    {
        $status = [
            "Cancelada",
            "Pendiente de aprob.",
            "Exitoso"
        ];
        return  $status[$this->status];
    }
    public function getPayMethodLabelAttribute()
    {
        $payMethod = [
            '',
            "Transferencia bancaria",
            "Yape",
            "Pago en efectivo"
        ];
        return  $payMethod[$this->pay_method];
    }
    public function getStatusColorAttribute()
    {
        $status = [
            "negative",
            "warning",
            "positive"
        ];
        return  $status[$this->status];
    }
    public function getStatusIconAttribute()
    {
        $status = [
            "eva-close-outline",
            "eva-alert-circle-outline",
            "eva-checkmark-outline"
        ];
        return  $status[$this->status];
    }
}
