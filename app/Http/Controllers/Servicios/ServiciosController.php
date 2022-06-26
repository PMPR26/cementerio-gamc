<?php

namespace App\Http\Controllers\Servicios;

use App\Models\Nicho;
use App\Models\Cuartel;
use App\Models\Bloque;
use App\Models\Servicios\ServicioNicho;
use App\Models\Difunto;
use App\Models\Responsable;
use App\Models\ResponsableDifunto;
use App\Models\User;

use App\Models\Mantenimiento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PDF;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Empty_;

class ServiciosController extends Controller
{

    public function __construct()
    {
        $this->middleware('api', ['except' => ['updatePay']]);
    }


    public function index()
    {

        $servicio = DB::table('responsable_difunto')
            ->select(
                'responsable_difunto.*',
                'responsable.nombres as nombre_resp',
                'responsable.primer_apellido as primerap_resp',
                'responsable.segundo_apellido as segap_resp',
                'difunto.nombres as nombre_dif',
                'difunto.primer_apellido as primerap_dif',
                'difunto.segundo_apellido as segap_dif',
                'nicho.codigo',
                'servicio_nicho.codigo_nicho',
                'servicio_nicho.tipo_servicio',
                'servicio_nicho.servicio',
                'servicio_nicho.fur',
                'servicio_nicho.monto',
                'servicio_nicho.nombrepago',
                'servicio_nicho.paternopago',
                'servicio_nicho.maternopago',
                'servicio_nicho.estado_pago',
                'servicio_nicho.id as serv_id'
            )
            ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
            ->join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
            ->join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
            ->join('servicio_nicho', 'servicio_nicho.responsable_difunto_id', '=', 'responsable_difunto.id')
            ->where('servicio_nicho.estado','ACTIVO')
            ->orderBy('servicio_nicho.id', 'DESC')
            ->get();

          

        return view('servicios/index', ['servicio' => $servicio]);
    }

    public function cargarForm()
    {

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
            // return response([
            //     'status' => false,
            //     'message' => 'Error al procesar su solicitud'
            // ], 200);
        }

        $tipo_service = json_decode((string) $response->getBody(), true);

        $funeraria=DB::table('difunto')
        ->select('funeraria')
        ->whereNotNull('funeraria')
        ->distinct()->get();

        $causa=DB::table('difunto')
        ->select('causa')
        ->whereNotNull('causa')
        ->distinct()->get();

        return view('servicios/formRegistro', ['tipo_service' => $tipo_service['response'], 'funeraria' => $funeraria, 'causa' => $causa]);
    }
 

    public function buscar_nicho(Request $request)
    {

        $sql = DB::table('responsable_difunto')
            ->select(DB::raw('
            
               responsable_difunto.*,
               responsable.segundo_apellido as segap_resp,
               responsable.fecha_nacimiento as nacimiento_resp,
               responsable.telefono,
               responsable.celular,
               responsable.estado_civil as ecivil_resp,
               responsable.genero as genero_resp,
               responsable.email as email_resp,
               responsable.domicilio as domicilio_resp,
               responsable.ci as ci_resp,
               responsable.nombres as nombre_resp,
               responsable.primer_apellido as paterno_resp,
               responsable.segundo_apellido as segap_resp,
               difunto.ci as ci_dif,
               difunto.nombres as nombre_dif,
               difunto.primer_apellido as primerap_dif,
               difunto.segundo_apellido as segap_dif,
               difunto.segundo_apellido as segap_dif,
               difunto.fecha_nacimiento as nacimiento_dif,
               difunto.fecha_defuncion as fecha_def_dif,
               difunto.causa as causa_dif,
               difunto.tipo as tipo_dif,
               difunto.certificado_defuncion,
               difunto.genero as genero_dif,
               difunto.certificado_file,
               difunto.funeraria,
               servicio_nicho.fur,
                CONCAT(servicio_nicho.nombrepago , \' \',servicio_nicho.paternopago, \' \', servicio_nicho.maternopago) AS razon,
               servicio_nicho.ci as ci_pago,
               servicio_nicho.fecha_pago as fecha_pago,
               servicio_nicho.monto as monto,
               servicio_nicho.nro_renovacion,
               servicio_nicho.monto_renovacion,
               nicho.tipo as tipo_nicho,
               nicho.codigo as nicho,
               nicho.codigo_anterior as anterior,
               bloque.codigo as bloque,
               cuartel.codigo as cuartel,
               nicho.nro_nicho,
               nicho.cantidad_cuerpos

                ') )
            ->join('servicio_nicho', 'servicio_nicho.codigo_nicho', '=', 'responsable_difunto.codigo_nicho')
            ->leftJoin('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
            ->leftJoin('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
            ->join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
            ->leftJoin('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
            ->leftJoin('bloque', 'bloque.id', '=', 'nicho.bloque_id')
            ->where('bloque.codigo', '=',''. $request->bloque.'')
            ->where('nicho.nro_nicho', '=',''. $request->nicho.'')
            ->where('nicho.fila', '=', $request->fila)
            ->orderBy('servicio_nicho.id', 'DESC')
            ->first();
            if($sql){
                $mensaje=true;
            }
            else{
                $mensaje= false;
            }
    
            $resp= [
                "mensaje" => $mensaje,
                "response"=>$sql
                ];

             return response()->json($resp);
        
    }



    // public function generateFur(Request $request)
    // {

    //     $this->validate($request, [
    //         'ci' => 'required',
    //         'nombre' => 'required',
    //         'primer_apellido' => 'required',
    //         'ap_materno' => 'max:30',
    //         'direccion' => 'max:200',
    //         'telefono' => 'max:10',
    //         'nombre_difunto' => 'required|max:50',
    //         'codigo' => 'required',
    //         'bloque' => 'required',
    //         'nicho' => 'required',
    //         'fila' => 'required',
    //         'servicios_cementery' => 'required'
    //     ]);

    //     $headers =  ['Content-Type' => 'application/json'];
    //     $client = new Client();
    //     $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery', [
    //         'json' => [
    //             'ci' => $request->ci,
    //             'nombre' => $request->nombre,
    //             'primer_apellido' => $request->primer_apellido,
    //             'ap_materno' => $request->ap_materno,
    //             'direccion' => $request->direccion,
    //             'telefono' => $request->telefono,
    //             'nombre_difunto' => $request->nombre_difunto,
    //             'codigo' => $request->codigo,
    //             'bloque' => $request->bloque,
    //             'fila' => $request->fila,
    //             'nicho' => $request->nicho,
    //             'servicios_cementery' => $request->servicios_cementery
    //         ],
    //         'headers' => $headers,
    //     ]);
    //     $fur_response = json_decode((string) $response->getBody(), true);

    //     return $fur_response;
    // }

    //service update pay from sinot
    public function updatePay(Request $request)
    {

        if ($request->isJson()) {
            $this->validate($request, [
                "fur" => 'required',
                "id_usuario_caja" => 'required'
            ]);

            $servicio = ServicioNicho::select('id', 'fur')
                ->where(['fur' => trim($request->fur), 'estado_pago' => false, 'estado' => 'ACTIVO'])
                ->first();

            if ($servicio) {
                ServicioNicho::where('fur', trim($request->fur))
                    ->update([
                        'estado_pago' => true,
                        'id_usuario_caja' => $request->id_usuario_caja,
                        'fecha_pago' => date('Y-m-d h:i:s')
                    ]);
                return response([
                    'status' => true
                    // 'message'=> 'El nro fur  no existe o ya fue pagado por favor recargue la pagina'
                ], 200);
            } else {
                return response([
                    'status' => false,
                    'message' => 'El nro fur  no existe o ya fue pagado por favor recargue la pagina'
                ], 200);
            }
        } else {
            return response([
                'status' => false,
                'message' => 'No autorizado'
            ], 401);
        }
    }



    public function createNewServicios(Request $request)
    {
//  dd($request->fechanac_dif);
        if ($request->isJson()) 
        {

            if($request->externo == "externo" && $request->gratis == "gratis"){
                $this->validate($request, [
                  
                    'ci_dif' => 'required',
                    'nombres_dif' => 'required',
                    'paterno_dif'=> 'required',
                    'tipo_dif'=> 'required',
                    'genero_dif'=> 'required',
                    'ci_resp' => 'required',
                    'nombres_resp' => 'required',
                    'paterno_resp'=> 'required',                
                    'domicilio'=> 'required',
                    'genero_resp'=> 'required',
                    'tipo_servicio' => 'required',
                    'servicio_hijos' => 'required',   
                    
                ], [
                    'ci_dif.required' => 'El campo ci del difunto es obligatorio, si no tiene documento presione el boton "generar carnet provisional  (icono lapiz)" para asignarle un numero provisional',
                    'nombres_dif.required' => 'El campo nombres del difunto es obligatorio',
                    'paterno_dif.required'=> 'El campo primer apellido  del difunto es obligatorio',
                    'tipo_dif.required' => 'El campo tipo de difunto (adulto o parvulo) es obligatorio',
                    'genero_dif.required'=> 'El campo genero del difunto es obligatorio',
                    'ci_resp.required' => 'El campo ci del responsable es obligatorio, si no tiene documento presione el boton "generar carnet provisional (icono lapiz)" para asignarle un numero provisional',
                    'nombres_resp.required' => 'El campo nombre del responsable es obligatorio',
                    'paterno_resp.required'=> 'El campo apellido paterno del responsable  es obligatorio',                  
                    'domicilio.required'=> 'El campo domicilio es obligatorio',
                    'genero_resp.required'=> 'El campo genero_resp es obligatorio',
                    'tipo_servicio.required' => 'Debe seleccionar al menos un tipo de servicio',
                    'servicio_hijos.required' => 'Debe seleccionar al menos un servicio',                    
                ]);
            }
            else{

          
            $this->validate($request, [
                'nro_nicho' => 'required',
                'bloque' => 'required',
                'cuartel' => 'required',
                'fila' => 'required',
                'tipo_nicho' => 'required',
                'ci_dif' => 'required',
                'nombres_dif' => 'required',
                'paterno_dif'=> 'required',
                'tipo_dif'=> 'required',
                'genero_dif'=> 'required',
                'ci_resp' => 'required',
                'nombres_resp' => 'required',
                'paterno_resp'=> 'required',
               // 'celular'=> 'required',
               // 'ecivil'=> 'required',
               // 'email'=> 'required',
                'domicilio'=> 'required',
                'genero_resp'=> 'required',
                'tipo_servicio' => 'required',
                'servicio_hijos' => 'required',

                
            ], [
                'nro_nicho.required' => 'El campo nicho es obligatorio',
                'bloque.required' => 'El campo bloque es obligatorio',
                'cuartel.required' => 'El campo cuartel es obligatorio',
                'fila.required' => 'El fila nicho es obligatorio',
                'tipo_nicho.required' => 'El campo tipo de nicho es obligatorio',
                'ci_dif.required' => 'El campo ci del difunto es obligatorio, si no tiene documento presione el boton "generar carnet provisional  (icono lapiz)" para asignarle un numero provisional',
                'nombres_dif.required' => 'El campo nombres del difunto es obligatorio',
                'paterno_dif.required'=> 'El campo primer apellido  del difunto es obligatorio',
                'tipo_dif.required' => 'El campo tipo de difunto (adulto o parvulo) es obligatorio',
                 'genero_dif.required'=> 'El campo genero del difunto es obligatorio',
                'ci_resp.required' => 'El campo ci del responsable es obligatorio, si no tiene documento presione el boton "generar carnet provisional (icono lapiz)" para asignarle un numero provisional',
                'nombres_resp.required' => 'El campo nombre del responsable es obligatorio',
                 'paterno_resp.required'=> 'El campo apellido paterno del responsable  es obligatorio',
               //  'celular.required'=> 'El campo celular es obligatorio',
                // 'ecivil.required'=> 'El campo estado civil  es obligatorio',
                // 'email.required'=> 'El campo email es obligatorio',
                 'domicilio.required'=> 'El campo domicilio es obligatorio',
                 'genero_resp.required'=> 'El campo genero_resp es obligatorio',
                'tipo_servicio.required' => 'Debe seleccionar al menos un tipo servicio',
                'servicio_hijos.required' => 'Debe seleccionar al menos un servicio',

               
            ]);
            }  
             $datos_cajero=User::select()
            ->where('id',auth()->id())
            ->first();
            $cajero= $datos_cajero->user_sinot;

            
            if ($request->person != "responsable") {
                $pago_por = "Tercera persona";
                $nombre_pago = $request->name_pago;
                $paterno_pago = $request->paterno_pago;
                $materno_pago = $request->materno_pago;
                $ci = $request->ci;
                $domicilio = "SIN ESPECIFICACION";
            } else {
                        $pago_por = "Titular responsable";
                        $nombre_pago = $request->nombres_resp;
                        if ($request->paterno_resp == "") {
                            $paterno_pago = "NO DEFINIDO";
                        } else {
                            $paterno_pago = $request->paterno_resp;
                        }
                        if ($request->domicilio == "") {
                            $domicilio = "NO DEFINIDO";
                        } else {
                            $domicilio = $request->domicilio;
                        }

                        $materno_pago = $request->materno_resp ?? '';
                        $ci = $request->ci_resp;
            }

            if (!empty($request->servicio_hijos) && is_array($request->servicio_hijos)) {
              
                $cod_n = $request->cuartel . "." . $request->bloque . "." . $request->nro_nicho . "." . $request->fila;
                $cantidadEnNicho=$this->contarDifuntoEnNicho($cod_n);
                $difuntoEnNicho=$this->buscarDifuntoEnNicho($request->ci_dif);
                foreach($request->servicio_hijos as $servi){
                    if($servi=='1979' || $servi=='1977' || $servi=='1978'  || $servi=='1981' || $servi=='1980' || $servi=='1982')
                    {
                                $estado_nicho="OCUPADO";
                              if($servi=='1979' || $servi=='1977' || $servi=='1978'){
                              
                                    if( $cantidadEnNicho !=false){
                                        return response([
                                            'status'=> false,
                                            'response'=>"temporal_ocupado"
                                        ],200);
                                    }else{
                                        $cant=1;
                                    }
                              }else if($servi=='1981' || $servi=='1980' || $servi=='1982'){

                       
                                    if($difuntoEnNicho==false)
                                    {
                                            $cantidadEnNicho=$this->contarDifuntoEnNicho($cod_n);
                                            if( $cantidadEnNicho !=false){
                                                $cant= $cantidadEnNicho + 1;
                                            }else{
                                                $cant=1;
                                            }
                                    
                                    }else{
                                                if( $cantidadEnNicho !=false){
                                                    $cant= $cantidadEnNicho;
                                                }else{
                                                    $cant=1;
                                                }
                                    
                                    }
                                }
                    }else if($servi == '645' || $servi =='644'){    
                        if($difuntoEnNicho==false)
                        {
                            $est_nicho="EXHUMADO";                            
                            $observacion="Exhumado en fecha".date('d/m/Y')." solicitante exhumación (". $pago_por. ") " .$nombre_pago. " ". $paterno_pago ." ".$materno_pago. " ci: ".$ci; // . 
                        }
                        else{
                           
                            $responsable_id=$difuntoEnNicho->responsable_id;
                            $difunto_id=$difuntoEnNicho->difunto_id;
                            $est_nicho="EXHUMADO";
                            $observacion="Exhumado en fecha".date('d/m/Y')." solicitante exhumación (". $pago_por. ") " .$nombre_pago. " ". $paterno_pago ." ".$materno_pago. " ci: ".$ci; // . 
                        }
                     

                                if( $cantidadEnNicho == 1 ){
                                    $estado_nicho="LIBRE";
                                    $cant= $cantidadEnNicho -1;
                                }
                                else if( $cantidadEnNicho >= 1){
                                    $estado_nicho="OCUPADO";
                                    $cant = $cantidadEnNicho -1;
                                } 
                                else if( $cantidadEnNicho == 0){
                                    $estado_nicho="LIBRE";
                                    $cant= 0;
                                }                                
                            }
                    else{
                        $estado_nicho="OCUPADO";
                        if($cantidadEnNicho >0){
                            $cant=$cantidadEnNicho;
                        }else{
                            $cant=1;
                        }                        
                    }
                    
                }
            
            if($request->externo=="externo"){
                $codigo_n="00000" ;
                $estado_nicho="EXTERNO";
                $codigo_nicho = $codigo_n;
            }
            else{
                        $codigo_n = $request->cuartel . "." . $request->bloque . "." . $request->nro_nicho . "." . $request->fila;
                        $existeNicho = Nicho::where('codigo', $codigo_n)->first();

                        if ($existeNicho != null) {
                            $id_nicho = $existeNicho->id;
                            $upnicho= Nicho::where('id',  $id_nicho)->first();
                            if(isset($estado_nicho)){                            
                                $upnicho->estado_nicho=$estado_nicho;
                            }

                            $upnicho->cantidad_cuerpos=$cant;
                            $upnicho->codigo_anterior=$request->anterior;
                            $upnicho->save();
                            $upnicho->id;

                        } else {      // buscar cuartel si existe recuperar id sino insertar
                                        $existeCuartel = Cuartel::where('codigo', $request->cuartel)->first();
                                        if ($existeCuartel != null) {
                                            $id_cuartel = $existeCuartel->id;
                                        } else {
                                            $cuart = new Cuartel;
                                            $cuart->codigo = trim($request->cuartel);
                                            $cuart->nombre = trim($request->cuartel);
                                            $cuart->estado = 'ACTIVO';
                                            $cuart->user_id = auth()->id();
                                            $cuart->save();
                                            $cuart->id;
                                            $id_cuartel = $cuart->id;
                                        }

                                        //buscar bloque si existe recuperar id sino insertar
                                        $existeBloque = Bloque::where('codigo', $request->bloque)
                                        ->where('cuartel_id', $id_cuartel)
                                        ->first();
                                      
                                        if ($existeBloque != null) {
                                            $id_bloque = $existeBloque->id;
                                        } else {
                                            $bloq = new Bloque;
                                            $bloq->cuartel_id = $id_cuartel;
                                            $bloq->codigo = trim($request->bloque);
                                            $bloq->nombre = trim($request->bloque);
                                            $bloq->estado = 'ACTIVO';
                                            $bloq->user_id = auth()->id();
                                            $bloq->save();
                                            $bloq->id;
                                            $id_bloque = $bloq->id;
                                            
                                        }

                                        // insertar nicho
                                        $nicho = new Nicho;
                                        $nicho->cuartel_id = $id_cuartel;
                                        $nicho->bloque_id = $id_bloque;
                                        $nicho->nro_nicho = $request->nro_nicho;
                                        $nicho->fila = $request->fila;
                                        $nicho->tipo = $request->tipo_nicho;
                                        $nicho->codigo = $request->cuartel . "." . $request->bloque . "." . $request->nro_nicho . "." . $request->fila;
                                        $nicho->codigo_anterior = $request->anterior;
                                        $nicho->estado_nicho =$estado_nicho;
                                        $nicho->cantidad_cuerpos =$cant;
                                        $nicho->user_id = auth()->id();
                                        $nicho->save();
                                        $nicho->id;
                                        $id_nicho = $nicho->id;
                                    }
            // end nicho

            $codigo_nicho = $request->cuartel . "." . $request->bloque . "." . $request->nro_nicho . "." . $request->fila;

            }
            //step1: nicho buscar si existe registrado el nicho recuperar el id  sino existe registrarlo
            

            // step2: register difunto --- si id_difunto id_difunto es null insertar difunto insertar responsable
            $existeDifunto = Difunto::where('ci', $request->ci_dif)->first();
            if ( !$existeDifunto) {
                //insertar difunto
                $difuntoid = $this->insertDifunto($request);
            } else {
                $difuntoid = $existeDifunto->id;
                $this->updateDifunto($request, $difuntoid);
            }
            // end difunto
            // step4: register responsable -- si el responsable  
            $existeResponsable = Responsable::where('ci', $request->ci_resp)->first();
            if (!$existeResponsable) {
                //insertar difunto
                $idresp = $this->insertResponsable($request);
            } else {
                $idresp = $existeResponsable->id;
                $this->updateResponsable($request, $idresp);
            }
            //end responsable
            //insertar tbl responsable_difunto
            if (isset($difuntoid) && isset($idresp)) {

                $rf = new ResponsableDifunto();
                $existeRespDif = $rf->searchResponsableDifunt($request);
              
                if ($existeRespDif != null) {
                    $iddifuntoResp = $this->updateDifuntoResp($request, $difuntoid, $idresp, $codigo_n , $estado_nicho);
                } else {
                    $iddifuntoResp = $this->insDifuntoResp($request, $difuntoid, $idresp, $codigo_n , $estado_nicho);
                }
            }


            //insert pago 
         
          

                                                if($request->reg=="reg"){
                                                    $fur=$request->nrofur;
                                                    $estado_pago=true;
                                                    $fecha_pago=$request->fecha_pago;
                                                }
                                                elseif($request->gratis=="gratis"){
                                                    $fur=0;
                                                    $estado_pago=true;
                                                    $fecha_pago= date("Y-m-d h:i:s");  

                                                }
                                                else{
                                                    $estado_pago=false;  
                                                    $fecha_pago=null   ;
                                                    /** generar fur */
                                                   
                                                                    $nombre_difunto=$request->nombres_dif." ".$request->paterno_dif." ".$request->materno_dif;

                                                                   
                                                                    $obj= new ServicioNicho;
                                                                    $cant_serv=count($request->servicio_hijos);
                                                                    for($cont=0; $cont<$cant_serv; $cont++){
                                                                        $cantidades[$cont]=1;
                                                                    }

                                                                    $response=$obj->GenerarFur($ci, $nombre_pago, $paterno_pago,
                                                                    $materno_pago, $domicilio,  $nombre_difunto, $codigo_nicho,
                                                                    $request->bloque, $request->nro_nicho, $request->fila, $request->servicio_hijos, $cantidades, $cajero );
                                                              
                                                                    if($response['status']==true){
                                                                        $fur = $response['response'];
                                                                        //dd($fur);
                                                                    }  
                                                        }

                                                $serv = new ServicioNicho; 
                                                $serv->codigo_nicho=$codigo_nicho ?? '';
                                                $serv->fecha_registro = date("Y-m-d");
                                                $serv->tipo_servicio_id=implode(', ',  $request->tipo_servicio);
                                                $serv->tipo_servicio=$request->tipo_servicio_txt;
                                                $serv->servicio_id=implode(', ', $request->servicio_hijos);
                                                $serv->servicio= $request->servicio_hijos_txt;
                                                $serv->responsable_difunto_id=$iddifuntoResp;
                                                $serv->id_usuario_caja = auth()->id();
                                                // $serv->id_usuario = auth()->id();
                                                $serv->fur=$fur;
                                                $serv->nro_renovacion= $request->renov ?? '0';
                                                $serv->monto_renovacion= $request->monto_renov ?? '0';
                                              
                                                $serv->monto=$request->txttotal;
                                                $serv->nombrepago=$nombre_pago;
                                                $serv->paternopago=$paterno_pago;
                                                $serv->maternopago=$materno_pago;
                                                $serv->ci=$ci;
                                                $serv->pago_por=$pago_por;
                                                $serv->estado_pago=$estado_pago;
                                                $serv->fecha_pago=$fecha_pago;

                                             
                                                $serv->estado='ACTIVO';
                                                $serv->observacion=$request->observacion;
                                                $serv->det_exhum=$observacion?? '';                                               
                                                $serv->save();
                                                // return  $serv->id;
                                                // return $fur;
                                                if(isset($responsable_id) ){
                                                    $difres= ResponsableDifunto::where('responsable_id', $responsable_id)
                                                    ->where('difunto_id', $difunto_id)
                                                   ->first();   
                                                     $difres->estado_nicho = $est_nicho ?? '';
                                                     $difres->save();
                                                }
                                            //  return  $serv->id;

                             }
            
           
            return response([
                    'status'=> true,
                    'response'=> $serv->id
                ],201);

            }else{

                return response([
                    'status'=> false,
                    'message'=> 'Error 401 (Unauthorized)'
                ],401);
            }
    }

    public function insDifuntoResp($request, $difuntoid, $idresp, $codigo_n, $estado_nicho){

        $dif = new ResponsableDifunto ;
        $dif->responsable_id = $idresp;
        $dif->difunto_id = $difuntoid;
        $dif->codigo_nicho = $codigo_n;       
        $dif->fecha_adjudicacion = $request->fechadef_dif;       
        $dif->tiempo = $request->tiempo;  
        if($estado_nicho=="LIBRE"){ 
            $dif->estado_nicho = $estado_nicho;   
            $dif->fecha_liberacion= date("Y-m-d H:i:s");   
            } 
      
        $dif->estado = 'ACTIVO';  
        $dif->user_id = auth()->id();
        $dif->save();
        $dif->id;
        return  $dif->id;

    }

        public function updateDifuntoResp($request, $difuntoid, $idresp, $codigo_n,  $estado_nicho){
            $dif= ResponsableDifunto::where('responsable_id', $idresp)
                               ->where('difunto_id', $difuntoid)
                               ->where('codigo_nicho', $codigo_n)->first();   
            $dif->responsable_id = $idresp;
            $dif->difunto_id = $difuntoid;
            $dif->codigo_nicho = $codigo_n;       
            $dif->fecha_adjudicacion = $request->fechadef_dif ?? '';       
            $dif->tiempo = $request->tiempo;  
            if($estado_nicho=="LIBRE"){ 
                $dif->estado_nicho = $estado_nicho;   
                $dif->fecha_liberacion= date("Y-m-d H:i:s");   
                } 
            $dif->estado = 'ACTIVO';  
            $dif->user_id = auth()->id();
            $dif->save();
            $dif->id;
            return  $dif->id;
        }


    public function insertDifunto($request){

        $dif = new Difunto;
        $dif->ci = $request->ci_dif;
        $dif->nombres = trim(mb_strtoupper($request->nombres_dif, 'UTF-8'));
        $dif->primer_apellido = trim(mb_strtoupper($request->paterno_dif, 'UTF-8'));
        $dif->segundo_apellido =trim(mb_strtoupper( $request->materno_dif, 'UTF-8'));
        $dif->fecha_nacimiento = $request->fechanac_dif;
        $dif->fecha_defuncion = $request->fechadef_dif;
        $dif->certificado_defuncion = $request->sereci;
        $dif->causa = trim(mb_strtoupper($request->causa, 'UTF-8'));
        $dif->tipo = $request->tipo_dif; 
        $dif->genero = $request->genero_dif;  
        $dif->certificado_file = $request->urlcertificacion;           
        $dif->funeraria =trim(mb_strtoupper($request->funeraria, 'UTF-8'));  
        $dif->estado = 'ACTIVO';  
        $dif->user_id = auth()->id();
        $dif->save();
        $dif->id;
        return  $dif->id;

    }

    public function updateDifunto($request, $difuntoid){
        $difunto= Difunto::where('id', $difuntoid)->first();
        $difunto->ci = $request->ci_dif;
        $difunto->nombres = trim(mb_strtoupper($request->nombres_dif, 'UTF-8'));
        $difunto->primer_apellido = trim(mb_strtoupper($request->paterno_dif, 'UTF-8'));
        $difunto->segundo_apellido =trim(mb_strtoupper( $request->materno_dif, 'UTF-8'));
        $difunto->fecha_nacimiento = $request->fechanac_dif;
        $difunto->fecha_defuncion = $request->fechadef_dif;
        $difunto->certificado_defuncion = $request->sereci;
        $difunto->causa =  trim(mb_strtoupper($request->causa, 'UTF-8'));
        $difunto->tipo = $request->tipo_dif; 
        $difunto->genero = $request->genero_dif;  
        $difunto->certificado_file = $request->urlcertificacion;           
        $difunto->funeraria = trim(mb_strtoupper($request->funeraria, 'UTF-8'));
        $difunto->estado = 'ACTIVO';  
        $difunto->user_id = auth()->id();
        $difunto->save();
        return $difunto->id;
    }

    public function insertResponsable($request){

        $responsable = new Responsable;
        $responsable->ci = $request->ci_resp;
        $responsable->nombres =  trim(mb_strtoupper($request->nombres_resp, 'UTF-8'));
        $responsable->primer_apellido = trim(mb_strtoupper($request->paterno_resp, 'UTF-8'));
        $responsable->segundo_apellido =  trim(mb_strtoupper($request->materno_resp, 'UTF-8'));
        //$responsable->fecha_nacimiento = $request->fechanac_resp;
        $responsable->genero = $request->genero_resp;  
        $responsable->telefono = $request->telefono;  
        $responsable->celular = $request->celular;  
        //$responsable->estado_civil = $request->ecivil;  
        $responsable->domicilio = $request->domicilio; 
        //$responsable->email = $request->email;  
        $responsable->estado = 'ACTIVO';  
        $responsable->user_id = auth()->id();
        $responsable->save();
        $responsable->id;
        return  $responsable->id;

    }

    public function updateResponsable($request, $difuntoid){
        $responsable= Responsable::where('id', $difuntoid)->first();
        $responsable->ci = $request->ci_resp;
        $responsable->nombres =  trim(mb_strtoupper($request->nombres_resp, 'UTF-8'));
        $responsable->primer_apellido = trim(mb_strtoupper($request->paterno_resp, 'UTF-8'));
        $responsable->segundo_apellido =  trim(mb_strtoupper($request->materno_resp, 'UTF-8'));
        //$responsable->fecha_nacimiento = $request->fechanac_resp ?? '';
        $responsable->genero = $request->genero_resp;  
        $responsable->telefono = $request->telefono;  
        $responsable->celular = $request->celular;  
        //$responsable->estado_civil = $request->ecivil ??'';  
        $responsable->domicilio = $request->domicilio;  
       // $responsable->email = $request->email ??  '';  
        $responsable->estado = 'ACTIVO';  
        $responsable->user_id = auth()->id();
        $responsable->save();
        return $responsable->id;
    }

    public function generatePDF(Request $request) {
        //    return($request->codigo_nicho); die();
                   $codigo_nicho=$request->codigo_nicho;
                  

                      $tab=[];
                        $tablelocal=DB::table('servicio_nicho')
                        ->select('servicio_nicho.*')
                        ->where('id','=',$request->id)
                        ->orderBy('id','DESC')
                        ->first();

                        
                        if(($request->fur=="0" ||$request->fur==0 ) &&  $request->id!=null )
                        {
                            if ($tablelocal) {     
                                $tab['fur']= $tablelocal->fur;
                                $tab['nombre']= $tablelocal->nombrepago." ". $tablelocal->paternopago." ".$tablelocal->maternopago??'';
                                $tab['ci']= $tablelocal->ci;
                                $observacion= $tablelocal->observacion;
                                $tab['cobrosDetalles']= [];

                                            
                                  $id_s=explode(',', $tablelocal->servicio_id );
                                foreach( $id_s as  $key => $value ){
                                                   print_r($id_s[$key]);
                                      
                                            $headers =  ['Content-Type' => 'application/json'];
                                            $client = new Client();
                                        
                                            $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/'.trim($id_s[$key]).'', [
                                            'json' => [
                                                ],
                                                'headers' => $headers,
                                            ]);
                                            $data = json_decode((string) $response->getBody(), true);
                                            
                                       
                                        if($data['status']==true){

                                            $tab['cobrosDetalles'][$key]['cuenta']=$data['response'][0]['cuenta'];
                                            $tab['cobrosDetalles'][$key]['detalle']=$data['response'][0]['descripcion'];
                                            $tab['cobrosDetalles'][$key]['monto']=0;
                                     
                                            }
                                    }
                                    
                          
                                    $table = json_decode(json_encode($tab));
                                 
                                $pdf = PDF::setPaper('A4', 'landscape');
                                $pdf = PDF::loadView('servicios/reportServ', compact('table','codigo_nicho', 'observacion'));
                                return  $pdf-> stream("preliquidacion_servicio.pdf", array("Attachment" => false));    
                            }
                        
                    }  else{
                                    $arrayBusqueda = [];
                                    $arrayBusqueda[] = (string)2;
                                    $arrayBusqueda[] = (string)$request->fur;
                                    $arrayBusquedaString = json_encode($arrayBusqueda);
                                    $response = Http::asForm()->post('http://192.168.104.117/cobrosnotributarios/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
                                        'buscar' => $arrayBusquedaString
                                    ]);

                                 
                                    if ($response->successful()) {
                                        if($response->object()->status == true) {
                                            $table = $response->object()->data->cobrosVarios[0];                
                                            $observacion= $tablelocal->observacion;
                                       
                                            $pdf = PDF::setPaper('A4', 'landscape');
                                            $pdf = PDF::loadView('servicios/reportServ', compact('table','codigo_nicho', 'observacion'));
                                            return  $pdf-> stream("preliquidacion_servicio.pdf", array("Attachment" => false));
                                        }
                                }      
                        }
        }
    

        // $miArray = new stdClass(); 
        // $convertedObj[$k] = $this->ToObject($miArray);         
        // $data['miArray']= $convertedObj;



            public function generateCiDif(){
                $dif=new Difunto;
                $nro_ci=$dif->generateCiDifunto();
                return json_encode($nro_ci);
            }

            public function generateCiResp(){
                $resp=new Responsable;
                $nro_ci_resp=$resp->generateCiResponsable();
                return json_encode($nro_ci_resp);
            }


    

    // public function GenerarFur(
    //     $ci,
    //     $nombre,
    //     $primer_apellido,
    //     $ap_materno,
    //     $direccion,
    //     $telefono,
    //     $nombre_difunto,
    //     $codigo,
    //     $bloque,
    //     $nicho,
    //     $fila,
    //     $servicios_cementery
    // ) {

    //     $headers =  ['Content-Type' => 'application/json'];
    //     $client = new Client();
    //     $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery', [
    //     //$response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementery', [

    //         'json' => [
    //             'ci' => $ci,
    //             'nombre' => $nombre,
    //             'primer_apellido' => $primer_apellido,
    //             'ap_materno' => $ap_materno,
    //             'direccion' => $direccion,
    //             'telefono' => $telefono,
    //             'nombre_difunto' => $nombre_difunto,
    //             'codigo' => $codigo,
    //             'bloque' => $bloque,
    //             'fila' => $fila,
    //             'nicho' => $nicho,
    //             'servicios_cementery' => $servicios_cementery

    //         ],
    //         'headers' => $headers,
    //     ]);
    //     $fur_response = json_decode((string) $response->getBody(), true);

    //     return $fur_response;
    // }

    public function precioRenov(){

    

        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();
       
        $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/642', [
        'json' => [
            ],
            'headers' => $headers,
        ]);
        $data = json_decode((string) $response->getBody(), true);
          
       
       if($data['status']==true){
        $resp= [
            "status"=>true,
            "precio" => $data['response'][0]['monto1'],
            "cuenta"=>$data['response'][0]['cuenta'],
            "descrip"=>$data['response'][0]['descripcion'],

            ];
       
           
        }else{
            $resp =[
                "precio"=>0,
                "status"=>false,
            ];
        }
        return response()->json($resp);

      
    }

   

    public function buscarRenovacion(Request $request)
    {
        $codigo=$request->cuartel.".".$request->bloque.".".$request->nicho.".".$request->fila;
        $sql=DB::table('servicio_nicho')
            ->where('codigo_nicho','=', $codigo )
            ->where('nro_renovacion', '<>', '0')
            ->select('nro_renovacion', 'monto_renovacion')
            ->orderBy('id', 'desc')
            ->first();
            if(!empty( $sql)){
                $resp= [
                    "status"=>true,
                    "data" => $sql,        
                    ];
               
                   
                }else{
                    $resp =[
                        "mensaje"=>"no se encontraron resultados",
                        "status"=>false,
                    ];
                }
                return response()->json($resp);
    }



    public function buscarDifuntoEnNicho( $ci_dif){
        $sql=DB::table('responsable_difunto')->select()
               ->Join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
               ->Join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
               ->Join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
               ->where('difunto.ci','=', ''.$ci_dif.'')
               ->first();
              
               if($sql){ return $sql;}
               else{ return false;}
    }

    // contarDifuntoEnNicho
    public function contarDifuntoEnNicho( $codigo){
        $sql=DB::table('nicho')->select('cantidad_cuerpos')            
               ->where('codigo','=', ''. $codigo.'')
               ->first();
              
               if(!empty($sql) || $sql!=null){ return $cc=$sql->cantidad_cuerpos;}
               else{ return $cc=0;}
    }
}
