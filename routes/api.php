<?php

use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\QRcodeController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('tickets', TicketController::class)->except(['create', 'edit']);
Route::apiResource('ticketTypes', TicketTypeController::class)->except(['create', 'edit']);
Route::post('paynowCallBack', [PaymentsController::class, 'payNowCallBack']);
Route::apiResource('payments', PaymentsController::class)->only(['index', 'store']);
Route::post('/codes/verify/{code}', [QRcodeController::class, 'verify'])->name("verifyCode");
//Route::apiResource('codes', QRcodeController::class)->only(['index', 'store','show']);
