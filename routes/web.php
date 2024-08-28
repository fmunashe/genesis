<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});
Route::redirect('/', '/backend');
Route::redirect('login', '/backend');

Auth::routes(['register' => false, 'login' => false]);
