<?php

namespace App\Http\Controllers\Cripta;

use App\Models\Bloque;
use App\Models\Cripta;
use App\Models\Cuartel;
use App\Models\Difunto;

use App\Models\Responsable;
use App\Models\CriptaMausoleoResp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CriptaController extends Controller
{
    public function index(){

        $cripta = Cripta::select('cripta_mausoleo.id', 'cripta_mausoleo.codigo',  'superficie','cripta_mausoleo.estado',
         'tipo_registro','enterratorios_ocupados','total_enterratorios','osarios', 'total_osarios','cenisarios',
         'cripta_mausoleo_responsable.documentos_recibidos','cripta_mausoleo.difuntos',
        'cripta_mausoleo.sitio','cripta_mausoleo.codigo_antiguo',
         DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'),
         'cuartel.codigo as cuartel_codigo','bloque.codigo as bloque_nombre')
         ->Join('cuartel','cuartel.id', '=', 'cripta_mausoleo.cuartel_id' )
         ->leftJoin('bloque','bloque.id', '=', 'cripta_mausoleo.bloque_id' )
        ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
        ->leftJoin('responsable','responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id' )
        ->where('cripta_mausoleo.estado', 'ACTIVO')
        ->orderBy('cripta_mausoleo.id', 'DESC')
        ->orderBy('tipo_registro', 'DESC')
        ->orderBy('cripta_mausoleo.codigo', 'DESC')
        ->get();
//  dd( $cripta);
         $cuartel = Cuartel::select('id','codigo')
                    ->where('estado', 'ACTIVO')
                    ->orderBy('nombre', 'DESC')
                    ->get();

        $funeraria=DB::table('difunto')
                    ->select('funeraria')
                    ->whereNotNull('funeraria')
                    ->distinct()->get();

        $causa=DB::table('difunto')
        ->select('causa')
        ->whereNotNull('causa')
        ->distinct()->get();

        return view('cripta.index', ['cripta' => $cripta, 'cuartel' => $cuartel, 'funeraria' => $funeraria, 'causa' => $causa]);

    }

    public function saveCripta(Request $request)
    {
    //  dd($request);
        if ($request->isJson())
        {

                    $this->validate($request, [
                        'id_cuartel' => 'required',
                        'codigo' => 'required',
                        'bloque' => 'required',
                        'sitio' => 'required',
                        // 'name' => 'required',
                        'superficie' => 'required|numeric',
                        // 'status' => 'required'
                    ],[
                        'id_cuartel.required' => 'El campo cuartel es requerido!',
                        'codigo.required' => 'El campo código es requerido!',
                        'sitio.required' => 'El campo sitio es requerido!',
                        'bloque.required' => 'El campo bloque es requerido!',
                        // 'name.required' => 'Nombre de la cripta es requerido!',
                        'superficie.required' => ':attribute es requerido!' ,
                        'numeric' => 'La :attribute debe ser un número!'
                    ]);

            $existe_resp=Responsable::where('ci', $request->ci_resp)->first();
            //    dd($existe_resp);
            // si se envian datos del propietario del mausoleo o cripta entonces se busca en la tabla responsable para actualizar datos y no duplicar
            // caso contrario se insterta
                    if($request->ci_resp!=null)
                    {
                            if( $existe_resp==null){
                                if($request->ci_resp!=null)
                                {
                                    $responsable_id=Responsable::insertResponsable($request);
                                }
                                else{
                                    $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);
                                }
                            }else{
                                $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);
                            }
                            // dd($responsable_id);
                     }else if($request->ci_resp==null && $request->paterno_resp!=null){
                        $responsable_id=Responsable::insertResponsable($request);
                    }
                        //insert cripta mausoleo
                        $existe=$this->existeCripta($request);

                        if($existe==false)
                        {
                                 $cripta_id=Cripta::addCripta($request);
                        }
                        else{
                                $cripta_id=Cripta::upCripta($request, $existe->id);
                        }

                        // dd($responsable_id);
                        //insertar relacion cm responsable
                         if( isset($responsable_id)){

                                $search_relacion=DB::table('cripta_mausoleo_responsable')
                                                ->join('cripta_mausoleo','cripta_mausoleo.id', 'cripta_mausoleo_responsable.cripta_mausole_id' )
                                                // ->where('responsable_id',$responsable_id)
                                                ->where('cripta_mausole_id',  $cripta_id)
                                                ->where('cripta_mausoleo.estado', 'ACTIVO')
                                                ->where('cripta_mausoleo.cuartel_id',$request->id_cuartel)
                                                ->where('cripta_mausoleo.bloque_id',$request->bloque)
                                                ->where('cripta_mausoleo.sitio',$request->sitio)
                                                ->where('cripta_mausoleo.superficie',$request->superficie)
                                                ->select('cripta_mausoleo_responsable.id')

                                                ->first();

                                                // dd($search_relacion);
                                                if(!$search_relacion || $search_relacion==null ) {
                                                      CriptaMausoleoResp::saveCriptaMausoleoResp($request,$responsable_id, $cripta_id);
                                                     }
                                                else{
                                                     CriptaMausoleoResp::upCriptaMausoleoResp($request,$responsable_id, $cripta_id, $search_relacion->id );
                                                }
                             }

                   return response([
                        'status'=> true,
                        'response'=> $cripta_id
                    ],201);
        }
        else{
            return response([
                'status'=> false,
                'response'=> "La Cripta ya fue registrada"
            ],201);
        }
    }


    public function getCripta($id){

        $cripta = Cripta::select('cripta_mausoleo.*', 'responsable.id as responsable_id', 'responsable.nombres','responsable.primer_apellido',
                                  'responsable.segundo_apellido', 'responsable.ci', 'responsable.domicilio', 'responsable.nombres','responsable.celular',
                                  'responsable.genero', 'cripta_mausoleo_responsable.id as cripta_mausoleo_resp_id', 'cripta_mausoleo_responsable.documentos_recibidos',
                                  'cripta_mausoleo_responsable.adjudicacion' ,  'cripta_mausoleo_responsable.ultima_gestion_pagada' )
                    ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id')
                    ->leftJoin('responsable', 'responsable.id','=','cripta_mausoleo_responsable.responsable_id')
                    ->where('cripta_mausoleo.id', $id)
                    ->first();

        return response([
              'status'=> true,
              'response'=> $cripta
                 ],201);
    }

    public function updateCripta(Request $request){
        // return response()->json([ $request->id_cripta]);
        // dd("entra");

        if ($request->isJson())
        {
        $this->validate($request, [
            'id_cripta' => 'required',
            'superficie' => 'required|numeric',

        ],[

            'superficie.required' => ':attribute es requerido!' ,
            'numeric' => 'La :attribute debe ser un número!'
        ]);

        $existe_resp=Responsable::where('ci', $request->ci_resp)->first();
        //    dd($existe_resp);
        // si se envian datos del propietario del mausoleo o cripta entonces se busca en la tabla responsable para actualizar datos y no duplicar
        // caso contrario se insterta
                if($request->ci_resp!=null)
                {
                        if( $existe_resp==null){
                            if($request->ci_resp!=null)
                            {
                                $responsable_id=Responsable::insertResponsable($request);
                            }
                            else{
                                $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);
                            }
                        }else{
                            $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);
                        }
                        // dd($responsable_id);
                }else if($request->ci_resp==null && $request->paterno_resp!=null){
                    $responsable_id=Responsable::insertResponsable($request);
                }
                    //insert cripta mausoleo
                    $existe=$this->existeCripta($request);
                    // dd($existe);
                          if(empty($existe)){
                            $cripta_id=Cripta::upCripta($request, $request->cripta_mausoleo_id);
                          }
                        else if(!empty($existe) && $existe->id == $request->cripta_mausoleo_id){
                            $cripta_id=Cripta::upCripta($request, $request->cripta_mausoleo_id);
                          }
                          else{
                            return response([
                                'status'=> false,
                                'response'=> "Ya existe registrada una cripta con esas caracteristicas, por favor revisar la informacion e intente nuevamente"
                            ],201);
                          }


                    //insertar relacion cm responsable
                     if( isset($responsable_id)){

                            $search_relacion=DB::table('cripta_mausoleo_responsable')
                                            ->join('cripta_mausoleo','cripta_mausoleo.id', 'cripta_mausoleo_responsable.cripta_mausole_id' )
                                            // ->where('responsable_id',$responsable_id)
                                            ->where('cripta_mausole_id',  $cripta_id)
                                            ->where('cripta_mausoleo.estado', 'ACTIVO')
                                            ->where('cripta_mausoleo.cuartel_id',$request->id_cuartel)
                                            ->where('cripta_mausoleo.bloque_id',$request->bloque)
                                            ->where('cripta_mausoleo.sitio',$request->sitio)
                                            ->where('cripta_mausoleo.superficie',$request->superficie)
                                            ->select('cripta_mausoleo_responsable.id')
                                            ->first();

                                            //  dd($search_relacion);
                                            if(!$search_relacion || $search_relacion==null ) {
                                                  CriptaMausoleoResp::saveCriptaMausoleoResp($request,$responsable_id, $cripta_id);
                                                 }
                                            else{
                                                 CriptaMausoleoResp::upCriptaMausoleoResp($request,$responsable_id, $cripta_id, $search_relacion->id );
                                            }
                         }

               return response([
                    'status'=> true,
                    'response'=> $cripta_id
                ],200);
    }
    else{
        return response([
            'status'=> false,
            'response'=> "La Cripta ya fue registrada"
        ],201);
    }
    }


    //verifica si la cripta ya esta registrada, en caso positivo retorna su id
    public function existeCripta(Request $request){

        if ($request->bloque==0){   $cripta = DB::table('cripta_mausoleo')
            ->where('cuartel_id', $request->id_cuartel)
            ->where('sitio', $request->sitio)
            ->first(); }
            else{
                $cripta = DB::table('cripta_mausoleo')->where('cuartel_id', $request->id_cuartel)
                ->where('bloque_id', $request->bloque)
                ->where('sitio', $request->sitio)
                ->first();
            }


                           if(!empty($cripta))
                               return   $cripta;
                                else
                                return false;




    }

    public function buscarCriptaM(Request $request){

        if($request->tipo_busqueda=="cod_ant"){

            $sql= DB::table('cripta_mausoleo')->where('codigo_antiguo', ''.$request->search_field.'')
            ->leftjoin('cripta_mausoleo_responsable',  'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
            ->leftjoin('responsable',  'responsable.id','=','cripta_mausoleo_responsable.responsable_id' )
            ->leftjoin('cripta_mausoleo_difunto',  'cripta_mausoleo_difunto.cripta_mausoleo_id','=','cripta_mausoleo.id' )
            ->leftjoin('difunto',  'difunto.id','=','cripta_mausoleo_difunto.difunto_id' )
            ->leftjoin('servicio_nicho',  'servicio_nicho.codigo_nicho','=','cripta_mausoleo.codigo' )

            ->select('cripta_mausoleo.*', 'responsable.nombres as nombre_resp', 'responsable.primer_apellido as paterno_resp',
            'responsable.segundo_apellido as materno_resp', 'responsable.ci as ci_resp', 'responsable.domicilio',
            'responsable.genero as genero_resp',
             'difunto.nombres as nombre_dif', 'difunto.primer_apellido as paterno_dif', 'difunto.segundo_apellido as materno_dif',
             'cripta_mausoleo_difunto.fecha_ingreso',
             'servicio_nicho.fur',
             'servicio_nicho.fecha_pago',
             'servicio_nicho.monto', 'servicio_nicho.nombrepago', 'servicio_nicho.paternopago',
              'servicio_nicho.maternopago', 'servicio_nicho.servicio')
             ->get()->last();


        }
        else if($request->tipo_busqueda=="cod_nuevo"){

            $sql= DB::table('cripta_mausoleo')->where('codigo',  ''.$request->search_field.'')
            ->leftjoin('cripta_mausoleo_responsable',  'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
            ->leftjoin('responsable',  'responsable.id','=','cripta_mausoleo_responsable.responsable_id' )
            ->leftjoin('cripta_mausoleo_difunto',  'cripta_mausoleo_difunto.cripta_mausoleo_id','=','cripta_mausoleo.id' )
            ->leftjoin('difunto',  'difunto.id','=','cripta_mausoleo_difunto.difunto_id' )
            ->leftjoin('servicio_nicho',  'servicio_nicho.codigo_nicho','=','cripta_mausoleo.codigo' )
            ->select('cripta_mausoleo.*', 'responsable.nombres as nombre_resp', 'responsable.primer_apellido as paterno_resp',
            'responsable.segundo_apellido as materno_resp', 'responsable.ci as ci_resp', 'responsable.domicilio',
            'responsable.genero as genero_resp',
             'difunto.nombres as nombre_dif', 'difunto.primer_apellido as paterno_dif', 'difunto.segundo_apellido as materno_dif',
             'cripta_mausoleo_difunto.fecha_ingreso',
             'servicio_nicho.fur',
             'servicio_nicho.fecha_pago',
             'servicio_nicho.monto', 'servicio_nicho.nombrepago', 'servicio_nicho.paternopago',
              'servicio_nicho.maternopago', 'servicio_nicho.servicio')
             ->get()->last();

        }
        else if($request->tipo_busqueda=="propietario"){
            $sql= DB::table('cripta_mausoleo')->where('cripta_mausoleo_responsable.responsable_id', ''.$request->search_field.'')
            ->leftjoin('cripta_mausoleo_responsable',  'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
            ->leftjoin('responsable',  'responsable.id','=','cripta_mausoleo_responsable.responsable_id' )
            ->leftjoin('cripta_mausoleo_difunto',  'cripta_mausoleo_difunto.cripta_mausoleo_id','=','cripta_mausoleo.id' )
            ->leftjoin('difunto',  'difunto.id','=','cripta_mausoleo_difunto.difunto_id' )
            ->leftjoin('servicio_nicho',  'servicio_nicho.codigo_nicho','=','cripta_mausoleo.codigo' )
            ->select('cripta_mausoleo.*', 'responsable.nombres as nombre_resp', 'responsable.primer_apellido as paterno_resp',
            'responsable.segundo_apellido as materno_resp', 'responsable.ci as ci_resp', 'responsable.domicilio', 'responsable.genero as genero_resp',
             'difunto.nombres as nombre_dif', 'difunto.primer_apellido as paterno_dif', 'difunto.segundo_apellido as materno_dif','cripta_mausoleo_difunto.fecha_ingreso' ,
             'servicio_nicho.fur',
             'servicio_nicho.fecha_pago',
             'servicio_nicho.monto', 'servicio_nicho.nombrepago', 'servicio_nicho.paternopago', 'servicio_nicho.maternopago', 'servicio_nicho.servicio'
             )
            ->get()->last();
        }

        // if(!empty($sql)){
        //     $ult_pago=DB::table('servicio_nicho')
        //     ->where('codigo_nicho', $sql->codigo)
        //     ->get()->last();
        // }

        return $sql;
    }

    public function addDifunto(Request $request){
        // dd($request);
        if ($request->isJson())
        {
                $this->validate($request, [
                    'cripta_mausoleo_id' => 'required'
                ],[
                    'cripta_mausoleo_id.required' => ':attribute es requerido!' ,
                ]);

                //Buscar si ya existe el difunto en la tabla difunto


                    $dif = new Difunto;

                    foreach($request['difuntos'] as $key => $value)
                    {

                        if($value['ci']==null || $value['ci']=="" ){
                                    $ci_resp=$this->generateCiDifunto();
                                }else{
                                    $ci_dif=$value['ci'];
                                }
                                $existe=$this->buscarDifunto( $ci_dif, $value['nombres'], $value['primer_apellido'],$value['segundo_apellido']);

                                if($existe==false){
                                    $dif->ci = $ci_dif;
                                    $dif->nombres = $value['nombres'];
                                    $dif->primer_apellido = $value['primer_apellido'];
                                    $dif->segundo_apellido = $value['segundo_apellido'];
                                    $dif->fecha_nacimiento = $value['fecha_nacimiento'];
                                    $dif->fecha_defuncion = $value['fecha_nacimiento'];
                                    $dif->certificado_defuncion = $value['ceresi'];
                                    $dif->causa = $value['causa'];
                                    $dif->tipo = $value['tipo'];
                                    $dif->edad = $value['edad'];

                                    $dif->genero = $value['genero'];
                                    $dif->funeraria = trim($value['funeraria']);
                                    $dif->certificado_file = trim($value['url']);
                                    $dif->estado = 'ACTIVO';
                                    $dif->user_id = auth()->id();
                                    $dif->save();
                                    $dif->id;
                                }
                            }

                        $cript=Cripta::where('id',$request->cripta_mausoleo_id )->first();
                        $cript->difuntos=json_encode($request['difuntos']);
                        $cript->save();

                       if($cript){
                            return response([
                                'status'=> true,
                                'message'=> 'registro con exito..!'
                                ],200);
                       }
                       else{
                        return response([
                            'status'=> false,
                            'message'=> 'Ocurrio un error al ejecutar la transacción..!'
                            ],201);
                       }


        }else{
              return response([
                     'status'=> false,
                     'message'=> 'Error 401 (Unauthorized)'
                      ],401);
            }


    }

    public function buscarDifunto($ci, $nombres, $primer_apellido, $segundo_apellido)
    {
           $difunto_s= DB::table('difunto')->where('ci', ''.$ci.'')
                    ->where('nombres', ''.$nombres.'')
                    ->where('primer_apellido', ''.$primer_apellido.'')
                    ->where('segundo_apellido', ''.$segundo_apellido.'')
                    ->first();
               if(!empty($difunto_s))
               {
                  return $difunto_s;
               }else{
                  return false;
               }
    }

    public function getDifuntoCripta(Request $request){
        // dd($request->cripta_mausoleo_id);
        $difuntoCript =  Cripta::where('id', $request->cripta_mausoleo_id)->first();

               return response([
                'status'=> true,
                'response'=> $difuntoCript
             ],200);
    }


}

