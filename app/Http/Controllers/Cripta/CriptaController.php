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
use App\Models\Nicho;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PDF;
class CriptaController extends Controller
{

    public function index(Request $request){
        // dd($request);
        if(($request->select_cuartel_search==null && $request->bloque_search ==null && $request->sitio_search ==null) ||
           (!isset($request->select_cuartel_search) && !isset($request->bloque_search) && !isset($request->sitio_search))){
            $cripta = Cripta::select('cripta_mausoleo.id', 'cripta_mausoleo.codigo',  'superficie','cripta_mausoleo.estado',
            'tipo_registro','enterratorios_ocupados','total_enterratorios','osarios', 'total_osarios','cenisarios', 'cripta_mausoleo.notable',
            'cripta_mausoleo_responsable.documentos_recibidos',   'cripta_mausoleo_responsable.adjudicacion', 'cripta_mausoleo.difuntos', 'mantenimiento.ultimo_pago',
           'cripta_mausoleo.sitio','cripta_mausoleo.codigo_antiguo','cripta_mausoleo.familia','cripta_mausoleo_responsable.estado as estado_rel_resp',
            DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'),
            'cuartel.codigo as cuartel_codigo','bloque.codigo as bloque_nombre')
            ->Join('cuartel','cuartel.id', '=', 'cripta_mausoleo.cuartel_id' )
            ->leftJoin('bloque','bloque.id', '=', 'cripta_mausoleo.bloque_id' )
           ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
           ->leftJoin('responsable','responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id' )
           ->leftJoin('mantenimiento','mantenimiento.id_ubicacion', '=', 'cripta_mausoleo.id' )
           ->where('cripta_mausoleo.estado', 'ACTIVO')
           ->orderBy('cripta_mausoleo.id', 'DESC')
           ->orderBy('tipo_registro', 'DESC')
           ->orderBy('cripta_mausoleo.codigo', 'DESC')
           ->get();
        }
        else{
            // dd($request);
           if($request->select_cuartel_search!=null && ($request->bloque_search !=null || $request->bloque_search !='' || isset($request->bloque_search)) && $request->sitio_search !=null){
                $condicion=['cripta_mausoleo.cuartel_id' =>''.$request->select_cuartel_search.'' , 'cripta_mausoleo.bloque_id'=>''.$request->bloque_search.'' , 'cripta_mausoleo.sitio' =>''.$request->sitio_search.''];
            }
            elseif($request->select_cuartel_search!=null && ($request->bloque_search !=null || isset($request->bloque_search)) && $request->sitio_search==null){
                $condicion=['cripta_mausoleo.cuartel_id' =>''.$request->select_cuartel_search.'' , 'cripta_mausoleo.bloque_id'=>''.$request->bloque_search.''];
            }
            else if($request->select_cuartel_search!=null && ($request->bloque_search ==null || $request->bloque_search =='' || !isset($request->bloque_search)) && $request->sitio_search!=null){
                $condicion=['cripta_mausoleo.cuartel_id' =>''.$request->select_cuartel_search.'' ,'cripta_mausoleo.sitio' =>''.$request->sitio_search.' '];
            }
            else if($request->select_cuartel_search!=null && ($request->bloque_search ==null || $request->bloque_search =='' || !isset($request->bloque_search)) && $request->sitio_search==null){
                $condicion=['cripta_mausoleo.cuartel_id' =>''.$request->select_cuartel_search.''];
            }
            else if($request->select_cuartel_search==null && ($request->bloque_search ==null || $request->bloque_search =='' || !isset($request->bloque_search)) && $request->sitio_search!=null){
            //    dd("wer");
                $condicion=['cripta_mausoleo.sitio' =>''.$request->sitio_search.''];
            }
            else if($request->select_cuartel_search==null && $request->bloque_search !=null && $request->sitio_search==null){
                $condicion=['cripta_mausoleo.bloque_id' =>''.$request->bloque_search.''];
            }

            $cripta = Cripta::select('cripta_mausoleo.id', 'cripta_mausoleo.codigo',  'superficie','cripta_mausoleo.estado',
            'tipo_registro','enterratorios_ocupados','total_enterratorios','osarios', 'total_osarios','cenisarios', 'cripta_mausoleo.notable',
            'cripta_mausoleo_responsable.documentos_recibidos',   'cripta_mausoleo_responsable.adjudicacion', 'cripta_mausoleo.difuntos', 'mantenimiento.ultimo_pago',
           'cripta_mausoleo.sitio','cripta_mausoleo.codigo_antiguo','cripta_mausoleo.familia','cripta_mausoleo_responsable.estado as estado_rel_resp',
            DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'),
            'cuartel.codigo as cuartel_codigo','bloque.codigo as bloque_nombre')
            ->Join('cuartel','cuartel.id', '=', 'cripta_mausoleo.cuartel_id' )
            ->leftJoin('bloque','bloque.id', '=', 'cripta_mausoleo.bloque_id' )
           ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
           ->leftJoin('responsable','responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id' )
           ->leftJoin('mantenimiento','mantenimiento.id_ubicacion', '=', 'cripta_mausoleo.id' )
           ->where('cripta_mausoleo.estado', 'ACTIVO')
           ->where($condicion)
           ->orderBy('cripta_mausoleo.id', 'DESC')
           ->orderBy('tipo_registro', 'DESC')
           ->orderBy('cripta_mausoleo.codigo', 'DESC')
           ->get();

        }


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


        // dd( $tipo_service );
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
                        'notable' => 'required',
                        'superficie' => 'required|numeric',
                        // 'status' => 'required'
                    ],[
                        'id_cuartel.required' => 'El campo cuartel es requerido!',
                        'codigo.required' => 'El campo código es requerido!',
                        'sitio.required' => 'El campo sitio es requerido!',
                        'bloque.required' => 'El campo bloque es requerido!',
                        'notable.required' => 'El campo Notable es requerido!',
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

        // $cripta = Cripta::select('cripta_mausoleo1.*', 'responsable.id as responsable_id', 'responsable.nombres','responsable.primer_apellido',
        //                           'responsable.segundo_apellido', 'responsable.ci', 'responsable.domicilio', 'responsable.nombres','responsable.celular',
        //                           'responsable.genero', 'cripta_mausoleo_responsable.id as cripta_mausoleo_resp_id', 'cripta_mausoleo_responsable.documentos_recibidos',
        //                           'cripta_mausoleo_responsable.adjudicacion' ,  'cripta_mausoleo_responsable.ultima_gestion_pagada' )
        //             ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id')
        //             ->leftJoin('responsable', 'responsable.id','=','cripta_mausoleo_responsable.responsable_id')
        //             ->where('cripta_mausoleo.id', $id)
        //             ->where('cripta_mausoleo.estado', 'ACTIVO')

        //             ->first();

        $cripta=Cripta::where('id', $id)->where('estado', 'ACTIVO')->orderBy('id', 'desc')->first();
        $responsable=DB::table('cripta_mausoleo_responsable')
                         ->join('responsable', 'responsable.id','=', 'cripta_mausoleo_responsable.responsable_id')
                         ->where('cripta_mausoleo_responsable.cripta_mausole_id', $id)
                         ->where('cripta_mausoleo_responsable.estado', 'ACTIVO')
                         ->first();



        return response([
              'status'=> true,
              'response'=>[
                "cripta"=>$cripta,
                "responsable"=>$responsable
                   ]
                 ],201);


    }

    public function updateCripta(Request $request){
        // return response()->json([ $request->id_cripta]);
        // dd($request);

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
                        if($existe_resp==null){
                            // if($request->ci_resp!=null)
                            // {
                                $responsable_id=Responsable::insertResponsable($request);
                            // }
                            // else{
                            //     $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);
                            // }
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
                         if($request->ci_resp == null &&  $request->nombres_resp == null  &&  $request->paterno_resp == null  &&  $request->materno_resp == null)
                            {
                                //buscar responsabl ede la cripta o mausoleo
                                $respons=DB::table('cripta_mausoleo_responsable')
                                         ->where('cripta_mausole_id',$cripta_id)
                                         ->where('estado', 'ACTIVO')
                                         ->orderby('id', 'DESC')
                                         ->first();
                                $cmrespons= CriptaMausoleoResp::where('id', $respons->id )
                                ->where('estado', 'ACTIVO')->first();
                                // dd($cmrespons);

                                $cmrespons->estado='INACTIVO';
                                $cmrespons->updated_at = date("Y-m-d H:i:s");
                                $cmrespons->save();
                                return $cmrespons->id;
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

    public function addDifunto(Request $request)
    {
        // dd($request['difuntos']);
        if ($request->isJson())
        {
                $this->validate($request, [
                    'id_cripta_mausoleo' => 'required',
                    'difuntos'=>'required'
                ],[
                    'cripta_mausoleo_id.required' => ':attribute es requerido!' ,
                    'difuntos.required' => ':attribute es requerido!'

                ]);

                //Buscar si ya existe el difunto en la tabla difunto


                    $dif = new Difunto;
                    $newdif=[];
                            foreach($request['difuntos'] as $key => $value)
                            {

                                    if($value['ci']==null || $value['ci']=="" ){
                                        $ci_dif=$this->generateCiDif();
                                    }else{
                                        $ci_dif=$value['ci'];
                                    }

                                    $existe=$this->buscarDifunto( $ci_dif, $value['nombres'], $value['primer_apellido'],$value['segundo_apellido'], $value['fecha_nacimiento']);
                                    // dd($existe);
                                if($existe==false)
                                {
                                    $dif->ci = $ci_dif;
                                    $dif->nombres = $value['nombres'];
                                    $dif->primer_apellido = $value['primer_apellido'];
                                    $dif->segundo_apellido = $value['segundo_apellido'];
                                    $dif->fecha_nacimiento = $value['fecha_nacimiento'];
                                    $dif->fecha_defuncion = $value['fecha_defuncion'];
                                    $dif->certificado_defuncion = $value['ceresi'];
                                    $dif->causa = trim(strtoupper($value['causa']));
                                    $dif->tipo = $value['tipo'];
                                    $dif->edad = $value['edad'];
                                    $dif->genero = $value['genero'];
                                    $dif->funeraria = trim(strtoupper($value['funeraria']));
                                    $dif->certificado_file = trim($value['url']);
                                    $dif->estado = 'ACTIVO';
                                    $dif->user_id = auth()->id();
                                    $dif->save();
                                    $dif->id;

                                    array_push($newdif, [
                                        "ci"=>$ci_dif,
                                        "nombres"=>$value['nombres'],
                                        "primer_apellido"=>$value['primer_apellido'],
                                        "segundo_apellido"=>$value['segundo_apellido'],
                                        "ceresi"=>$value['ceresi'],
                                        "tipo"=>$value['tipo'],
                                        "fecha_nacimiento"=>$value['fecha_nacimiento'],
                                        "fecha_defuncion"=>$value['fecha_defuncion'],
                                        "causa"=>trim(strtoupper($value['causa'])),
                                        "funeraria"=>trim(strtoupper($value['funeraria'])),
                                        "genero"=>$value['genero'],
                                        "url"=>trim($value['url'])
                                    ]);

                                }
                                else{
                                    $up_dif= Difunto::where('ci', ''.$ci_dif.'')
                                    ->first();
                                    $up_dif->ci = $ci_dif;
                                    $up_dif->nombres = $value['nombres'];
                                    $up_dif->primer_apellido = $value['primer_apellido'];
                                    $up_dif->segundo_apellido = $value['segundo_apellido'];
                                    $up_dif->fecha_nacimiento = $value['fecha_nacimiento'];
                                    $up_dif->fecha_defuncion = $value['fecha_defuncion'];
                                    $up_dif->certificado_defuncion = $value['ceresi'];
                                    $up_dif->causa = $value['causa'];
                                    $up_dif->tipo = $value['tipo'];
                                    $up_dif->edad = $value['edad'];
                                    $up_dif->genero = $value['genero'];
                                    $up_dif->funeraria = trim($value['funeraria']);
                                    $up_dif->certificado_file = trim($value['url']);
                                    $up_dif->estado = 'ACTIVO';
                                    $up_dif->user_id = auth()->id();
                                    $up_dif->save();
                                    $up_dif->id;

                                    array_push($newdif, [
                                        "ci"=>$ci_dif,
                                        "nombres"=>$value['nombres'],
                                        "primer_apellido"=>$value['primer_apellido'],
                                        "segundo_apellido"=>$value['segundo_apellido'],
                                        "ceresi"=>$value['ceresi'],
                                        "tipo"=>$value['tipo'],
                                        "fecha_nacimiento"=>$value['fecha_nacimiento'],
                                        "fecha_defuncion"=>$value['fecha_defuncion'],
                                        "causa"=>trim(strtoupper($value['causa'])),
                                        "funeraria"=>trim(strtoupper($value['funeraria'])),
                                        "genero"=>$value['genero'],
                                        "url"=>trim($value['url'])
                                    ]);
                                }
                            }

                        $cript=Cripta::where('id',$request->id_cripta_mausoleo )->first();
                        // $cript->difuntos=json_encode($request['difuntos']);
                        $cript->difuntos=json_encode($newdif);

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


    public function buscarDifunto($ci, $nombres, $primer_apellido, $segundo_apellido, $fecha_nacimiento)
    {
           $difunto_s= DB::table('difunto')->where('ci', ''.$ci.'')
                    ->where('nombres', ''.$nombres.'')
                    ->where('primer_apellido', ''.$primer_apellido.'')
                    ->where('segundo_apellido', ''.$segundo_apellido.'')
                    ->where('fecha_nacimiento', ''.$fecha_nacimiento.'')
                    ->first();
               if(!empty($difunto_s))
               {
                  return $difunto_s;
               }else{
                  return false;
               }
    }



    public function buscarDifuntoEncripta($ci, $nombres, $primer_apellido, $segundo_apellido, $fecha_nacimiento, $fecha_defuncion, $id_cripta)
    {
           $dif_cripta= DB::table('cripta_mausoleo')
           ->select('difuntos')->where('estado','ACTIVO')
           ->where('id', $id_cripta)
           ->first();
           $resp=0;
        //    dd($dif_cripta);
           if($dif_cripta->difuntos != null){
                    $ar_difuntos= json_decode($dif_cripta->difuntos, true);
                    foreach($ar_difuntos as $key=> $value)
                    {
                        if($ci!=null){
                            if($value['ci'] == $ci && $value['nombres'] == $nombres
                              && $value['primer_apellido'] == $primer_apellido && $value['segundo_apellido'] == $segundo_apellido
                              && $value['fecha_nacimiento'] == $fecha_nacimiento  && $value['fecha_defuncion'] == $fecha_defuncion){
                                // unset($ar_difuntos[$key]);
                                $resp++;
                            }
                        }
                        else{
                            if($value['nombres'] == $nombres
                            && $value['primer_apellido'] == $primer_apellido && $value['segundo_apellido'] == $segundo_apellido
                            && $value['fecha_nacimiento'] == $fecha_nacimiento  && $value['fecha_defuncion'] == $fecha_defuncion){
                                //    unset($ar_difuntos[$key]);
                                $resp++;
                              }
                            }
                    }
                }


                  return $resp;

    }

    public function VerificarIngresoExistenteCripta(Request $request)
    {
        $cripta=Cripta::where('estado', 'ACTIVO')->get();
        $resp=0;
        if($cripta){
                foreach($cripta as $c){
                    $idcripta=$c->id;
                    $existe=$this->buscarDifuntoEncripta($request->ci, $request->nombres,
                    $request->primer_apellido,
                    $request->segundo_apellido, $request->fecha_nacimiento,
                    $request->fecha_defuncion, $idcripta);
                        if($existe==0){
                            return $resp;
                        }else{
                            $resp=1;
                            return $resp;
                        }
                }
        }
    }

    public function VerificarIngresoExistenteNicho(Request $request)
    {  $resp=0;
        if($request->ci != null){
            if($request->segundo_apellido=='' || $request->segundo_apellido== null){
                $nicho=DB::table('responsable_difunto')
                ->leftjoin('difunto',  'difunto.id','=','responsable_difunto.difunto_id' )
                ->where('responsable_difunto.estado', 'ACTIVO')
                ->where('difunto.ci',''.$request->ci.'')
                ->where('difunto.nombres',''.$request->nombres.'')
                ->where('difunto.primer_apellido',''.$request->primer_apellido.'')
                ->where('difunto.fecha_nacimiento',''.$request->fecha_nacimiento.'')
                ->where('difunto.fecha_defuncion',''.$request->fecha_defuncion.'')
                // ->where('responsable_difunto.estado_nicho','!=', 'OCUPADO')
                ->orderBy('responsable_difunto.id', 'DESC' )
                ->first();
            }else{
                $nicho=DB::table('responsable_difunto')
                ->leftjoin('difunto',  'difunto.id','=','responsable_difunto.difunto_id' )
                ->where('responsable_difunto.estado', 'ACTIVO')
                ->where('difunto.ci',''.$request->ci.'')
                ->where('difunto.nombres',''.$request->nombres.'')
                ->where('difunto.primer_apellido',''.$request->primer_apellido.'')
                ->where('difunto.segundo_apellido',''.$request->segundo_apellido.'')
                ->where('difunto.fecha_nacimiento',''.$request->fecha_nacimiento.'')
                ->where('difunto.fecha_defuncion',''.$request->fecha_defuncion.'')
                // ->where('responsable_difunto.estado_nicho','!=', 'OCUPADO')
                ->orderBy('responsable_difunto.id', 'DESC' )
                ->first();
            }

        }
        else{
            if($request->segundo_apellido=='' || $request->segundo_apellido== null){

            $nicho=DB::table('responsable_difunto')
            ->leftjoin('difunto',  'difunto.id','=','responsable_difunto.difunto_id' )
            ->where('responsable_difunto.estado', 'ACTIVO')
            ->where('difunto.nombres',''.$request->nombres.'')
            ->where('difunto.primer_apellido',''.$request->primer_apellido.'')
            ->where('difunto.fecha_nacimiento',$request->fecha_nacimiento)
            ->where('difunto.fecha_defuncion',$request->fecha_defuncion)
            // ->where('responsable_difunto.estado_nicho', 'OCUPADO')
            ->orderBy('responsable_difunto.id', 'DESC' )
            ->first();
            }else{

                    $nicho=DB::table('responsable_difunto')
                    ->leftjoin('difunto',  'difunto.id','=','responsable_difunto.difunto_id' )
                    ->where('responsable_difunto.estado', 'ACTIVO')
                    ->where('difunto.nombres',''.$request->nombres.'')
                    ->where('difunto.primer_apellido',''.$request->primer_apellido.'')
                    ->where('difunto.segundo_apellido',''.$request->segundo_apellido.'')
                    ->where('difunto.fecha_nacimiento',$request->fecha_nacimiento)
                    ->where('difunto.fecha_defuncion',$request->fecha_defuncion)
                    // ->where('responsable_difunto.estado_nicho', 'OCUPADO')
                    ->orderBy('responsable_difunto.id', 'DESC' )
                    ->first();
            }



        }
// dd($nicho);
        if($nicho){
            if($nicho->estado_nicho== 'OCUPADO'){
                $resp=1;
            }else{
                $resp=0;
            }


        }
        return $resp;
    }

    public function buscarDifuntoExistente(Request $request){
        $resp=0;
        $existeEnCripta=$this->VerificarIngresoExistenteCripta($request);
        $existeEnNicho=$this->VerificarIngresoExistenteNicho($request);
        // dd($existeEnNicho);
        if( $existeEnCripta > 0 || $existeEnNicho > 0 ){
             $resp=1;
        }

        // dd($resp);
        return $resp;

    }

    public function getDifuntoCripta(Request $request){
        // dd($request->cripta_mausoleo_id);
        $difuntoCript =  Cripta::where('id', $request->cripta_mausoleo_id)->first();
        $difuntoResp =  DB::table('cripta_mausoleo_responsable')->where('cripta_mausole_id', $request->cripta_mausoleo_id)->first();
        if(!empty($difuntoResp)){
            if($difuntoResp->responsable_id!=null){
                  $resp =  DB::table('responsable')->where('id', $difuntoResp->responsable_id)->first();

            }
        }
        if($resp &&  $difuntoCript){
            return response([
                'status'=> true,
                'response'=> $difuntoCript,
                'responsable'=> $resp
             ],200);
        }
        else{
            return response([
                'status'=> false,
                'mensaje'=> "Es probable que la cripta aun no este asociado a un responsable, por favor verifique o complete registro"
             ],201);
        }

    }
    public function generateCiDif(){
        $dif=new Difunto;
        $nro_ci=$dif->generateCiDifunto();
        // dd( $nro_ci);
        return $nro_ci;
    }


    //obtener servicios criptas mausoleos
    public function getServices(){
        $headers = [
            'Content-Type' => 'application/json'
        ];
        try {
            $client = new Client();
            $response = $client->get('https://multiserv.cochabamba.bo/api/v1/cementerio/get-services', [
                'json' => [],
                'headers' => $headers
            ]);
        } catch (RequestException $re) {
            return response([
                'status' => false,
                'message' => 'Error al procesar su solicitud'
            ], 200);
        }

        $tipo_service = json_decode((string) $response->getBody(), true);
        return $tipo_service;
    }


            public function printMausoleoNotables(Request $request){
                $cripta = Cripta::select('cripta_mausoleo.id', 'cripta_mausoleo.codigo',  'superficie','cripta_mausoleo.estado',
                'tipo_registro','enterratorios_ocupados','total_enterratorios','osarios', 'total_osarios','cenisarios', 'cripta_mausoleo.notable',
                'cripta_mausoleo_responsable.documentos_recibidos',   'cripta_mausoleo_responsable.adjudicacion', 'cripta_mausoleo.difuntos', 'mantenimiento.ultimo_pago',
               'cripta_mausoleo.sitio','cripta_mausoleo.codigo_antiguo','cripta_mausoleo.familia','cripta_mausoleo_responsable.estado as estado_rel_resp',
                DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'),
                'cuartel.codigo as cuartel_codigo','bloque.codigo as bloque_nombre')
                ->Join('cuartel','cuartel.id', '=', 'cripta_mausoleo.cuartel_id' )
                ->leftJoin('bloque','bloque.id', '=', 'cripta_mausoleo.bloque_id' )
               ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
               ->leftJoin('responsable','responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id' )
               ->leftJoin('mantenimiento','mantenimiento.id_ubicacion', '=', 'cripta_mausoleo.id' )
               ->where('cripta_mausoleo.estado', 'ACTIVO')
               ->where('cripta_mausoleo.tipo_registro', 'MAUSOLEO')
               ->where('cripta_mausoleo.notable', 'SI')
               ->orderBy('cripta_mausoleo.id', 'DESC')
               ->orderBy('tipo_registro', 'DESC')
               ->orderBy('cripta_mausoleo.codigo', 'DESC')
               ->get();

            //    $pdf = new PDF();
            //    $pdf = PDF::setPaper('a4', 'landscape');
               $pdf = PDF::loadView('cripta/reportMausoleoNotable', compact('cripta'))->setPaper('a4', 'landscape');
               return  $pdf-> stream("Lista_mausoleo_notables.pdf", array("Attachment" => false));
            }

            public function printCriptaNotables(Request $request){
                $cripta = Cripta::select('cripta_mausoleo.id', 'cripta_mausoleo.codigo',  'superficie','cripta_mausoleo.estado',
                'tipo_registro','enterratorios_ocupados','total_enterratorios','osarios', 'total_osarios','cenisarios', 'cripta_mausoleo.notable',
                'cripta_mausoleo_responsable.documentos_recibidos',   'cripta_mausoleo_responsable.adjudicacion', 'cripta_mausoleo.difuntos', 'mantenimiento.ultimo_pago',
               'cripta_mausoleo.sitio','cripta_mausoleo.codigo_antiguo','cripta_mausoleo.familia','cripta_mausoleo_responsable.estado as estado_rel_resp',
                DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'),
                'cuartel.codigo as cuartel_codigo','bloque.codigo as bloque_nombre')
                ->Join('cuartel','cuartel.id', '=', 'cripta_mausoleo.cuartel_id' )
                ->leftJoin('bloque','bloque.id', '=', 'cripta_mausoleo.bloque_id' )
               ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
               ->leftJoin('responsable','responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id' )
               ->leftJoin('mantenimiento','mantenimiento.id_ubicacion', '=', 'cripta_mausoleo.id' )
               ->where('cripta_mausoleo.estado', 'ACTIVO')
               ->where('cripta_mausoleo.tipo_registro', 'CRIPTA')
               ->where('cripta_mausoleo.notable', 'SI')
               ->orderBy('cripta_mausoleo.id', 'DESC')
               ->orderBy('tipo_registro', 'DESC')
               ->orderBy('cripta_mausoleo.codigo', 'DESC')
               ->get();

               $pdf = new PDF();
            //    $pdf = PDF::setPaper('a4', 'landscape');

               $pdf = PDF::loadView('cripta/reportCriptaNotable', compact('cripta'))->setPaper('a4', 'landscape');
            //    $pdf = PDF::page_text(1,1, "{PAGE_NUM} of {PAGE_COUNT}", 'Arial', 10, array(0,0,0));
               return  $pdf-> stream("Lista_criptas_notables.pdf", array("Attachment" => false));


            }


            //setup-cripta-notification

            public function configNotificacion(){
                return view('cripta.frm_notificacion_cripta');
            }
}

