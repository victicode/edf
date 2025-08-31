<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartamentController extends Model
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
}
