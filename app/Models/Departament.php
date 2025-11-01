<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Departament extends Model
{
    /** @use HasFactory<\Database\Factories\Api\DepartamentControllerFactory> */
    use HasFactory;
    
    protected $fillable = [
        'number',
        'address',
        'block',
        'area',
        'description',
        'code_pay',
        'floor',
        'user_id'

    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
