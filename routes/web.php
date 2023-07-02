<?php

use App\Http\Controllers\Expressway\BusController;
use App\Http\Controllers\Expressway\RouteController;
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

Route::post('/user/update', [UserController::class, 'update']);

Route::delete('/user/{id}', [UserController::class, 'destroy']);
/************************/

Route::get('/buses', [BusController::class, 'index'])->middleware('expresswayauth');

Route::post('/bus', [BusController::class, 'create']);

Route::get('/bus',[BusController::class, 'singleBus']);

Route::post('/bus/update',[BusController::class, 'update']);

Route::delete('bus/{id}', [BusController::class, 'destroy']);

Route::get('/routes', [RouteController::class, 'index'])->middleware('expresswayauth');


