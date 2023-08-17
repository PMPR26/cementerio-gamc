<?php

namespace App\Http\Controllers\Servicios;

use App\Models\Cripta;
use App\Models\Cuartel;
use App\Models\Bloque;
use App\Models\Nicho;
use App\Models\Servicios\ServicioNicho;
use App\Models\Difunto;
use App\Models\Responsable;
use App\Models\ResponsableDifunto;
use App\Models\CMDifunto;
use App\Models\CriptaMausoleoResp;
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
        if (auth()->check()) {
            $user = auth()->user();
            $rolUsuario = $user->role;

            }

            if($rolUsuario == "APOYO"){
                return view('restringidos/no_autorizado');
            }else{
                $currentMonth = now()->format('m'); // Get the current month in MM format
                $currentYear = now()->format('Y');  // Get the current year in YYYY format

                $servicio = DB::table('servicio_nicho')
                    ->select(
                        'servicio_nicho.codigo_nicho',
                        'servicio_nicho.tipo_servicio',
                        'servicio_nicho.servicio',
                        'servicio_nicho.fur',
                        'servicio_nicho.tipo',
                        'servicio_nicho.monto',
                        'servicio_nicho.nombrepago as nombre_resp',
                        'servicio_nicho.paternopago as primerap_resp',
                        'servicio_nicho.maternopago as segap_dif',
                        'servicio_nicho.estado_pago',
                        'servicio_nicho.id as serv_id'
                    )
                    ->where('servicio_nicho.estado', 'ACTIVO')
                    ->whereRaw("DATE_PART('month', servicio_nicho.created_at) = ?", [$currentMonth])
                    ->whereRaw("DATE_PART('year', servicio_nicho.created_at) = ?", [$currentYear])
                    ->orderBy('servicio_nicho.id', 'DESC')
                    ->get();

               return view('servicios/index', ['servicio' => $servicio]);
            }

    }

    public function cargarForm()
    {
        // env('URL_MULTISERVICE')
        $headers = [
            'Content-Type' => 'application/json'
        ];
        try {
            $client = new Client();
            // $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/get-services', [
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

        $funeraria=DB::table('difunto')
        ->select('funeraria')
        ->whereNotNull('funeraria')
        ->distinct()->get();

        $responsable=DB::table('responsable')
        ->select('id', DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'))
        ->where( 'estado' ,'ACTIVO')
        ->distinct()->get();
        // dd( $responsable) ;

        $causa=DB::table('difunto')
        ->select('causa')
        ->whereNotNull('causa')
        ->distinct()->get();

        $cuarteles=DB::table('cuartel')
        ->select('id', 'codigo')
        ->where('estado', 'ACTIVO')
        ->distinct()->get();

        return view('servicios/formRegistro', ['tipo_service' => $tipo_service['response'], 'funeraria' => $funeraria, 'causa' => $causa, 'cuarteles'=>$cuarteles, 'list_responsable'=>$responsable]);
    }


    public function buscar_nicho(Request $request)
    {
        // dd( $request);

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
               servicio_nicho.fecha_registro as fecha_pago,
               servicio_nicho.servicio as servicios,
               responsable_difunto.fecha_adjudicacion as fecha_ingreso_nicho,
               nicho.tipo as tipo_nicho,
               nicho.codigo as nicho,
               nicho.codigo_anterior as anterior,
               bloque.codigo as bloque,
               cuartel.codigo as cuartel,
               cuartel.id as cuartel_id,

               nicho.nro_nicho,
               nicho.estado_nicho as estado_nicho,
               nicho.cantidad_cuerpos
                ') )
            ->leftJoin('servicio_nicho', 'servicio_nicho.codigo_nicho', '=', 'responsable_difunto.codigo_nicho')
            ->leftJoin('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
            ->leftJoin('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
            ->join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
            ->leftJoin('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
            ->leftJoin('bloque', 'bloque.id', '=', 'nicho.bloque_id')
            ->where('responsable_difunto.estado', 'ACTIVO')
            ->where('bloque.codigo', '=',''. $request->bloque.'')
            ->where('nicho.nro_nicho', '=',''. $request->nicho.'')
            ->where('nicho.fila', '=', $request->fila)
            ->orderBy('servicio_nicho.id', 'DESC')
            ->orderBy('nicho.id', 'DESC')
            ->orderBy('responsable_difunto.id', 'DESC')
            ->first();

            // dd($sql);

            if($sql){
                $mensaje=true;
            }
            else{
                $r=$this->buscar_nicho_liberado($request);
                if($r){
                    $mensaje= "liberado";
                    $sql=json_decode($r->getContent());
                }else{
                   $mensaje= false;
                }
            }

            $resp= [
                "mensaje" => $mensaje,
                "response"=>$sql
                ];

             return response()->json($resp);

    }



    //buscar si el nicho ya fue registrado y liberado para evitar sacar datos de la base antigua


    public function buscar_nicho_liberado(Request $request)
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
               difunto.fecha_nacimiento as fecha_nac_dif,
               difunto.fecha_defuncion as fecha_def_dif,
               difunto.causa as causa_dif,
               difunto.tipo as tipo_dif,
               difunto.certificado_defuncion,
               difunto.genero as genero_dif,
               difunto.certificado_file,
               difunto.funeraria,
               nicho.tipo as tipo_nicho,
               nicho.codigo as nicho,
               nicho.estado_nicho as estado_nicho,
               nicho.codigo_anterior as anterior,
               bloque.codigo as bloque,
               cuartel.codigo as cuartel,
               cuartel.id as cuartel_id,

               nicho.nro_nicho,
               nicho.cantidad_cuerpos,
               responsable_difunto.fecha_adjudicacion as fecha_ingreso_nicho

                ') )
            // ->leftjoin('servicio_nicho', 'servicio_nicho.codigo_nicho', '=', 'responsable_difunto.codigo_nicho')
            ->leftJoin('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
            ->leftJoin('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
            ->join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
            ->leftJoin('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
            ->leftJoin('bloque', 'bloque.id', '=', 'nicho.bloque_id')
            ->where('bloque.codigo', '=',''. $request->bloque.'')
            ->where('nicho.nro_nicho', '=',''. $request->nicho.'')
            ->where('nicho.fila', '=', $request->fila)
            ->where('nicho.estado', 'ACTIVO')
            ->orderBy('nicho.id', 'DESC')
            ->orderBy('responsable_difunto.id', 'DESC')
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


    //service update pay from sinot
    public function updatePay(Request $request)
    {
       // dd(trim($request->fur));
        if ($request->isJson()) {
            $this->validate($request, [
                "fur" => 'required',
                 //"id_usuario_caja" => 'required'
            ]);

            $servicio = ServicioNicho::select('id', 'fur')
                ->where(['fur' => trim($request->fur), 'estado_pago' => false, 'estado' => 'ACTIVO'])
                ->first();

            if ($servicio) {
                ServicioNicho::where('fur', trim($request->fur))
                    ->update([
                        'estado_pago' => true,
                        //'id_usuario_caja' => $request->id_usuario_caja,
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
        // dd($request->fecha_ingreso_nicho);
        // $explode_txt=explode("Bs.",$request->servicio_hijos_txt);
      //  $explode_txt=$request->servicio_hijos_txt;
        // dd($explode_txt);

        //  $explode=explode("=>",$request->descripcion_exhumacion);
        //  dd($explode);
        if ($request->isJson())
        {

            if($request->externo == "externo" && $request->gratis == "GRATIS"){
                $this->validate($request, [
                    // 'ci_dif' => 'required',
                    'nombres_dif' => 'required',
                    'paterno_dif'=> 'required',
                    'tipo_dif'=> 'required',
                    // 'genero_dif'=> 'required',
                //   'ci_resp' => 'required',
                    'nombres_resp' => 'required',
                    'paterno_resp'=> 'required',
                    // 'domicilio'=> 'required',
                    // 'genero_resp'=> 'required',
                    'servicios_adquiridos' => 'required',
                ], [
                    // 'ci_dif.required' => 'El campo ci del difunto es obligatorio, si no tiene documento presione el boton "generar carnet provisional  (icono lapiz)" para asignarle un numero provisional',
                    'nombres_dif.required' => 'El campo nombres del difunto es obligatorio',
                    'paterno_dif.required'=> 'El campo primer apellido  del difunto es obligatorio',
                    'tipo_dif.required' => 'El campo tipo de difunto (adulto o parvulo) es obligatorio',
                    // 'genero_dif.required'=> 'El campo genero del difunto es obligatorio',
                    // 'ci_resp.required' => 'El campo ci del responsable es obligatorio, si no tiene documento presione el boton "generar carnet provisional (icono lapiz)" para asignarle un numero provisional',
                    'nombres_resp.required' => 'El campo nombre del responsable es obligatorio',
                    'paterno_resp.required'=> 'El campo apellido paterno del responsable  es obligatorio',
                    // 'domicilio.required'=> 'El campo domicilio es obligatorio',
                    // 'genero_resp.required'=> 'El campo genero del responsable es obligatorio',
                    'servicios_adquiridos.required' => 'Debe seleccionar al menos un tipo de servicio',
                    // 'servicio_hijos.required' => 'Debe seleccionar al menos un servicio',
                ]);
            }
            else{
                    $this->validate($request, [
                        'nro_nicho' => 'required',
                        'bloque' => 'required',
                        'cuartel' => 'required',
                        'fila' => 'required',
                        'tipo_nicho' => 'required',
                        // 'ci_dif' => 'required',
                        'nombres_dif' => 'required',
                        'paterno_dif'=> 'required',
                        'tipo_dif'=> 'required',
                        // 'genero_dif'=> 'required',
                        // 'ci_resp' => 'required',
                        'nombres_resp' => 'required',
                        'paterno_resp'=> 'required',
                        // 'domicilio'=> 'required',
                        // 'genero_resp'=> 'required',
                        'servicios_adquiridos' => 'required',
                        // 'servicio_hijos' => 'required',
                    ], [
                        'nro_nicho.required' => 'El campo nicho es obligatorio',
                        'bloque.required' => 'El campo bloque es obligatorio',
                        'cuartel.required' => 'El campo cuartel es obligatorio',
                        'fila.required' => 'El fila nicho es obligatorio',
                        'tipo_nicho.required' => 'El campo tipo de nicho es obligatorio',
                        // 'ci_dif.required' => 'El campo ci del difunto es obligatorio, si no tiene documento presione el boton "generar carnet provisional  (icono lapiz)" para asignarle un numero provisional',
                        'nombres_dif.required' => 'El campo nombres del difunto es obligatorio',
                        'paterno_dif.required'=> 'El campo primer apellido  del difunto es obligatorio',
                        'tipo_dif.required' => 'El campo tipo de difunto (adulto o parvulo) es obligatorio',
                        // 'genero_dif.required'=> 'El campo genero del difunto es obligatorio',
                        // 'ci_resp.required' => 'El campo ci del responsable es obligatorio, si no tiene documento presione el boton "generar carnet provisional (icono lapiz)" para asignarle un numero provisional',
                        'nombres_resp.required' => 'El campo nombre del responsable es obligatorio',
                        'paterno_resp.required'=> 'El campo apellido paterno del responsable  es obligatorio',
                        // 'domicilio.required'=> 'El campo domicilio es obligatorio',
                        // 'genero_resp.required'=> 'El campo genero del responsable es obligatorio',
                        'servicios_adquiridos.required' => 'Debe seleccionar al menos un tipo servicio',
                        // 'servicio_hijos.required' => 'Debe seleccionar al menos un servicio',
                    ]);
             }

                /***generando el codigo del nicho ** */
                $codigo_n = $request->cuartel . "." . $request->bloque . "." . $request->nro_nicho . "." . $request->fila;
                $cant=0;
                $cant_ant=0;


                $tipo_servicio=[];
                $txt_tipo_servicio=[];
                $servicio_hijos=[];
                $txt_servicios_hijos=[];
                $cantidad=[];
                $tblobs=[];

                $pago_renovaciones="NO";
                $permitir_ingreso_nuevo_cuerpo="NO";

                foreach($request->servicios_adquiridos as $value){
                    array_push($tipo_servicio, $value['tipo_servicio']);
                    array_push($txt_tipo_servicio, $value['txt_tipo_servicio']);
                    array_push( $servicio_hijos, $value['serv']);
                    array_push($txt_servicios_hijos, $value['txt_serv']);
                    array_push($cantidad, $value['cantidad']);
                    array_push($tblobs, $value['tblobs']);

                }
                  // dd($txt_servicios_hijos);

                /**** recuperar datos del cajero para registrar el pago  *****/
                $datos_cajero=User::select()
                ->where('id',auth()->id())
                ->first();
                $cajero= $datos_cajero->user_sinot;

            //******************** recuperar los servicios adquiridos ***** */
            if (!empty($request->servicios_adquiridos) && is_array($request->servicios_adquiridos))
            {
                    $cantidadEnNicho=$this->contarDifuntoEnNicho($codigo_n);
                    $difuntoEnNicho=$this->buscarDifuntoEnNicho($request);
                    $cant=$cantidadEnNicho;
                    // $explode_txt=$request->servicio_hijos_txt;

                    $texto_servicio="";
                    $separador=" ";
                    foreach($request->servicios_adquiridos as $key=>$servi)
                    {

                        // print_r($servi['serv']);
                        if($servi['serv']=='1979' || $servi['serv']=='1977' || $servi['serv']=='1978'  || $servi['serv']=='1981' || $servi['serv']=='1980' || $servi['serv']=='1982' || $servi['serv']=='630' || $servi['serv']=='631')
                        { //inhumaciones
                            // dd("inhum"+$cantidadEnNicho);

                            $cant_ant= $cantidadEnNicho;

                                    $estado_nicho="OCUPADO";
                                    if($servi['serv']=='1979' || $servi['serv']=='1977' || $servi['serv']=='1978'){

                                        if( $cantidadEnNicho !=false){
                                            $cant_ant=$cantidadEnNicho;
                                            return response([
                                                'status'=> false,
                                                'message'=>"temporal_ocupado"
                                            ],200);
                                        }else{
                                            $cant=1;
                                            $cant_ant=0;
                                        }
                                    }else if($servi['serv']=='1981' || $servi['serv']=='1980' || $servi['serv']=='1982'){

                                        if($difuntoEnNicho==false && $request->tipo_nicho== "TEMPORAL")
                                        {
                                                $cantidadEnNicho=$this->contarDifuntoEnNicho($codigo_n);
                                                if( $cantidadEnNicho ==0){
                                                    $cant= $cantidadEnNicho + 1;
                                                }else{
                                                    $cant=1;

                                                }

                                        }
                                        else if($difuntoEnNicho==false && $request->tipo_nicho == "PERPETUO")
                                        {
                                                $cantidadEnNicho=$this->contarDifuntoEnNicho($codigo_n);
                                                if( $cantidadEnNicho <4){
                                                    $cant= $cantidadEnNicho + 1;
                                                    $permitir_ingreso_nuevo_cuerpo="SI";
                                                }else{
                                                    $cant= $cantidadEnNicho;
                                                    $permitir_ingreso_nuevo_cuerpo="NO";
                                                }

                                        }
                                        else{
                                                    if( $cantidadEnNicho !=false){
                                                        $cant= $cantidadEnNicho;
                                                    }else{
                                                        $cant=1;
                                                    }

                                        }
                                    }
                                    $texto_servicio = $texto_servicio. $separador. $servi['txt_serv']." Bs.";
                        }else if($servi['serv'] == '645' || $servi['serv'] =='644' || $servi['serv'] == '629' || $servi['serv'] == '628')
                        {  //exhumaciones
                            // dd($cantidadEnNicho);

                                        $cant_ant= $cantidadEnNicho;
                                        // if($difuntoEnNicho==false)
                                        // {
                                        //     $estado_nicho="EXHUMADO";
                                        //     // $observacion="Exhumado en fecha".date('d/m/Y')." solicitante exhumación (". $pago_por. ") " .$nombre_pago. " ". $paterno_pago ." ".$materno_pago. " ci: ".$ci; // .
                                        //     $det_exhum=$servi['tblobs'];

                                        // }
                                        // else{

                                        //     $responsable_id=$difuntoEnNicho->responsable_id;
                                        //     $difunto_id=$difuntoEnNicho->difunto_id;
                                        //     $estado_nicho="EXHUMADO";
                                        //     // $observacion="Exhumado en fecha".date('d/m/Y')." solicitante exhumación (". $pago_por. ") " .$nombre_pago. " ". $paterno_pago ." ".$materno_pago. " ci: ".$ci; // .
                                        //     $det_exhum=$servi['tblobs'];
                                        // }


                                        if( $cantidadEnNicho == 1 && $request->tipo_nicho== "TEMPORAL" ){
                                            $estado_nicho="LIBRE";
                                            $cant= $cantidadEnNicho -1;
                                        }
                                        else if( $cantidadEnNicho >= 1 ){
                                            $estado_nicho="OCUPADO";
                                            $cant = $cantidadEnNicho -1;
                                        }
                                        else if( $cantidadEnNicho == 0){
                                            $estado_nicho="LIBRE";
                                            $cant= 0;
                                        }
                                        $texto_servicio= $texto_servicio.$separador.$servi['txt_serv']." Bs.";
                         }
                        else{
                            // dd("other"+$cantidadEnNicho);

                               if($servi['serv'] == '642'){
                                    $pago_renovaciones="SI";
                                }

                                $texto_servicio= $texto_servicio.$separador. $servi['txt_serv']." Bs.";
                                 $estado_nicho="OCUPADO";

                            }

                    } //end for each
                    /// datos de nicho para caso de cremacion para externo
                    // if($request->externo=="externo"){
                    //     $codigo_n="00000" ;
                    //     $estado_nicho="EXTERNO";
                    //     $codigo_nicho = $codigo_n;
                    // }
                    // else{

                                $existeNicho = Nicho::where('codigo', $codigo_n)->first();
                                // dd($existeNicho->id);
                                if ($existeNicho != null) {
                                    $id_nicho = $existeNicho->id;
                                    $upnicho= Nicho::where('id',  $id_nicho)->first();
                                    if(isset($estado_nicho)){
                                        $upnicho->estado_nicho=$estado_nicho;
                                    }
                                    if(isset($pago_renovaciones) ){
                                            if($pago_renovaciones=="SI"){
                                                $upnicho->renovacion=$request->nro_renovacion;
                                                $upnicho->monto_renov=$request->monto_renov;
                                              }
                                    }
                                    $upnicho->estado="ACTIVO";
                                    $upnicho->cantidad_cuerpos=$cant;
                                    $upnicho->codigo_anterior=$request->anterior;
                                    $upnicho->save();
                                    $upnicho->id;
                                    $id_nicho=$upnicho->id;

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
                                                $nicho->estado ='ACTIVO';
                                                $nicho->cantidad_cuerpos =$cant;
                                                $nicho->cantidad_anterior =$cant_ant;
                                                $nicho->user_id = auth()->id();
                                                $nicho->save();
                                                $nicho->id;
                                                $id_nicho = $nicho->id;
                                            }
                                             // end nicho
                    // }
                         //step1: nicho buscar si existe registrado el nicho recuperar el id  sino existe registrarlo


                        // step2: register difunto --- si id_difunto id_difunto es null insertar difunto insertar responsable
                        $d=New Difunto;
                        $existeDifunto=$d->searchDifunto($request);

                        // dd($existeDifunto);
                        if ( !$existeDifunto ||  $existeDifunto == null) {
                             $difuntoid = $this->insertDifunto($request);
                        } else {
                            $difuntoid = $existeDifunto->id;
                            $this->updateDifunto($request, $difuntoid);
                        }

                        // dd($difuntoid);

                    // end difunto
                    // step4: register responsable -- si el responsable
                    $r=New Responsable;
                    $existeResponsable=$r->searchResponsable($request);
                        // dd($existeResponsable);

                    if (!$existeResponsable ||  $existeResponsable == null) {
                        //insertar difunto
                        // $idresp = $this->insertResponsable($request);
                        $r=New Responsable;
                        $idresp = $r->insertResponsable($request);


                    } else {
                        $idresp = $existeResponsable->id;
                        $this->updateResponsable($request, $idresp);
                    }


                    if($request->ci_resp==null || !isset($request->ci_resp) || $request->ci_resp==""){
                        $sqresp=Responsable::WhereRaw('id=\''.trim($idresp).'\'')->select('ci')->first();
                        $ci_adjudicatario=$sqresp->ci;
                    }
                    else{
                        $ci_adjudicatario=$request->ci_resp;
                    }

                       /********recuperar datos de la persona que realizo el pago, si es el propietario o un tercer responsable */

                                if ($request->pago_por != "responsable") {
                                    $pago_por = "Tercera persona";
                                    $nombre_pago = trim(strtoupper($request->name_pago));
                                    $paterno_pago = trim(strtoupper($request->paterno_pago));
                                    $materno_pago =  trim(strtoupper($request->materno_pago));
                                    $ci = $request->ci_pago;
                                    $domicilio = "SIN ESPECIFICACION";
                                } else {
                                            $pago_por = "Titular responsable";
                                            $nombre_pago =  trim(strtoupper($request->nombres_resp));
                                            if ($request->paterno_resp == "") {
                                                $paterno_pago = "NO DEFINIDO";
                                            } else {
                                                $paterno_pago =  trim(strtoupper($request->paterno_resp));
                                            }
                                            if ($request->domicilio == "") {
                                                $domicilio = "NO DEFINIDO";
                                            } else {
                                                $domicilio = trim(strtoupper($request->domicilio));
                                            }

                                            $materno_pago =  trim(strtoupper($request->materno_resp)) ?? '';
                                            $ci = $ci_adjudicatario;
                                }


                                  //end responsable

                                    //insertar tbl responsable_difunto
                                    if (isset($difuntoid) && isset($idresp)) {
                                        // dd($estado_nicho);
                                        $rf = new ResponsableDifunto();
                                        $existeRespDif = $rf->searchResponsableDifunt($request, $idresp, $difuntoid );

                                        if ($existeRespDif != null) {
                                            $iddifuntoResp = $rf->updateDifuntoResp($request, $difuntoid, $idresp, $codigo_n , $estado_nicho);
                                        } else {
                                            $iddifuntoResp = $rf->insDifuntoResp($request, $difuntoid, $idresp, $codigo_n , $estado_nicho, $id_nicho);
                                        }
                                    }

                                                //insert pago
                                                if($request->reg=="reg"){
                                                    $fur=$request->nrofur;
                                                    $estado_pago=true;
                                                    $fecha_pago=$request->fecha_pago;
                                                }
                                                elseif($request->gratis=="GRATIS"){
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
                                                                    $cant_serv=count($request->servicios_adquiridos);
                                                                    //  dd($servicio_hijos);
                                                                    for($cont=0; $cont<$cant_serv; $cont++){
                                                                        $cantidades[$cont]=1;
                                                                    }

                                                                    $nombre_adjudicatario= $request->nombre_resp." ".$request->paterno_resp." ".$request->materno_resp;

                                                                    $response=$obj->GenerarFur($ci,$nombre_pago,$paterno_pago,$materno_pago, $domicilio,  $nombre_difunto, $codigo_n,
                                                                    $request->bloque, $request->nro_nicho, $request->fila, $servicio_hijos, $cantidades, $cajero,
                                                                    $nombre_adjudicatario, $ci_adjudicatario , $tblobs);

                                                                    if($response['status']==true){
                                                                        $fur = $response['response'];
                                                                        //dd($fur);
                                                                    }
                                                        }
                                                        if(!empty($tblobs)){
                                                            $descripcion_exhumacion=  implode(', ', $tblobs);

                                                        }
                                                $serv = new ServicioNicho;
                                                $serv->codigo_nicho=$codigo_n ?? '';
                                                $serv->fecha_registro = date("Y-m-d");
                                                $serv->tipo_servicio_id=implode(', ',  $tipo_servicio);
                                                $serv->tipo_servicio=implode(', ',$txt_tipo_servicio);
                                                $serv->servicio_id=implode(', ', $servicio_hijos);
                                                $serv->servicio= implode(', ', $txt_servicios_hijos);
                                                $serv->responsable_difunto_id=$iddifuntoResp;
                                                $serv->id_usuario_caja = auth()->id();
                                                $serv->tipo = "NICHO";
                                                $serv->fur=$fur;
                                                $serv->nro_renovacion= $request->renov ?? '0';
                                                $serv->monto_renovacion= $request->monto_renov ?? '0';
                                                $serv->monto=$request->monto;
                                                $serv->nombrepago=$nombre_pago;
                                                $serv->paternopago=$paterno_pago;
                                                $serv->maternopago=$materno_pago;
                                                $serv->ci=$ci;
                                                $serv->pago_por=$pago_por;
                                                $serv->estado_pago=$estado_pago;
                                                $serv->fecha_pago=$fecha_pago;
                                                $serv->estado='ACTIVO';
                                                $serv->observacion=$descripcion_exhumacion;
                                                $serv->det_exhum=$descripcion_exhumacion?? '';
                                                $serv->ubicacion_id=$id_nicho ?? null;
                                                if($pago_renovaciones=="SI"){
                                                    $serv->monto_renovacion=$request->monto_renov;
                                                    $serv->nro_renovacion=$request->nro_renovacion;
                                                }
                                                $serv->save();


                                                if($request->asignar_difunto_nicho=="asignado")
                                                {
                                                    $n=New Nicho;
                                                    $nuevo_n= $n->generarCodigoAsignacion($request->cuartel_nuevo, $request->bloque_nuevo, $request->nicho_nuevo, $request->fila_nuevo);
                                                    $nuevo_nicho= json_decode($nuevo_n->getContent(), true);
                                                   // dd($nuevo_nicho['nicho']);
                                                    if($nuevo_nicho['status']==true){
                                                        $rf = new ResponsableDifunto ;
                                                       $rf->registrar_asignacion($request ,$difuntoid, $idresp, $nuevo_nicho['nicho']['codigo'], $estado_nicho, $nuevo_nicho['nicho']['id'], $nuevo_nicho['nicho']['tipo']);
                                                        $lib=New Nicho;
                                                        $liberar=$lib->liberarNichoAsignacion($id_nicho, $codigo_n);
                                                    }
                                                    else{
                                                        return response([
                                                            'status'=> false,
                                                            'message'=> $nuevo_nicho['message']
                                                        ],201);
                                                    }

                                                }


                                                return response([
                                                    'status'=> true,
                                                    'response'=> $serv->id,
                                                    'message'=>"El registro se ha realizado con éxito..!!"
                                                ],200);


                             }else{
                                return response([
                                    'status'=> false,
                                    'message'=> "Debe seleccionar al menos un servicio"
                                ],201);
                             }




            }else{

                return response([
                    'status'=> false,
                    'message'=> 'Error 401 (Unauthorized)'
                ],401);
            }
    }




    public function insertDifunto($request){
           /*******verificar si el campo ci del difunto esta vacio y generar uno provisional */
           if(!isset($request->ci_dif) || $request->ci_dif==null || $request->ci_dif==''){
            $dif=new Difunto;
            $ci_dif=$dif->generateCiDifunto();
      }else{
          $ci_dif=$request->ci_dif;
      }

        $dif = new Difunto;
        $dif->ci = $ci_dif;
        $dif->nombres = trim(mb_strtoupper($request->nombres_dif, 'UTF-8'));
        $dif->primer_apellido = trim(mb_strtoupper($request->paterno_dif, 'UTF-8'));
        $dif->segundo_apellido =trim(mb_strtoupper( $request->materno_dif, 'UTF-8'));
        $dif->fecha_nacimiento = $request->fechanac_dif ?? null;
        $dif->fecha_defuncion = $request->fecha_def_dif ?? null;
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
        // $difunto->ci = $request->ci_dif;
        $difunto->nombres = trim(mb_strtoupper($request->nombres_dif, 'UTF-8'));
        $difunto->primer_apellido = trim(mb_strtoupper($request->paterno_dif, 'UTF-8'));
        $difunto->segundo_apellido =trim(mb_strtoupper( $request->materno_dif, 'UTF-8'));
        $difunto->fecha_nacimiento = $request->fechanac_dif ?? null;
        $difunto->fecha_defuncion = $request->fecha_def_dif ?? null;
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

    // public function insertResponsable($request){
    //        /*******verificar si el campo ci del difunto esta vacio y generar uno provisional */
    //        if(!isset($request->ci_resp) || $request->ci_resp==null || $request->ci_resp==''){
    //         $resp=new Difunto;
    //         $ci_resp=$resp->generateCiDifunto();
    //         }else{
    //             $ci_resp=$request->ci_resp;
    //         }

    //     $responsable = new Responsable;
    //     $responsable->ci = $ci_resp;
    //     $responsable->nombres =  trim(mb_strtoupper($request->nombres_resp, 'UTF-8'));
    //     $responsable->primer_apellido = trim(mb_strtoupper($request->paterno_resp, 'UTF-8'));
    //     $responsable->segundo_apellido =  trim(mb_strtoupper($request->materno_resp, 'UTF-8'));
    //     $responsable->fecha_nacimiento = $request->fechanac_resp ?? null;
    //     $responsable->genero = $request->genero_resp;
    //     $responsable->telefono = $request->telefono;
    //     $responsable->celular = $request->celular;
    //     $responsable->estado_civil = $request->ecivil ?? '';
    //     $responsable->domicilio = $request->domicilio??'';
    //     $responsable->email = $request->email ?? '';
    //     $responsable->estado = 'ACTIVO';
    //     $responsable->user_id = auth()->id();
    //     $responsable->save();
    //     $responsable->id;
    //     return  $responsable->id;

    // }

    public function updateResponsable($request, $difuntoid){
        $responsable= Responsable::where('id', $difuntoid)->first();
        $responsable->ci = $request->ci_resp;
        $responsable->nombres =  trim(mb_strtoupper($request->nombres_resp, 'UTF-8'));
        $responsable->primer_apellido = trim(mb_strtoupper($request->paterno_resp, 'UTF-8'));
        $responsable->segundo_apellido =  trim(mb_strtoupper($request->materno_resp, 'UTF-8'));
        $responsable->fecha_nacimiento = $request->fechanac_resp ?? null;
        $responsable->genero = $request->genero_resp;
        $responsable->telefono = $request->telefono;
        $responsable->celular = $request->celular;
        $responsable->estado_civil = $request->ecivil ??'';
        $responsable->domicilio = $request->domicilio??'';
       $responsable->email = $request->email ??  '';
        $responsable->estado = 'ACTIVO';
        $responsable->user_id = auth()->id();
        $responsable->save();
        return $responsable->id;
    }
//imprimir preliquidacion para nichos
    public function generatePDF(Request $request) {
        //    return($request->codigo_nicho); die();
                   $codigo_nicho=$request->codigo_nicho;
                        $tab=[];
                        $tablelocal=DB::table('servicio_nicho')
                        ->select('servicio_nicho.*')
                        ->where('id','=',$request->id)
                        // ->where('tipo','=',$request->tipo)
                        ->orderBy('id','DESC')
                        ->first();

                        $datos_ubicacion=$tablelocal->ubicacion_id??'';
                        $tipo_ubicacion=$tablelocal->tipo??'';
                        $det_exhum=$tablelocal->det_exhum ??'';
                        $responsable_difunto_id=$tablelocal->responsable_difunto_id;
                        $pago_por=$tablelocal->pago_por;

                        if($tipo_ubicacion=="NICHO"){
                            $sq=Nicho::where('nicho.id', '=',$datos_ubicacion )
                            ->join('responsable_difunto', 'responsable_difunto.codigo_nicho', '=', 'nicho.codigo')
                            ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
                            ->select('responsable.nombres as nombre_resp', 'responsable.primer_apellido as paterno_resp', 'responsable.segundo_apellido as materno_resp', 'responsable.ci as ci_resp' )->first();
                            $resp=$sq->nombre_resp. " " . $sq->paterno_resp. " ".$sq->materno_resp ."  C.I.: ".$sq->ci_resp;
                        }
                        else if($tipo_ubicacion== "EXTERNO GRATIS" ||  $tipo_ubicacion== "EXTERNO" ){
                            $sq=ResponsableDifunto::where('responsable_difunto.id', '=',$responsable_difunto_id )
                                                        ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
                                                        ->select('responsable.nombres as nombre_resp', 'responsable.primer_apellido as paterno_resp',
                                                         'responsable.segundo_apellido as materno_resp', 'responsable.ci as ci_resp' )->first();
                                                        $resp=$sq->nombre_resp. " " . $sq->paterno_resp. " ".$sq->materno_resp ."  C.I.: ".$sq->ci_resp;

                        }


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

                                            $headers =  ['Content-Type' => 'application/json'];
                                            $client = new Client();

                                            // $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/'.trim($id_s[$key]).'', [
                                                $response = $client->get('https://multiserv.cochabamba.bo/api/v1/cementerio/generate-servicios-nicho/'.trim($id_s[$key]).'', [
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
                                $pdf = PDF::loadView('servicios/reportServ', compact('table','codigo_nicho', 'observacion', 'det_exhum', 'resp' , 'pago_por','tipo_ubicacion'));
                                return  $pdf-> stream("preliquidacion_servicio.pdf", array("Attachment" => false));
                            }

                    }  else{
                                    $arrayBusqueda = [];
                                    $arrayBusqueda[] = (string)2;
                                    $arrayBusqueda[] = (string)$request->fur;
                                    $arrayBusquedaString = json_encode($arrayBusqueda);
                                    //$response = Http::asForm()->post('http://192.168.104.117/cb-dev/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
                                    // $response = Http::asForm()->post('http://192.168.104.117/cb-dev/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
                                    $response = Http::asForm()->post(env('URL_SEARCH_FUR'), [

                                        'buscar' => $arrayBusquedaString
                                    ]);


                                    if ($response->successful()) {
                                        if($response->object()->status == true) {
                                            $table = $response->object()->data->cobrosVarios[0];
                                            $observacion= $tablelocal->observacion;
                                            $pdf = PDF::setPaper('A4', 'landscape');
                                            $pdf = PDF::loadView('servicios/reportServ', compact('table','codigo_nicho', 'observacion', 'det_exhum', 'resp', 'pago_por','tipo_ubicacion'));
                                            return  $pdf-> stream("preliquidacion_servicio.pdf", array("Attachment" => false));
                                        }
                                }
                        }
        }


       //imprimir preliquidacion para criptas mausoleos

    public function generatePDFCM(Request $request) {
        //    return($request->codigo_nicho); die();
                       $codigo_nicho=$request->codigo_nicho;
                        $tab=[];
                        $tablelocal=DB::table('servicio_nicho')
                        ->select('servicio_nicho.*')
                        ->where('id','=',$request->id)
                        // ->where('tipo','=',$request->tipo)
                        ->orderBy('id','DESC')
                        ->first();
// dd($tablelocal->tipo);
                        $datos_ubicacion=$tablelocal->ubicacion_id??'';
                        $tipo_ubicacion=$tablelocal->tipo??'';
                        $det_exhum=$tablelocal->det_exhum ??'';
                        $responsable_difunto_id=$tablelocal->responsable_difunto_id;


                        if($tipo_ubicacion=="CRIPTA" || $tipo_ubicacion== "MAUSOLEO" ){
                            $sq=CriptaMausoleoResp::where('cripta_mausoleo_responsable.cripta_mausole_id', '=',$datos_ubicacion )
                            ->join('responsable', 'responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id')
                            ->select('responsable.nombres as nombre_resp', 'responsable.primer_apellido as paterno_resp', 'responsable.segundo_apellido as materno_resp', 'responsable.ci as ci_resp' )->first();
                            $resp=$sq->nombre_resp. " " . $sq->paterno_resp. " ".$sq->materno_resp."  C.I.: ".$sq->ci_resp;

                            $dat= Cripta::where('cripta_mausoleo.id', '=',$datos_ubicacion )
                            ->select()->first();
                            $datoSitio= json_decode($dat, true);
                        }


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

                                            $headers =  ['Content-Type' => 'application/json'];
                                            $client = new Client();

                                            // $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/'.trim($id_s[$key]).'', [
                                                $response = $client->get('https://multiserv.cochabamba.bo/api/v1/cementerio/generate-servicios-nicho/'.trim($id_s[$key]).'', [
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
                                $pdf = PDF::loadView('servicios/reportServCM', compact('table','codigo_nicho', 'observacion', 'det_exhum', 'resp', 'datoSitio' ));
                                return  $pdf-> stream("preliquidacion_servicio.pdf", array("Attachment" => false));
                            }

                    }  else{
                                    $arrayBusqueda = [];
                                    $arrayBusqueda[] = (string)2;
                                    $arrayBusqueda[] = (string)$request->fur;
                                    $arrayBusquedaString = json_encode($arrayBusqueda);
                                    //$response = Http::asForm()->post('http://192.168.104.117/cb-dev/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
                                    // $response = Http::asForm()->post('http://192.168.104.117/cb-dev/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
                                    $response = Http::asForm()->post(env('URL_SEARCH_FUR'), [

                                        'buscar' => $arrayBusquedaString
                                    ]);


                                    if ($response->successful()) {
                                        if($response->object()->status == true) {
                                            $table = $response->object()->data->cobrosVarios[0];
                                            $observacion= $tablelocal->observacion;

                                            $pdf = PDF::setPaper('A4', 'landscape');
                                            $pdf = PDF::loadView('servicios/reportServCM', compact('table','codigo_nicho', 'observacion', 'det_exhum', 'resp', 'datoSitio'));
                                            return  $pdf-> stream("preliquidacion_servicio.pdf", array("Attachment" => false));
                                        }
                                }
                        }
        }


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




    public function precioRenov(){



        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();

        // $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/642', [
        $response = $client->get('https://multiserv.cochabamba.bo/api/v1/cementerio/generate-servicios-nicho/642', [

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



    public function buscarDifuntoEnNicho( $request){
        $sql=DB::table('responsable_difunto')->select()
               ->Join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
               ->Join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
               ->Join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
               ->where('difunto.nombres','=', ''.$request->nombres_dif.'')
               ->where('difunto.primer_apellido','=', ''.$request->paterno_dif.'')
               ->where('difunto.segundo_apellido','=', ''.$request->materno_dif.'')
            //    ->where('difunto.fecha_nacimiento','=', ''.$request->fechanac_dif.'')
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

    public function autocompletar(Request $request){
        $cod=$request->bloque.".".$request->nicho.".".$request->fila;
        $rd= New ResponsableDifunto;
        $datos = $rd->info($cod,$request->bloque ,$request->nicho, $request->fila);
        return $datos;

    }



    //insertar servicio cripta mausoleo



    public function generarCodigo(Request $request){
//  dd($request->cuartel);

            if($request->tipo_reg=="CRIPTA"){$letra="C";}else{
                $letra="M";
            }
        $cuartel=DB::table('cuartel')->where('id', $request->cuartel)
        ->select('codigo')
        ->first();
    //    dd( $cuartel);
        if(!isset($request->bloque ) || $request->bloque==null || $request->bloque=='SELECCIONAR' ){ $bloq="000";}

        else{
            $b=DB::table('bloque')->where('cuartel_id', $request->cuartel)
            ->where('id', $request->bloque)
            ->select('codigo')
            ->first();
            $bloq=$b->codigo;
        }
        $cod=strtoupper($cuartel->codigo).$bloq.$request->sitio.$letra.$request->superficie;
       return $cod;
    }

     // contarDifuntoEnNicho
     public function buscarDifuntoEnCM($ci){
        // $idCM=DB::table('cripta_mausoleo')->where('codigo', $codigo)->select('id')->first();
        $sql=DB::table('difunto')
               ->where('ci','=',  $ci)
               ->first();

               if(!empty($sql) || $sql!=null){ return $resp=$sql;}
               else{ return $resp=null;}
    }

    public function insertDifuntoCM( $responsable_id, $cripta_mausoleo_id){
        $dif = new CMDifunto;
        $dif->responsable_id = $responsable_id;

        $dif->estado = 'ACTIVO';
        $dif->user_id = auth()->id();
        $dif->save();
        $dif->id;
        return  $dif->id;
    }

    public function insertResponsableCM( $responsable_id, $cripta_mausoleo_id,$ultima_gestion_pagada){
        $cmr = new CriptaMausoleoResp;
        $cmr->responsable_id = $responsable_id;
        $cmr->ultima_gestion_pagada=$ultima_gestion_pagada;
        $cmr->estado = 'ACTIVO';
        $cmr->user_id = auth()->id();
        $cmr->save();
        $cmr->id;
        return  $cmr->id;
    }


    public function getNroRenov(Request $request){
        if ($request->isJson())
        {      $this->validate($request, [
                    'cuartel' => 'required',
                    'bloque' => 'required',
                    'nro_nicho' => 'required',
                    'fila' => 'required',
                ], [
                    'cuartel.required' => 'El campo cuartel debe ser completado',
                    'bloque.required' => 'El campo bloque debe ser completado',
                    'nro_nicho.requerido' => 'El campo nro de nicho debe ser completado',
                    'fila.required' => 'el campo fila es requerido ',
                ]);

                $sql=DB::table('nicho')
               ->where('nro_nicho','=',  $request->nro_nicho)
               ->where('fila','=',  $request->fila)
               ->where('bloque.codigo','=',  $request->bloque)
               ->where('cuartel.codigo','=',  $request->cuartel)
               ->leftJoin('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
               ->leftJoin('bloque', 'bloque.id', '=', 'nicho.bloque_id')
               ->first();

                    if(!empty($sql) || $sql!=null){ return response([
                        'status'=> true,
                        'sql'=> $sql
                    ],200);}
                    else{ return response([
                        'status'=> false,
                        'message'=> 'No se encontraron resultados'
                    ],201);}
            }
            else{
                return response([
                    'status'=> false,
                    'message'=> 'Error 401 (Unauthorized)'
                 ],401);
            }

    }


    public function getServHijos(Request $request){
        $headers =  ['Content-Type' => 'application/json'];
                $client = new Client();
                // $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-all-servicios-cm', [
                    $response = $client->post('https://multiserv.cochabamba.bo/api/v1/cementerio/generate-all-servicios-cm', [
               'json' => [
                        'data' => $request->data
                    ],
                    'headers' => $headers,
                ]);
                $sevicio = json_decode((string) $response->getBody(), true);
                return $sevicio;

    }

    public function completarInfoNicho(Request $request){
        $nicho= New Nicho;
        $info=$nicho->InfoNicho($request->nicho, $request->fila, $request->bloque);
        if($info){
            return response([
                'status'=> true,
                'info'=>  $info
             ],200);
        }
        else{
            return response([
                'status'=> false,
                'mensaje'=>  "No se enecontro información del nicho"
             ],201);
        }

    }


    /**************************************************************************************************** */
    /***********************************createNewServiciosExterno -servicio-externo*********************** */
    /***************************************************************************************************** */

    public function createNewServiciosExterno(Request $request)
    {

        if ($request->isJson())
        {
                $this->validate($request, [
                    // 'ci_dif' => 'required',
                    'nombres_dif' => 'required',
                    'paterno_dif'=> 'required',
                    'tipo_dif'=> 'required',
                    // 'genero_dif'=> 'required',
                //   'ci_resp' => 'required',
                    'nombres_resp' => 'required',
                    'paterno_resp'=> 'required',
                    // 'domicilio'=> 'required',
                    // 'genero_resp'=> 'required',
                    'servicios_adquiridos' => 'required',
                ], [
                    // 'ci_dif.required' => 'El campo ci del difunto es obligatorio, si no tiene documento presione el boton "generar carnet provisional  (icono lapiz)" para asignarle un numero provisional',
                    'nombres_dif.required' => 'El campo nombres del difunto es obligatorio',
                    'paterno_dif.required'=> 'El campo primer apellido  del difunto es obligatorio',
                    'tipo_dif.required' => 'El campo tipo de difunto (adulto o parvulo) es obligatorio',
                    // 'genero_dif.required'=> 'El campo genero del difunto es obligatorio',
                    // 'ci_resp.required' => 'El campo ci del responsable es obligatorio, si no tiene documento presione el boton "generar carnet provisional (icono lapiz)" para asignarle un numero provisional',
                    'nombres_resp.required' => 'El campo nombre del responsable es obligatorio',
                    'paterno_resp.required'=> 'El campo apellido paterno del responsable  es obligatorio',
                    // 'domicilio.required'=> 'El campo domicilio es obligatorio',
                    // 'genero_resp.required'=> 'El campo genero del responsable es obligatorio',
                    'servicios_adquiridos.required' => 'Debe seleccionar al menos un tipo de servicio',
                    // 'servicio_hijos.required' => 'Debe seleccionar al menos un servicio',
                ]);


                $tipo_servicio=[];
                $txt_tipo_servicio=[];
                $servicio_hijos=[];
                $txt_servicios_hijos=[];
                $tblobs=[];
                $cantidad=[];


                foreach($request->servicios_adquiridos as $value){
                    array_push($tipo_servicio, $value['tipo_servicio']);
                    array_push($txt_tipo_servicio, $value['txt_tipo_servicio']);
                    array_push( $servicio_hijos, $value['serv']);
                    array_push($txt_servicios_hijos, $value['txt_serv']);
                    array_push($cantidad, $value['cantidad']);
                    array_push($tblobs, $value['tblobs']);
                }

                /**** recuperar datos del cajero para registrar el pago  *****/
                $datos_cajero=User::select()
                ->where('id',auth()->id())
                ->first();
                $cajero= $datos_cajero->user_sinot;
                $codigo_n="0";
                $id_nicho="0";
                $bloque=0;
                $nro_nicho=0;
                $fila=0;
                $tipo="EXTERNO";

            //******************** recuperar los servicios adquiridos ***** */
            if (!empty($request->servicios_adquiridos) && is_array($request->servicios_adquiridos))
            {

                    /// datos de nicho para caso de cremacion para externo
                        $observacion=$request->observacion;
                        // step2: register difunto --- si id_difunto id_difunto es null insertar difunto insertar responsable
                        $existeDifunto =DB::table('difunto')->whereRaw('nombres=\''.trim(mb_strtoupper($request->nombres_dif, 'UTF-8')).'\'')
                        ->whereRaw('primer_apellido=\''.trim(mb_strtoupper($request->paterno_dif, 'UTF-8')).'\'')
                        ->whereRaw('segundo_apellido=\''.trim(mb_strtoupper($request->materno_dif, 'UTF-8')).'\'')
                        // ->whereRaw('fecha_nacimiento=\''.trim($request->fechanac_dif).'\'')
                        ->whereRaw('fecha_defuncion=\''.trim($request->fecha_def_dif).'\'')
                        ->select()
                        ->first();

                        if ( !$existeDifunto ||  $existeDifunto == null) {
                             $difuntoid = $this->insertDifunto($request);
                        } else {
                            $difuntoid = $existeDifunto->id;
                            $this->updateDifunto($request, $difuntoid);
                        }
                        // end difunto
                        // step4: register responsable -- si el responsable
                        $existeResponsable = Responsable::whereRaw('nombres=\''. trim($request->nombres_resp).'\'')
                        ->whereRaw('primer_apellido=\''.trim($request->paterno_resp).'\'')
                        ->whereRaw('segundo_apellido=\''.trim($request->materno_resp).'\'')
                        ->OrWhereRaw('ci=\''.trim($request->ci_resp).'\'')
                        ->first();

                    if (!$existeResponsable ||  $existeResponsable == null) {
                        //insertar difunto
                        $r=New Responsable;
                        $idresp = $r->insertResponsable($request);



                    } else {
                        $idresp = $existeResponsable->id;
                        $this->updateResponsable($request, $idresp);
                    }
                    if($request->ci_resp==null || !isset($request->ci_resp) || $request->ci_resp==""){
                        $sqresp=Responsable::WhereRaw('id=\''.trim($idresp).'\'')->select('ci')->first();
                        $ci_adjudicatario=$sqresp->ci;
                    }
                    else{
                        $ci_adjudicatario=$request->ci_resp;
                    }

                       /********recuperar datos de la persona que realizo el pago, si es el propietario o un tercer responsable */

                    if ($request->pago_por != "responsable") {
                            $pago_por = "Tercera persona";
                            $nombre_pago = trim(strtoupper($request->name_pago));
                            $paterno_pago = trim(strtoupper($request->paterno_pago));
                            $materno_pago =  trim(strtoupper($request->materno_pago));
                            $ci = $request->ci_pago;
                            $domicilio = "SIN ESPECIFICACION";
                    } else {
                        $pago_por = "Titular responsable";
                        $nombre_pago =  trim(strtoupper($request->nombres_resp));
                        if ($request->paterno_resp == "") {
                            $paterno_pago = "NO DEFINIDO";
                        } else {
                            $paterno_pago =  trim(strtoupper($request->paterno_resp));
                        }
                        if ($request->domicilio == "") {
                            $domicilio = "NO DEFINIDO";
                        } else {
                            $domicilio = trim(strtoupper($request->domicilio));
                        }

                        $materno_pago =  trim(strtoupper($request->materno_resp)) ?? '';
                        $ci = $ci_adjudicatario;
                    }


                    //end responsable

                    //insertar tbl responsable_difunto
                    if (isset($difuntoid) && isset($idresp)) {
                        $rf = new ResponsableDifunto();
                        $existeRespDif = $rf->searchResponsableDifunt($request, $idresp, $difuntoid );

                        if ($existeRespDif != null) {
                            $iddifuntoResp = $rf->updateDifuntoResp($request, $difuntoid, $idresp, $codigo_n , $tipo);
                        } else {
                            $iddifuntoResp = $rf->insDifuntoResp($request, $difuntoid, $idresp, $codigo_n , $tipo, $id_nicho);
                        }
                    }
                        //insert pago
                                                if($request->reg=="reg"){
                                                    $fur=$request->nrofur;
                                                    $estado_pago=true;
                                                    $fecha_pago=$request->fecha_pago;
                                                }
                                                elseif($request->gratis=="GRATIS"){
                                                    $fur=0;
                                                    $estado_pago=true;
                                                    $fecha_pago= date("Y-m-d h:i:s");
                                                    $tipo="EXTERNO GRATUITO";
                                                }
                                                else{
                                                        $estado_pago=false;
                                                        $fecha_pago=null;
                                                        /** generar fur */
                                                                    $nombre_difunto=$request->nombres_dif." ".$request->paterno_dif." ".$request->materno_dif;
                                                                    $obj= new ServicioNicho;
                                                                    $cant_serv=count($request->servicios_adquiridos);
                                                                    //  dd($servicio_hijos);
                                                                    for($cont=0; $cont<$cant_serv; $cont++){
                                                                        $cantidades[$cont]=1;
                                                                    }

                                                                    $nombre_adjudicatario= $request->nombre_resp." ".$request->paterno_resp." ".$request->materno_resp;
                                                                    $ci_adjudicatario=$request->ci_resp;


                                                                    $response=$obj->GenerarFur($ci,$nombre_pago,$paterno_pago,$materno_pago, $domicilio,  $nombre_difunto, $codigo_n,
                                                                    $bloque, $nro_nicho, $fila, $servicio_hijos, $cantidades, $cajero,
                                                                    $nombre_adjudicatario, $ci_adjudicatario , $tblobs);


                                                                    if($response['status']==true){
                                                                        $fur = $response['response'];
                                                                    }
                                                        }
                                                        if(!empty($tblobs)){
                                                            $descripcion_exhumacion=  implode(', ', $tblobs);

                                                        }

                                                $serv = new ServicioNicho;
                                                $serv->codigo_nicho=$codigo_n ?? '';
                                                $serv->fecha_registro = date("Y-m-d");
                                                $serv->tipo_servicio_id=implode(', ',  $tipo_servicio);
                                                $serv->tipo_servicio=implode(', ',$txt_tipo_servicio);
                                                $serv->servicio_id=implode(', ', $servicio_hijos);
                                                $serv->servicio= implode(', ', $txt_servicios_hijos);
                                                $serv->responsable_difunto_id=$iddifuntoResp;
                                                $serv->id_usuario_caja = auth()->id();
                                                $serv->tipo = $tipo;
                                                $serv->fur=$fur;
                                                $serv->nro_renovacion= $request->renov ?? '0';
                                                $serv->monto_renovacion= $request->monto_renov ?? '0';
                                                $serv->monto=$request->monto;
                                                $serv->nombrepago=$nombre_pago;
                                                $serv->paternopago=$paterno_pago;
                                                $serv->maternopago=$materno_pago;
                                                $serv->ci=$ci;
                                                $serv->pago_por=$pago_por;
                                                $serv->estado_pago=$estado_pago;
                                                $serv->fecha_pago=$fecha_pago;
                                                $serv->estado='ACTIVO';
                                                $serv->observacion=$descripcion_exhumacion;
                                                $serv->det_exhum=$descripcion_exhumacion?? '';
                                                $serv->ubicacion_id=0;

                                                $serv->save();



                                            return response([
                                                'status'=> true,
                                                'response'=> $serv->id
                                            ],201);
                             }




            }else{

                return response([
                    'status'=> false,
                    'message'=> 'Error 401 (Unauthorized)'
                ],401);
            }
    }

    public function verificarPago(Request $request){
        $service=New ServicioNicho;
        $estado_pago=$service->buscarFur($request);

        if($estado_pago->estado_pago=="AC"){
            $this->updatePay($request);
            $this-> updateFechaPago($request->fur,$estado_pago->fecha_pago);
        }
        return $estado_pago;
    }

    public function updateFechaPago($fur, $fecha){
        ServicioNicho::where('fur', trim($fur))
        ->update([
            'estado_pago' => true,
            //'id_usuario_caja' => $request->id_usuario_caja,
            'fecha_pago' => $fecha
        ]);
    }

    public function anularFur(Request $request){
       // todo: terminar modulo
       //dd($request);
       $sn=New ServicioNicho;
       $serv=$sn->anularServicio($request);
       return $serv;
    }


    public function lista_difuntos(Request $request){


        $nicho= New Nicho;
        $codigo_nicho= $request->cuartel.".".$request->bloque.".".$request->nicho.".".$request->fila;

         $rf = new ResponsableDifunto ;
         $difuntos=  $rf->lista_difuntos_perpetuo($codigo_nicho);

         return $difuntos;
        }
    }


