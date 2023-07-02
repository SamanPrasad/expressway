<?php

use App\Http\Controllers\Expressway\BusController;
use App\Http\Controllers\Expressway\RouteController;
use App\Http\Controllers\Expressway\TripController;
use App\Http\Controllers\Expressway\UserController;
use App\Http\Controllers\HomeController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/account', [HomeController::class, 'index'])->name('home');

Route::get('/owner', function(){
    return view('home');
});

Route::get('/admin', function(){
    return view('home');
});

Route::get('/data-entry', function(){
    return view('home');
});

Route::get('/manager', function(){
    return view('home');
});

/***********User routes************/
Route::get('/users', [UserController::class, 'index'])->middleware('expresswayauth');

Route::post('/user', [UserController::class, 'create']);

Route::get('/user', [UserController::class, 'singleUser']);

Route::put('/user', [UserController::class, 'update']);

Route::delete('/user/{id}', [UserController::class, 'destroy']);
/************************/

/*****Bus routes******/
Route::get('/buses', [BusController::class, 'index'])->middleware('expresswayauth');

Route::post('/bus', [BusController::class, 'create']);

Route::get('/bus',[BusController::class, 'singleBus']);

Route::put('/bus',[BusController::class, 'update']);

Route::delete('bus/{id}', [BusController::class, 'destroy']);
/********************/

/********Routes routes***********/
Route::get('/bus-routes', [RouteController::class, 'index'])->middleware('expresswayauth');

Route::post('/bus-route', [RouteController::class, 'create']);

Route::get('/bus-route', [RouteController::class, 'singleRoute']);

Route::put('/bus-route', [RouteController::class, 'update']);

Route::delete('/bus-route/{id}', [RouteController::class, 'destroy']);
/******************/

/***Trips routes*****/
Route::get('/trips', [TripController::class, 'index']);

Route::get('/trip', [TripController::class, 'singleTrip']);

Route::post('/trip', [TripController::class, 'create']);

Route::put('/trip', [TripController::class, 'update']);

Route::delete('/trip/{id}',[TripController::class, 'destroy']);



