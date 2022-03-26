<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return view('home');
    }else{
        return redirect('login');
    }
    
    
});

Auth::routes();


//request from users
Route::group(['prefix' => 'user', 'middleware' => 'auth'], function () {
    Route::get('/profile', 'App\Http\Controllers\User\UserController@profileUser')->name('profile');
    
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/cuartel', [App\Http\Controllers\Cuartel\CuartelController::class,'index'])->name('cuartel');
Route::get('/cuartel-create', [App\Http\Controllers\Cuartel\CuartelController::class,'create'])->name('cuartel.create');
Route::get('/cuartel-register', [App\Http\Controllers\cuartel\CuartelController::class,'register'])->name('cuartel.register');



