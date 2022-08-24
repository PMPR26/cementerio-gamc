<?php

namespace App\Http\Controllers\Cripta;

use App\Models\Bloque;
use App\Models\Cripta;
use App\Models\Cuartel;
use App\Models\Responsable;
use App\Models\CriptaMausoleo;
use App\Models\CriptaMausoleoResp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CriptaController extends Controller
{
    public function index(){

        $cripta = Cripta::select('cripta_mausoleo.id', 'codigo',  'superficie','cripta_mausoleo.estado',
         'tipo_registro','enterratorios_ocupados','total_enterratorios','osarios', 'total_osarios','cenisarios',
         'cripta_mausoleo_responsable.documentos_recibidos',
         DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre')) 
        ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )   
        ->leftJoin('responsable','responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id' )    
        ->orderBy('cripta_mausoleo.id', 'DESC') 
        ->orderBy('tipo_registro', 'DESC') 
        ->orderBy('cripta_mausoleo.codigo', 'DESC')  

        // ->orderBy('nombre', 'DESC')
        ->get();

         $cuartel = Cuartel::select('id','codigo')
                    ->where('estado', 'ACTIVO')                   
                    ->orderBy('nombre', 'DESC')
                    ->get();

        return view('cripta.index', ['cripta' => $cripta, 'cuartel' => $cuartel]);

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
                                else{   dd("entraa");
                                    $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);  
                                }
                            }else{
                                $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);  
                            }
                            // dd($responsable_id);
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
                            else{   dd("entraa");
                                $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);  
                            }
                        }else{
                            $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);  
                        }
                        // dd($responsable_id);
                }
                    //insert cripta mausoleo
                    $existe=$this->existeCripta($request);
            
                  
                            $cripta_id=Cripta::upCripta($request, $existe->id);  
                  
                 
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
                ],201);
    }
    else{
        return response([
            'status'=> false,
            'response'=> "La Cripta ya fue registrada"
        ],201);
    }
    }

    public function existeCripta(Request $request){

         $cripta = DB::table('cripta_mausoleo')->where('cuartel_id', $request->id_cuartel)
                           ->where('bloque_id', $request->bloque)
                           ->where('sitio', $request->sitio)
                           ->where('superficie', $request->superficie)
                           ->first();
                    //    dd($request->id_cripta )    ;     
                           if(!empty($cripta))                           
                               return   $cripta;
                                else
                                return false;
                          
       

      
    }

    public function buscarCriptaM(Request $request){
    //    dd($request->tipo_busqueda);
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

}


// select * from "cripta_mausoleo1" 
// left join "cripta_mausoleo_responsable" on "cripta_mausoleo_responsable"."cripta_mausole_id" = "cripta_mausoleo"."id" 
// left join "responsable" on "responsable"."id" = "cripta_mausoleo_responsable"."responsable_id" 
// left join "cripta_mausoleo_difunto" on "cripta_mausoleo_difunto"."cripta_mausoleo_id" = "cripta_mausoleo"."id" 
// left join "difunto" on "difunto"."id" = "cripta_mausoleo_difunto"."difunto_id" where "codigo_antiguo" = cod_ant limit 1