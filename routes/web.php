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

//bloque
Route::group(['prefix' => 'bloque', 'middleware' => 'auth'], function () {
    Route::get('/bloque', [App\Http\Controllers\Bloque\BloqueController::class,'index'])->name('bloque');  
    Route::post('/new-bloque', [App\Http\Controllers\Bloque\BloqueController::class,'createNewBloque'])->name('new.bloque');
    Route::get('/list-cuartel', [App\Http\Controllers\Bloque\BloqueController::class,'listCuartel'])->name('list-cuartel');
});

//cripta
Route::group(['prefix' => 'cripta', 'middleware' => 'auth'], function () {
    Route::get('/index', [App\Http\Controllers\Cripta\CriptaController::class,'index'])->name('cripta.index');
});


Route::group(['prefix' => 'nicho', 'middleware' => 'auth'], function () {
    Route::get('/nicho', [App\Http\Controllers\Nicho\NichoController::class,'index'])->name('nicho');  
    Route::post('/new-nicho', [App\Http\Controllers\Nicho\NichoController::class,'createNewnicho'])->name('new.nicho');
    Route::get('/list-cuartel', [App\Http\Controllers\Nicho\NichoController::class,'listCuartel'])->name('list-cuartel');
    Route::get('/get-nicho/{id}', 'App\Http\Controllers\Nicho\NichoController@getNicho')->name('nicho.get');
    Route::put('/update-nicho', 'App\Http\Controllers\Nicho\NichoController@updateNicho')->name('nicho.update');
});
