<?php

use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketTypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('roles', RoleController::class)->except(['create', 'edit']);
Route::apiResource('tickets', TicketController::class)->except(['create', 'edit']);
Route::apiResource('ticketTypes', TicketTypeController::class)->except(['create', 'edit']);
Route::apiResource('payments', PaymentsController::class)->only(['index', 'store']);
