<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ComunAreaController;
use App\Http\Controllers\Api\DepartamentController;
use App\Http\Controllers\Api\UserController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () 
{
    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('users')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'getOwners']);
        Route::post('/', [UserController::class, 'store']);
        Route::post('/assing_apartmet', [DepartamentController::class, 'assingApartment']);
    });
    Route::prefix('apartments')->name('apartment.')->group(function () {
        Route::get('/', [DepartamentController::class, 'paginationApartment']);
        Route::post('/', [DepartamentController::class, 'storeApartment']);
        Route::get('/byFind', [DepartamentController::class, 'apartmentsByfind']);

    });
    Route::prefix('comun-area')->name('comun.area.')->group(function () {
        Route::get('/', [ComunAreaController::class, 'paginationAreas']);
        Route::get('/all',       [ComunAreaController::class, 'getAll']);
        Route::get('/byId/{id}', [ComunAreaController::class, 'comunAreaById']);
        Route::get('/bySearch',  [ComunAreaController::class, 'AreasBySearch']);
        Route::post('/', [ComunAreaController::class, 'storeArea']);
        Route::post('/u/{id}', [ComunAreaController::class, 'updateArea']);
        Route::post('/d/{id}', [ComunAreaController::class, 'deleteArea']);

    });
    Route::prefix('bookings')->name('booking.')->group(function () {
        Route::get('/', [BookingController::class, 'getBookingsByUser']);
        Route::post('/', [BookingController::class, 'storeBooking']);
        Route::get('/availableBooking/{id}', [BookingController::class, 'getAvaibleBookingByDay']);
    
    });
});
