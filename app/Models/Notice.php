<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notice extends Model
{
    //
    public $appends  =   ["group_label", "category_label"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getGroupLabelAttribute()
    {
        $statusLabels = [
            "",
            "Automotores",
            "Empleos",
            "Inmuebles",
            "Oportunidades"
        ];
        return  $statusLabels[$this->status];
    }
    public function getCategoryLabelAttribute()
    {
        $categoryByGroupLabels = [
            "",
            [
                "Venta de automovil",
                "Venta de maquinaria",
                "Venta de respuesto",
                "Compra de automovil",
                "Compra de maquinaria",
                "Compra de respuesto",
                "Servicios"
            ],
            [
                "Oferta laboral",
                "Servicios",
            ],
            [
                "Venta de inmueble",
                "Alquier de inmueble",
                "Servicios"
            ],
            [
               "Oportunidad"
            ],
        ];
        return  $categoryByGroupLabels[$this->group][$this->category];
    }
}
