<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quota extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "departament_id",
        "amount",
        "number",
        "due_date",
        "type",
        "description",
        "status",
    ];
    public function departament(): BelongsTo
    {
        return $this->belongsTo(Departament::class, 'departament_id', 'id');
    }
    public function pay(): HasOne
    {
        return $this->hasOne(Pay::class);
    }
}
