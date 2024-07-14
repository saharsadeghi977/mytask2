<?php
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/qrcodes/{qrcode}/dates/{date}/appointments',[AppointmentController::class,'index']);
Route::put('/qrcodes/{qrcode}/dates/{date}/appointments/{appointment}/changestatus',[AppointmentController::class,'changestatus']);

Route::put('/qrcodes/{qrcode}/dates/{date}/appointments/{appointment}',[PaymentController::class,'processPayment']);