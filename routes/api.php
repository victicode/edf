<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DepartamentController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () 
{
    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::prefix('users')->name('user.')->group(function () {
        // Route::get('/', [ClientController::class, 'getClientPagination']);

    });
    Route::prefix('apartments')->name('apartment.')->group(function () {
        Route::get('/', [DepartamentController::class, 'paginationApartment']);
        Route::post('/', [DepartamentController::class, 'storeApartment']);
    });
});
