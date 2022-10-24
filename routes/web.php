<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

                $user = User::select()
                ->where(['id' => Auth::user()->id])
                ->first();
        $genero = ['MASCULINO', 'FEMENINO'];


        return view('user.profile', [
            'url_profile' => User::adminlte_image(),
            'user_data' => $user,
            'genero' => $genero
        ]);

                //usar este una vez se tenga las estadisticas
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
    Route::get('/get-bloque/{id}', 'App\Http\Controllers\Bloque\BloqueController@getBloque')->name('bloque.get');
    Route::put('/update-bloque', 'App\Http\Controllers\Bloque\BloqueController@updateBloque')->name('bloque.update');
});

//cripta
Route::group(['prefix' => 'cripta', 'middleware' => 'auth'], function () {
    Route::get('/index', [App\Http\Controllers\Cripta\CriptaController::class,'index'])->name('cripta.index');
    Route::post('/save', [App\Http\Controllers\Cripta\CriptaController::class,'saveCripta'])->name('cripta.save');
    Route::get('/get-cripta/{id}', [App\Http\Controllers\Cripta\CriptaController::class,'getCripta'])->name('cripta.get');
    Route::put('/update-cripta', [App\Http\Controllers\Cripta\CriptaController::class,'updateCripta'])->name('cripta.update');
    Route::get('mausoleo-notable-pdf', [App\Http\Controllers\Cripta\CriptaController::class, 'printMausoleoNotables'])->name('mausoleosNotables');
    Route::get('cripta-notable-pdf', [App\Http\Controllers\Cripta\CriptaController::class, 'printCriptaNotables'])->name('criptasNotables');


    // Route::put('/-cripta-pay', [App\Http\Controllers\Cripta\CriptaController::class,'updateCriptaInfo'])->name('cripta.update.pay');


     // servicios criptas mausoleos
     Route::get('/servicios-cripta-mausoleo', [App\Http\Controllers\Cripta\ServiciosCMController::class,'index'])->name('servcm');
     Route::post('/load_cm', [App\Http\Controllers\Cripta\CriptaController::class,'buscarCriptaM'])->name('buscar.cripta');
     Route::put('/add-deseaced', [App\Http\Controllers\Cripta\CriptaController::class,'addDifunto'])->name('add.deseaced');
     Route::get('/getServicios', [App\Http\Controllers\Cripta\CriptaController::class,'getServices'])->name('get.services');
});


//mausoleo
Route::group(['prefix' => 'mausoleo', 'middleware' => 'auth'], function () {
    Route::get('/index', [App\Http\Controllers\Mausoleo\MausoleoController::class,'index'])->name('mausoleo.index');
    Route::post('/save', [App\Http\Controllers\Mausoleo\MausoleoController::class,'saveMausoleo'])->name('mausoleo.save');
    Route::get('/get-mausoleo/{id}', [App\Http\Controllers\Mausoleo\MausoleoController::class,'getMausoleo'])->name('mausoleo.get');
    Route::put('/update-mausoleo', 'App\Http\Controllers\Mausoleo\MausoleoController@updateMausoleo')->name('mausoleo.update');

});


//nicho
Route::group(['prefix' => 'nicho', 'middleware' => 'auth'], function () {
    Route::get('/nicho', [App\Http\Controllers\Nicho\NichoController::class,'index'])->name('nicho');
    Route::post('/new-nicho', [App\Http\Controllers\Nicho\NichoController::class,'createNewnicho'])->name('new.nicho');
    Route::get('/list-cuartel', [App\Http\Controllers\Nicho\NichoController::class,'listCuartel'])->name('list-cuartel');
    Route::get('/get-nicho/{id}', 'App\Http\Controllers\Nicho\NichoController@getNicho')->name('nicho.get');
    Route::put('/update-nicho', 'App\Http\Controllers\Nicho\NichoController@updateNicho')->name('nicho.update');
    Route::post('/get-bloqueid', 'App\Http\Controllers\Nicho\NichoController@getBloqueid')->name('bloqueid.get');

});


//responsable
Route::group(['prefix' => 'responsable', 'middleware' => 'auth'], function () {
    Route::get('/index', 'App\Http\Controllers\Responsable\ResponsableController@index')->name('responsable');
    Route::post('/new-responsable', 'App\Http\Controllers\Responsable\ResponsableController@createNewResponsable')->name('new.responsable');
    Route::get('/disable-responsable/{id}', 'App\Http\Controllers\Responsable\ResponsableController@disableAndEnableResponsable')->name('responsable.disable');
    Route::get('/get-responsable/{id}', 'App\Http\Controllers\Responsable\ResponsableController@getResponsable')->name('responsable.get');
    Route::put('/update-responsable', 'App\Http\Controllers\Responsable\ResponsableController@updateResponsable')->name('responsable.update');
});


// asignacion de servicios
    Route::group(['prefix' => 'servicios', 'middleware' => 'auth'], function () {
    Route::get('/servicios', [App\Http\Controllers\Servicios\ServiciosController::class,'index'])->name('serv');
    Route::post('/new-servicio', [App\Http\Controllers\Servicios\ServiciosController::class,'createNewServicios'])->name('new.servicio');
    Route::post('/buscar_nicho', [App\Http\Controllers\Servicios\ServiciosController::class, 'buscar_nicho'])->name('buscar.nicho');
    Route::get('/cargarForm', [App\Http\Controllers\Servicios\ServiciosController::class,'cargarForm'])->name('load.form');
    Route::get('/cargarMantenimiento', [App\Http\Controllers\Servicios\ServiciosController::class,'cargarMantenimiento'])->name('load.mant');
    Route::get('/renovacion', [App\Http\Controllers\Servicios\ServiciosController::class,'precioRenov'])->name('precio.renovacion');
    Route::get('generate-pdf', [App\Http\Controllers\Servicios\ServiciosController::class, 'generatePDF'])->name('serv.generatePDF')->middleware('auth');
    Route::post('/new-serviciocm', [App\Http\Controllers\Servicios\ServiciosController::class,'createNewServicioscm'])->name('new.serviciocm');



    //generate fur from sinot
    Route::post('/generate-fur', [App\Http\Controllers\Servicios\ServiciosController::class,'generateFur'])->name('servicio.fur');
    Route::post('/buscar-renovacion', [App\Http\Controllers\Servicios\ServiciosController::class,'buscarRenovacion'])->name('buscar.renovacion');

    Route::get('/cargarFormrel', [App\Http\Controllers\Servicios\RelevamientoController::class,'cargarFormrel'])->name('load.formrel');
    Route::post('/buscar_nichorel', [App\Http\Controllers\Servicios\RelevamientoController::class, 'buscar_nichorel'])->name('buscar.nicho.rel');

    Route::get('/relevamiento', [App\Http\Controllers\Servicios\RelevamientoController::class,'index'])->name('relev');
    Route::post('/new-relevamiento', [App\Http\Controllers\Servicios\RelevamientoController::class,'createNewRelev'])->name('new.relevamiento');

});

//responsable
Route::group(['prefix' => 'responsable', 'middleware' => 'auth'], function () {
    Route::get('/index', 'App\Http\Controllers\Responsable\ResponsableController@index')->name('responsable');
    Route::post('/new-responsable', 'App\Http\Controllers\Responsable\ResponsableController@createNewResponsable')->name('new.responsable');
    Route::get('/disable-responsable/{id}', 'App\Http\Controllers\Responsable\ResponsableController@disableAndEnableResponsable')->name('responsable.disable');
    Route::get('/get-responsable/{id}', 'App\Http\Controllers\Responsable\ResponsableController@getResponsable')->name('responsable.get');
    Route::put('/update-responsable', 'App\Http\Controllers\Responsable\ResponsableController@updateResponsable')->name('responsable.update');
    //search difunto and responsable por ci
    Route::post('/search-difunto-responsable', 'App\Http\Controllers\Responsable\ResponsableController@searchResponsableAndDifunt')->name('search.difunto.responsable');

});

//difunto
Route::group(['prefix' => 'difunto', 'middleware' => 'auth'], function () {
    Route::get('/index', 'App\Http\Controllers\Difunto\DifuntoController@index')->name('difunto');
    Route::post('/new-difunto', 'App\Http\Controllers\Difunto\DifuntoController@createNewDifunto')->name('new.difunto');
    Route::get('/disable-difunto/{id}', 'App\Http\Controllers\Difunto\DifuntoController@disableAndEnableDifunto')->name('difunto.disable');
    Route::get('/get-difunto/{id}', 'App\Http\Controllers\Difunto\DifuntoController@getDifunto')->name('difunto.get');
    Route::put('/update-difunto', 'App\Http\Controllers\Difunto\DifuntoController@updateDifunto')->name('difunto.update');
    Route::get('/ver-registro-difunto/{id}', 'App\Http\Controllers\Difunto\DifuntoController@verRegistroDifunto')->name('difunto.verRegistro');
    Route::post('/eliminar-difunto', 'App\Http\Controllers\Difunto\DifuntoController@eliminarDifunto')->name('difunto.delete');

});

// mantenimiento de nichos
      Route::group(['prefix' => 'mantenimiento', 'middleware' => 'auth'], function () {
      Route::get('/mantenimiento', [App\Http\Controllers\Mantenimiento\MantenimientoController::class,'index'])->name('mant');
      Route::get('/form-pay', [App\Http\Controllers\Mantenimiento\MantenimientoController::class,'createPay'])->name('pay');
      Route::post('/save-pay', [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'savePay'])->name('save.pay');
      Route::get('generate-pdf', [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'generatePDF'])->name('generatePDF')->middleware('auth');
      Route::post('/buscar_registros', [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'buscar_registros'])->name('buscar.registros');
      Route::get('generarci-difunto', [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'generateCiDif'])->name('generateCiDif')->middleware('auth');
      Route::get('generarci-responsable', [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'generateCiResp'])->name('generateCiResp')->middleware('auth');
      Route::post('/verificar-fur', [App\Http\Controllers\Mantenimiento\MantenimientoController::class,'buscarFurLiquidacion'])->name('verificarFur');
      Route::post('/buscarCuartel', [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'buscarCuartel'])->name('buscar.cuartel');
      Route::post('/save-up-pay-info', [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'relevamientoPagoMant'])->name('save.uppay.info');
      Route::get('/get-mantenimiento/{id}',  [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'getMantenimiento'])->name('mantenimiento.get');


});


// // responsable difuntos
Route::group(['prefix' => 'relevamiento', 'middleware' => 'auth'], function () {
    Route::post('/completar', [App\Http\Controllers\Servicios\ServiciosController::class, 'autocompletar'])->name('completar.datos');
    Route::post('/get-difuntoCripta', [App\Http\Controllers\Cripta\CriptaController::class,'getDifuntoCripta'])->name('difuntoCripta.get');

});

