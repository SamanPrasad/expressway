<?php

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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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

Route::get('/details', function(){
    $posts = Post::paginate(5, ['*'], 'post');
    // dd($posts);
    return view('test')->with('posts', $posts);
});
