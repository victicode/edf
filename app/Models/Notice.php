<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notice extends Model
{
    //
    protected $fillable = [
        "title",
        "description",
        "data_contact",
        "group",
        "category",
        "img",
        "type",
        "views",
        "status",
        "user_id"
    ];
    public $appends  =   ["group_label", "category_label"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getGroupLabelAttribute()
    {
        $groupLabel = [
            "Información",
            "Automotores",
            "Empleos",
            "Inmuebles",
            "Oportunidades"
        ];
        return  $groupLabel[$this->group];
    }
    public function getCategoryLabelAttribute()
    {
        $categoryByGroupLabels = [
            [
                "Información junta de condominio",
            ],
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
