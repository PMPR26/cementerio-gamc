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
             //   return view('home');
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
    // Route::post('/save-pay-cm', [App\Http\Controllers\Cripta\CriptaController::class, 'savePaycm'])->name('save.service.pay.cm');



     // servicios criptas mausoleos
     Route::get('/servicios-cripta-mausoleo', [App\Http\Controllers\Cripta\ServiciosCMController::class,'index'])->name('servcm');
     Route::post('/load_cm', [App\Http\Controllers\Cripta\CriptaController::class,'buscarCriptaM'])->name('buscar.cripta');
     Route::put('/agregar-difuntoCripta', [App\Http\Controllers\Cripta\CriptaController::class,'addDifunto'])->name('agregar.difuntos.cripta');
     Route::get('/getServicios', [App\Http\Controllers\Cripta\CriptaController::class,'getServices'])->name('get.services');
     Route::post('/get-difuntoCripta', [App\Http\Controllers\Cripta\CriptaController::class,'getDifuntoCripta'])->name('difuntoCripta.get');
     Route::post('/ver-asignacion-difunto', [App\Http\Controllers\Cripta\CriptaController::class, 'buscarDifuntoExistente'])->name('verificar.asigancion.difunto');
     Route::post('/buscar-difunto-existente', [App\Http\Controllers\Cripta\CriptaController::class, 'buscarDifuntoExistente'])->name('buscar.difunto.existente');
     Route::get('/cripta-notification', [App\Http\Controllers\Cripta\CriptaController::class,'configNotificacion'])->name('cripta.notification');
     Route::post('/save-service-cripta', [App\Http\Controllers\Cripta\CriptaController::class, 'saveServiceCripta'])->name('guardar.servicio.cripta');
    // public function saveServiceCripta(Request $request){

});


//mausoleo
Route::group(['prefix' => 'mausoleo', 'middleware' => 'auth'], function () {
    // Route::get('/index', [App\Http\Controllers\Mausoleo\MausoleoController::class,'index'])->name('mausoleo.index');
    // Route::post('/save', [App\Http\Controllers\Mausoleo\MausoleoController::class,'saveMausoleo'])->name('mausoleo.save');
    // Route::get('/get-mausoleo/{id}', [App\Http\Controllers\Mausoleo\MausoleoController::class,'getMausoleo'])->name('mausoleo.get');
    // Route::put('/update-mausoleo', 'App\Http\Controllers\Mausoleo\MausoleoController@updateMausoleo')->name('mausoleo.update');

});


//nicho
Route::group(['prefix' => 'nicho', 'middleware' => 'auth'], function () {
    Route::get('/nicho', [App\Http\Controllers\Nicho\NichoController::class,'index'])->name('nicho');
    Route::post('/new-nicho', [App\Http\Controllers\Nicho\NichoController::class,'createNewnicho'])->name('new.nicho');
    Route::get('/list-cuartel', [App\Http\Controllers\Nicho\NichoController::class,'listCuartel'])->name('list-cuartel');
    Route::get('/get-nicho/{id}', 'App\Http\Controllers\Nicho\NichoController@getNicho')->name('nicho.get');
    Route::put('/update-nicho', 'App\Http\Controllers\Nicho\NichoController@updateNicho')->name('nicho.update');
    Route::post('/get-bloqueid', 'App\Http\Controllers\Nicho\NichoController@getBloqueid')->name('bloqueid.get');
    //nicho.liberar.temp
    Route::post('/liberar-nicho', 'App\Http\Controllers\Nicho\NichoController@liberarNicho')->name('nicho.free');

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
    Route::post('/new-servicio-externo', [App\Http\Controllers\Servicios\ServiciosController::class,'createNewServiciosExterno'])->name('new.servicio.externo');

    Route::post('/buscar_nicho', [App\Http\Controllers\Servicios\ServiciosController::class, 'buscar_nicho'])->name('buscar.nicho');
    Route::get('/cargarForm', [App\Http\Controllers\Servicios\ServiciosController::class,'cargarForm'])->name('load.form');
    Route::get('/cargarMantenimiento', [App\Http\Controllers\Servicios\ServiciosController::class,'cargarMantenimiento'])->name('load.mant');
    Route::get('/renovacion', [App\Http\Controllers\Servicios\ServiciosController::class,'precioRenov'])->name('precio.renovacion');
    Route::get('generate-pdf', [App\Http\Controllers\Servicios\ServiciosController::class, 'generatePDF'])->name('serv.generatePDF')->middleware('auth');
    Route::get('generate-pdf-cm', [App\Http\Controllers\Servicios\ServiciosController::class, 'generatePDFCM'])->name('serv.generatePDFCM')->middleware('auth');

    Route::post('anular-fur', [App\Http\Controllers\Servicios\ServiciosController::class, 'anularFur'])->name('serv.anularFur')->middleware('auth');

    Route::post('/new-serviciocm', [App\Http\Controllers\Servicios\ServiciosController::class,'createNewServicioscm'])->name('new.serviciocm');
    Route::post('/get-nro-renov',  [App\Http\Controllers\Servicios\ServiciosController::class,'getNroRenov'])->name('get.nro.renov');
    Route::post('/completar', [App\Http\Controllers\Servicios\ServiciosController::class, 'autocompletar'])->name('completar.datos');
    Route::post('/completar-info-nicho', [App\Http\Controllers\Servicios\ServiciosController::class, 'completarInfoNicho'])->name('completar.info.nicho');
    Route::post('/verificarPago',[App\Http\Controllers\Servicios\ServiciosController::class,'verificarPago'])->name('verificar.pago');

    Route::post('/listar_difuntos', [App\Http\Controllers\Servicios\ServiciosController::class, 'lista_difuntos'])->name('listar.difuntos');




    //generate fur from sinot
    Route::post('/generate-fur', [App\Http\Controllers\Servicios\ServiciosController::class,'generateFur'])->name('servicio.fur');
    Route::post('/buscar-renovacion', [App\Http\Controllers\Servicios\ServiciosController::class,'buscarRenovacion'])->name('buscar.renovacion');
    Route::get('/cargarFormrel', [App\Http\Controllers\Servicios\RelevamientoController::class,'cargarFormrel'])->name('load.formrel');
    Route::post('/buscar_nichorel', [App\Http\Controllers\Servicios\RelevamientoController::class, 'buscar_nichorel'])->name('buscar.nicho.rel');
    Route::post('/buscar_nicho_liberado', [App\Http\Controllers\Servicios\RelevamientoController::class, 'buscar_nicho_liberado'])->name('buscar.nicho.liberado');
    Route::post('/registrar-asignacion', [App\Http\Controllers\Servicios\ServiciosController::class,'registrar_asignacion'])->name('registrar.asignacion');




    Route::get('/relevamiento', [App\Http\Controllers\Servicios\RelevamientoController::class,'index'])->name('relev');
    Route::post('/new-relevamiento', [App\Http\Controllers\Servicios\RelevamientoController::class,'createNewRelev'])->name('new.relevamiento');
    // Route::post('/registrar_asignacion', [App\Http\Controllers\Servicios\ServiciosController::class,'registrar_asignacion'])->name('registrar.asignacion');

    //registrar_asignacion
    Route::post('/get-serv-hijos', [App\Http\Controllers\Servicios\ServiciosController::class,'getServHijos'])->name('get.serv');


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
      Route::get('/form-paycm', [App\Http\Controllers\Mantenimiento\MantenimientoController::class,'indexcm'])->name('paycm_mant');
      Route::post('/verificarPagoMant',[App\Http\Controllers\Mantenimiento\MantenimientoController::class,'verificarPagoMant'])->name('verificar.pago.mant');
      Route::post('anular-fur-mant', [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'anularFurMant'])->name('mant.anularFur')->middleware('auth');


//getInfoPayCm
      Route::get('/getServicioMant', [App\Http\Controllers\Mantenimiento\MantenimientoController::class,'getInfoPayCm'])->name('get.services.mant');
      Route::post('/pago-matenimiento', [App\Http\Controllers\Mantenimiento\MantenimientoController::class, 'pagoMantenimientoCM'])->name('pay.mant.cm');


});


// // // responsable difuntos
// Route::group(['prefix' => 'relevamiento', 'middleware' => 'auth'], function () {
//     Route::post('/completar', [App\Http\Controllers\Servicios\ServiciosController::class, 'autocompletar'])->name('completar.datos');
//     Route::post('/completar-info-nicho/{nicho}/{fila}/{bloque}', [App\Http\Controllers\Servicios\ServiciosController::class, 'completarInfoNicho'])->name('completar.info.nicho');



// });

//notificaciones

//Route::group(['prefix' => 'Notificacion', 'middleware' => 'auth'], function () {
    Route::get('/notificacion-tipo', [App\Http\Controllers\TipoNotificacionController::class,'index'])->name('notification-tipo');
    Route::get('/new-tipo-notification', 'App\Http\Controllers\TipoNotificacionController@createNewTipoNotify')->name('new-tipo-notification');
    Route::post('/save-tipo-notificacion', [App\Http\Controllers\TipoNotificacionController::class, 'saveTipoNotificacion'])->name('save.tipo.notificacion');
    Route::post('/edit-Notification-Type', [App\Http\Controllers\TipoNotificacionController::class,'show'])->name('edit.Notification.Type');
    Route::post('/save-tipo-notificacion', [App\Http\Controllers\TipoNotificacionController::class, 'saveTipoNotificacion'])->name('save.tipo.notificacion');

    Route::post('/save-edit-tipo-notificacion', [App\Http\Controllers\TipoNotificacionController::class, 'saveEditTipoNotificacion'])->name('save.edit.tipo.notificacion');

    Route::get('/notificacion-list', 'App\Http\Controllers\NotificacionesController@index')->name('notificacion.list');
    Route::post('/notificacion', 'App\Http\Controllers\NotificacionesController@getNotificacion')->name('get.notificacion');
    Route::get('/new-notificacion', 'App\Http\Controllers\NotificacionesController@CreateFormNotificar')->name('new.notificacion');
    //new-notification
    //print.notificacion
    Route::post('/print-notificacion', 'App\Http\Controllers\NotificacionesController@printNotificacion')->name('print.notificacion');
    //edit.notificacion
    Route::post('/edit-Notification', [App\Http\Controllers\NotificacionesController::class,'editNotificacion'])->name('edit.notificacion');
    Route::post('/get-tipo-notificacion', 'App\Http\Controllers\TipoNotificacionController@getTipo')->name('get.tipo.notificacion');
    Route::post('/buscar-ubicacion', 'App\Http\Controllers\NotificacionesController@buscarUbicacion')->name('buscar.ubicacion');
    Route::post('/controlar-notificacion', 'App\Http\Controllers\NotificacionesController@controlarNroNotificacion')->name('count.nro.notificacion');


    //controlarNroNotificacion
    //getTipo
    //});



