<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuotaController;
use App\Http\Controllers\Api\PayController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\ComunAreaController;
use App\Http\Controllers\Api\DepartamentController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\NotificationController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::prefix('users')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'getOwners']);
        Route::post('/', [UserController::class, 'store']);
        Route::post('/assing_apartmet', [DepartamentController::class, 'assingApartment']);
        Route::get('/admin/get_pendings', [UserController::class, 'getCountPendingsForAdmin']);
        Route::get('/with-publish', [UserController::class, 'getAllUserWithPublish']);
    });
    Route::prefix('apartments')->name('apartment.')->group(function () {
        Route::get('/', [DepartamentController::class, 'paginationApartment']);
        Route::post('/', [DepartamentController::class, 'storeApartment']);
        Route::get('/byFind', [DepartamentController::class, 'apartmentsByfind']);
        Route::get('/byUser', [DepartamentController::class, 'getApartmentsByUser']);
    });
    Route::prefix('comun-area')->name('comun.area.')->group(function () {
        Route::get('/', [ComunAreaController::class, 'paginationAreas']);
        Route::get('/all', [ComunAreaController::class, 'getAll']);
        Route::get('/byId/{id}', [ComunAreaController::class, 'comunAreaById']);
        Route::get('/bySearch', [ComunAreaController::class, 'AreasBySearch']);
        Route::post('/', [ComunAreaController::class, 'storeArea']);
        Route::post('/u/{id}', [ComunAreaController::class, 'updateArea']);
        Route::post('/d/{id}', [ComunAreaController::class, 'deleteArea']);
    });
    Route::prefix('bookings')->name('booking.')->group(function () {
        Route::get('/', [BookingController::class, 'getBookingsByUser']);
        Route::post('/', [BookingController::class, 'storeBooking']);
        Route::get('/availableBooking/{id}', [BookingController::class, 'getAvaibleBookingByDay']);
        Route::get('/byId/{id}', [BookingController::class, 'getBookingById']);
        Route::get('/byArea/{id}', [BookingController::class, 'getBookingByAreaId']);
        Route::post('/cancel/{id}', [BookingController::class, 'cancelBooking']);
        Route::get('/pendings', [BookingController::class, 'getPendings']);
    });
    Route::prefix('events')->name('event.')->group(function () {
        Route::get('/', [EventController::class, 'get']);
        Route::post('/', [EventController::class, 'create']);
        Route::get('/byId/{id}', [EventController::class, 'show']);
        // Route::get('/availableBooking/{id}', [EventController::class, 'getAvaibleBookingByDay']);
        // Route::get('/byArea/{id}', [EventController::class, 'getBookingByAreaId']);
        // Route::post('/cancel/{id}', [EventController::class, 'cancelBooking']);
        // Route::get('/pendings', [EventController::class, 'getPendings']);
    });
    Route::prefix('pays')->name('pay.')->group(function () {
        Route::get('/', [PayController::class, 'getPaysByUser']);
        Route::post('/bookings', [PayController::class, 'storePay']);
        Route::post('/quotas', [PayController::class, 'storePay']);
        Route::get('/byId/{id}', [PayController::class, 'getPayById']);
        Route::post('/updateStatus/{id}', [PayController::class, 'updateStatus']);
    });
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index']);
        Route::get('/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
        Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead']);
        Route::delete('/{id}', [NotificationController::class, 'destroy']);
    });
    Route::prefix('quotas')->name('quota.')->group(function () {
        Route::get('/', [QuotaController::class, 'index']);
        Route::get('/byId/{id}', [QuotaController::class, 'show']);
    });
    Route::prefix('notices')->name('notice.')->group(function () {
        Route::get('/', [NoticeController::class, 'index']);
        Route::get('/byId/{id}', [NoticeController::class, 'show']);
        Route::post('/', [NoticeController::class, 'store']);
        Route::post('/set-viewer/{id}', [NoticeController::class, 'setViewer']);
        Route::post('/set-new-status/{id}', [NoticeController::class, 'setNewStatus']);
        Route::delete('/{id}', [NoticeController::class, 'delete']);
        Route::post('/{id}', [NoticeController::class, 'update']);
    });
});
