<?php
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PaymentController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware([SetUserMiddleware::class])->group(function (){
Route::get('/qrcodes/{qrcode}/dates/{date}/appointments',[AppointmentController::class,'index']);
Route::put('/qrcodes/{qrcode}/dates/{date}/appointments/{appointment}/changestatus',[AppointmentController::class,'changestatus']);
Route::get('/qrcodes/{qrcode}/dates/{date}/appointments/{appointment}',[PaymentController::class,'processPayment']);
Route::put('/callback',[PaymentController::class,'callback']);
});