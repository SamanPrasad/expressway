<?php

use App\Http\Controllers\Expressway\BusController;
use App\Http\Controllers\Expressway\ReportController;
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

Route::get('/users', [UserController::class, 'index'])->middleware('expresswayauth');

Route::post('/user', [UserController::class, 'create']);

Route::get('/user', [UserController::class, 'singleUser']);

Route::delete('/user/{id}', [UserController::class, 'destroy']);


Route::get('/reports', [ReportController::class, 'index'])->middleware('expresswayauth');

Route::get('/buses', [BusController::class, 'index'])->middleware('expresswayauth');

Route::get('/routes', [ReportController::class, 'index'])->middleware('expresswayauth');

Route::get('/details', function(){
    $posts = Post::paginate(5, ['*'], 'post');
    // dd($posts);
    return view('test')->with('posts', $posts);
});
