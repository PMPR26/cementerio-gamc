<?php

namespace App\Http\Controllers;

use App\Models\Notificacion\Tipo_notificacion;
use App\Models\Gestion\Gestion;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TipoNotificacionController extends Controller
{
    //
    public function index(){
        $rowgestion =  Gestion::where('estado', 'ACTIVO')->first();
        $gestion = $rowgestion->id;

        $response =DB::table('tipo_notificacions')
        ->where('estado', 'ACTIVO')->where('gestion', $gestion)->select()->get();
        return view('notificacion/index', ['tipos' => $response ]);
    }

    public function createNewTipoNotify(Request $request){
        return view('notificacion/tipoNotificacion');

    }

    public function saveTipoNotificacion(Request $request){
       // dd($request);
        if ($request->isJson()) {

            $this->validate($request, [
                'nombre_notificacion' => 'required',
                'contenido' => 'required',
            ],
                [
                    'nombre_notificacion.required' => 'El titulo de la notificacion es requerido!',
                    'contenido.required' => 'El contenido de la notificacion es requerido!',
                ]);


                $rowgestion =  Gestion::where('estado', 'ACTIVO')->first();
                $gestion = $rowgestion->id;
                $tipo =  Tipo_notificacion::create([
                    'nombre_notificacion' => trim($request->nombre_notificacion),
                    'contenido' => trim($request->contenido),
                    'gestion'=>$gestion,
                    'estado' => 'ACTIVO',
                     'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ]);


                return response([
                    'status'=> true,
                    'response'=> $tipo
                 ],201);

            }else{

                return response([
                    'status'=> false,
                    'message'=> 'Error 401 (Unauthorized)'
                 ],401);
            }
    }

    public function show(Request $request){
        $response =DB::table('tipo_notificacions')->where('estado', 'ACTIVO')
        ->where('id', $request->id)->select()->first();
        return view('notificacion/edittipoNotificacion', ['tipos' => $response ]);
    }

    public function saveEditTipoNotificacion(Request $request){
       // dd($request);
        if ($request->isJson()) {

            $this->validate($request, [
                'nombre_notificacion' => 'required',
                'contenido' => 'required',
            ],
                [
                    'nombre_notificacion.required' => 'El titulo de la notificacion es requerido!',
                    'contenido.required' => 'El contenido de la notificacion es requerido!',
                ]);

                    $rowgestion =  Gestion::where('estado', 'ACTIVO')->first();
                    $gestion = $rowgestion->id;

                    $tipo_notificacion =  Tipo_notificacion::where('estado', 'ACTIVO')
                    ->where('id', $request->id)->first();

                   /// dd($tipo_notificacion);
                    $tipo =  Tipo_notificacion::where('id',$request->id)->first();

                    $tipo->nombre_notificacion = trim($request->nombre_notificacion);
                    $tipo->contenido = trim($request->contenido);
                    $tipo->gestion=$gestion;
                    $tipo->updated_at = date("Y-m-d H:i:s");
                    $tipo->save();


                    return response([
                        'status'=> true,
                        'response'=> $tipo
                    ],201);

                }else{

                    return response([
                        'status'=> false,
                        'message'=> 'Error 401 (Unauthorized)'
                    ],401);
                }

    }

    public function getTipo(Request $request){
       // dd($request->id);
        $response =DB::table('tipo_notificacions')->where('estado', 'ACTIVO')
        ->where('id', $request->id)->select()->first();
        return $response;
    }

}
