<?php

namespace App\Http\Controllers\Servicios;

use App\Models\Servicios;
use App\Models\Nicho;
use App\Models\Cuartel;
use App\Models\Difunto;
use App\Models\Responsable;

use App\Http\Controllers\Controller;
use App\Models\Servicios\ServicioNicho;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
{

    public function __construct()
    {
       
        $this->middleware('auth', ['except' => ['updatePay']]);

    }
    public function index(){
        
        $servicio =DB::table('responsable_difunto')
                 ->select('responsable_difunto.*', 
                  'responsable.nombres as nombre_resp', 'responsable.primer_apellido as primerap_resp', 
                  'responsable.segundo_apellido as segap_resp',  
                  'difunto.nombres as nombre_dif', 'difunto.primer_apellido as primerap_dif', 'difunto.segundo_apellido as segap_dif',
                  'nicho.codigo',
                  'servicio_nicho.codigo_nicho', 'servicio_nicho.tipo_servicio', 'servicio_nicho.fur' )                
                 ->join('responsable' , 'responsable.id','=', 'responsable_difunto.responsable_id')
                 ->join('difunto' , 'difunto.id','=', 'responsable_difunto.difunto_id')
                 ->join('nicho' , 'nicho.codigo','=', 'responsable_difunto.codigo_nicho')
                 ->join('servicio_nicho' , 'servicio_nicho.responsable_difunto_id','=', 'responsable_difunto.id')
                 ->distinct('servicio_nicho.fur')->get();
            
                     return view('servicios/index',['servicio' =>$servicio]);
    }

    public function cargarForm(){
        
       
        return view('servicios/formRegistro');
    }

    public function buscar_nicho(Request $request){
       
        $sql =DB::table('responsable_difunto')
        ->select('responsable_difunto.*', 
                'responsable.segundo_apellido as segap_resp',   'responsable.fecha_nacimiento as nacimiento_resp', 
                'responsable.telefono as tel_resp', 
                'responsable.celular as cel_resp', 
                'responsable.estado_civil as ecivil_resp', 
                'responsable.genero as genero_resp', 
                'responsable.email as email_resp', 
                'responsable.domicilio as domicilio_resp', 
                'difunto.ci as ci_dif',
                'difunto.nombres as nombre_dif', 'difunto.primer_apellido as primerap_dif', 'difunto.segundo_apellido as segap_dif',                 
                'difunto.segundo_apellido as segap_dif',
                'difunto.fecha_nacimiento as fecha_nac_dif',
                'difunto.fecha_defuncion as fecha_def_dif',
                'difunto.causa as causa_dif',
                'difunto.tipo as tipo_dif',
                'difunto.genero as genero_dif',
                'difunto.certificado_file',
                'servicio_nicho.fur',
                'nicho.codigo','bloque.codigo','cuartel.codigo','nicho.nro_nicho')   
                ->join('servicio_nicho', 'servicio_nicho.codigo_nicho','=', 'responsable_difunto.codigo_nicho')           
        ->leftJoin('responsable' , 'responsable.id','=', 'responsable_difunto.responsable_id')
        ->leftJoin('difunto' , 'difunto.id','=', 'responsable_difunto.difunto_id')
        ->join('nicho' , 'nicho.codigo','=', 'responsable_difunto.codigo_nicho')
        ->leftJoin('cuartel' , 'cuartel.id','=', 'nicho.cuartel_id')
        ->leftJoin('bloque' , 'bloque.id','=', 'nicho.bloque_id')
        ->where('bloque.codigo','=', $request->bloque )
        ->where('nicho.nro_nicho','=', $request->nro_nicho )
        ->where('nicho.fila','=', $request->fila ) 
        ->distinct('servicio_nicho.fur')->get();
//    dd($sql);
            if($sql){
                    return response([
                        'status'=> true,
                        'response'=> $sql
                    ],200);
                }else{
                    return response([
                        'status'=> false,
                        'message'=> 'Error, codigo existente, duplicado!)'
                    ],400);
                }

            
        // return response()->json($resp);
    }

    public function createNewServicios(Request $request){
        dd($request);
        if($request->isJson()){            
            $this->validate($request, [
                'nro_nicho'=> 'required',
                'bloque'=> 'required',
                'cuartel'=> 'required',
                'fila'=> 'required',
                'tipo'=> 'required',
                'columna'=> 'required',
                'ci_dif'=> 'required',
                'nombres_dif'=> 'required',
                'paterno_dif'=> 'required',
                'tipo_dif'=> 'required',
                'genero_dif'=> 'required',
                'ci_resp'=> 'required',
                'nombres_resp'=> 'required',
                'paterno_resp'=> 'required',
                'celular'=> 'required',
                'ecivil'=> 'required',
                'email'=> 'required',
                'domicilio'=> 'required',
                'genero_resp'=> 'required',

                'tserv'=> 'required',
                'cuenta'=> 'required',
                'hserv'=> 'required',
                'servicio'=> 'required',                            
                'cantidad'=> 'required',
                'unidad'=> 'required',
                'precio'=> 'required',
                'montoserv'=> 'required',


                'cantidad' => 'required',
                'unidad' => 'required',
                'precio_unitario' => 'required',
                'monto' => 'required',
                'ultimopago'=>'required',
                'hserv'=>'required',
                'servicio'=>'required',
                'cuenta'=>'required',
                'tipo_serv'=>'required'

                
            ], [
                'cantidad.required'  => 'El campo cantidad es obligatorio!',
                'unidad.required' => 'El campo Codigo cuartel es obligatorio!',
                'cuenta.required' => 'Debe asignar al menos un servicio!.'
            ]);
            //buscar si existe registrado el nicho sino existe registrarlo
                    $codigo_n=$request->cuartel.".".$request->bloque.".".$request->nro_nicho.".".$request->fila;
                    $existeNicho= Nicho::where('codigo', $codigo_n)->first();
                    
                    dd($existeNicho);

                    //if($existeNicho)

                //si id_difunto id_responsable es null insertar difunto insertar responsable
                    if($request->id_difunto==""){
                        //insertar difunto

                    }else{
                        $difuntoid=$request->difunto_id;
                    }

                    if($request->id_responsable==""){
                        //insertar difunto

                    }else{
                        $responsableid=$request->responsable_id;
                    }


                //
              
              

                if (!empty($request->cuenta) && is_array($request->cuenta)) {
                    $count = count($request->cuenta);
                    $codigo_nicho=$request->cuartel.".".$request->bloque.".".$request->nicho.".".$request->fila;

                    
                    /** generar fur */
                    $nombre_difunto=$request->nombres_dif." ".$request->primerap_dif." ".$request->segap_dif;
                    // $response = $this->GenerarFur($request->search_resp, $request->nombres_resp, $request->primerap_resp,
                    // $request->segapresp, $request->domicilio, $request->telefono, $nombre_difunto, $codigo_nicho,
                    // $request->bloque, $request->nro_nicho, $request->fila, $request->servicio );
                   
                    // if($response['status']==true){
                    //     $fur = $response['response'];
                       
                    // }
                    $fur="165235";
                   
                    //   
                    
                }


           
              
              
            }
    }

            public function GenerarFur($ci, $nombre, $primer_apellido,
                $ap_materno, $direccion, $telefono, $nombre_difunto, $codigo,
                $bloque, $nicho, $fila, $servicios_cementery )
                    {
                    
                //dd( $servicios_cementery);
                        $headers =  ['Content-Type' => 'application/json'];
                        $client = new Client();
                        $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery', [
                            'json' => [
                                'ci' => $ci,
                                'nombre' => $nombre,
                                'primer_apellido' => $primer_apellido,
                                'ap_materno' => $ap_materno,
                                'direccion' => $direccion,
                                'telefono' => $telefono,
                                'nombre_difunto' => $nombre_difunto,
                                'codigo' => $codigo,
                                'bloque' => $bloque,
                                'fila' => $fila,
                                'nicho' => $nicho,
                                'servicios_cementery' => $servicios_cementery

                            ],
                            'headers' => $headers,
                        ]);
                        $fur_response = json_decode((string) $response->getBody(), true);
                    
                        return $fur_response;
            }
    
}
