<?php

namespace App\Http\Controllers;
use App\Models\Gestion\Gestion;
use App\Models\Notificacion\Tipo_notificacion;

use Illuminate\Support\Facades\DB;


use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    public function index(){

        return view('notificacion/notificacion');
    }

    public function getNotificacion(Request $request){
        $rowgestion =  Gestion::where('estado', 'ACTIVO')->first();
        $gestion = $rowgestion->id;
       // dd($gestion);

        $response =DB::table('notificaciones')
        ->Join('tipo_notificacions','tipo_notificacions.id', '=', 'notificaciones.tipo_notificacion_id' )
        ->where('notificaciones.estado', 'ACTIVO')
        ->where('notificaciones.gestion', $gestion)->select('notificaciones.*',
        'tipo_notificacions.id as tipo_id', 'tipo_notificacions.nombre_notificacion',
         'tipo_notificacions.contenido')
         ->orWhere('notificaciones.ubicacion_codigo', 'ilike', '%' . mb_strtoupper(trim($request->search['value'])) . '%')
         ->skip($request->start)
         ->take($request->length)
         ->orderBy('id', 'asc')
         ->get();
        //dd($response);
        $count = DB::table('notificaciones')
        ->Join('tipo_notificacions','tipo_notificacions.id', '=', 'notificaciones.tipo_notificacion_id' )
        ->where('notificaciones.estado', 'ACTIVO')
        ->where('notificaciones.gestion', $gestion)->select('notificaciones.*',
        'tipo_notificacions.id as tipo_id', 'tipo_notificacions.nombre_notificacion',
         'tipo_notificacions.contenido')
        ->count();

            $draw = $request->draw;
            return response([
                        'draw' =>  $draw,
                        'recordsTotal' => $count,
                        'recordsFiltered' => $count,
                        'data' => $response
                    ],200);


    }

    public function CreateFormNotificar(){
        $rowgestion =  Gestion::where('estado', 'ACTIVO')->first();
        $gestion = $rowgestion->id;

        $response =DB::table('tipo_notificacions')
        ->where('estado', 'ACTIVO')->where('gestion', $gestion)->select()->get();
        return view('notificacion/formNotificacion', ['tipos' => $response ]);


    }

    public function printNotificacion()
    {

    }

    public function editNotificacion()
    {

    }

    public function buscarUbicacion(Request $request){

        if($request->tipo_ubicacion=="CRIPTA" || $request->tipo_ubicacion=="MAUSOLEO"){
            $sql = DB::table('cripta_mausoleo')
                ->where('estado', 'ACTIVO')
                ->where('codigo', $request->codigo)
                ->where('tipo_registro',$request->tipo_ubicacion)
                ->select()->first();
        }
        else if($request->tipo_ubicacion=="NICHO"){
            $sql = DB::table('nicho')
            ->where('estado', 'ACTIVO')
            ->where('codigo', $request->codigo)
            ->select()->first();
        }

        return $sql;
    }

    public function controlarNroNotificacion(Request $request){
        $contador = 0;
       $rowgestion =  Gestion::where('estado', 'ACTIVO')->first();
        $gestion = $rowgestion->id;
        //dd(  $gestion);
        $sql = DB::table('notificaciones')->where('estado', 'ACTIVO')
            ->where('ubicacion_codigo', $request->codigo)
            ->where('tipo_notificacion_id', $request->tipo_notificacion)
            ->where('gestion', $gestion)
            ->groupBy('id','ubicacion_codigo', 'tipo_notificacion_id')
            ->get();
     //dd($sql);
                   foreach($sql as $key=>$value){
                            if ($value->ubicacion_codigo == $request->codigo && $value->tipo_notificacion_id == $request->tipo_notificacion && $value->gestion == $gestion) {
                               // dd($value->ubicacion_codigo);
                                $contador++;
                            }
                    }
                    if($contador>=3){
                        return response([
                            'status'=> false,
                            'nro'=> $contador,
                            //'message'=> 'Error 401 (Unauthorized user)'
                         ],201);
                    }
                    else{
                          $contenido_notificacion = DB::table('tipo_notificacions')
                          ->select('tipo_notificacions.contenido')
                          ->where('estado', 'ACTIVO')
                          ->where('gestion',  $gestion)
                          ->where('id', $request->tipo_notificacion)->first();


                          return response([
                            'status'=> true,
                            'nro'=> $contador,
                            'result'=>$contenido_notificacion->contenido
                         ],200);
                    }
    }
}
