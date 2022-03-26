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
    Route::group(['prefix' => 'cuartel', 'middleware' => 'auth'], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/index', 'App\Http\Controllers\Cuartel\CuartelController@index')->name('cuartel');
    Route::post('/new-cuartel', 'App\Http\Controllers\Cuartel\CuartelController@createNewCuartel')->name('new.cuartel');
    Route::get('/disable-cuartel/{id}', 'App\Http\Controllers\Cuartel\CuartelController@disableAndEnableCuartel')->name('cuartel.disable');
    Route::get('/get-cuartel/{id}', 'App\Http\Controllers\Cuartel\CuartelController@getCuartel')->name('cuartel.get');
    Route::put('/update-cuartel', 'App\Http\Controllers\Cuartel\CuartelController@updateCuartel')->name('cuartel.update');
    
});

Route::group(['prefix' => 'bloque', 'middleware' => 'auth'], function () {
    Route::get('/bloque', [App\Http\Controllers\Bloque\BloqueController::class,'index'])->name('bloque');
    Route::get('/bloque-create', [App\Http\Controllers\Bloque\BloqueController::class,'create'])->name('bloque.create');
    Route::post('/new-bloque', [App\Http\Controllers\Bloque\BloqueController::class,'createNewBloque'])->name('new.bloque');
    Route::get('/list-cuartel', [App\Http\Controllers\Bloque\BloqueController::class,'listCuartel'])->name('list-cuartel');
});