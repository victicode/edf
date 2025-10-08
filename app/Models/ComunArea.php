<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComunArea extends Model
{
    //
    use SoftDeletes;
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
    public $appends  =   ['pay_label'];

    public function getPayLabelAttribute(){
        return $this->price == 0 && $this->warranty_price == 0 ? 'Gratis' : 'Pago';
    }

}
