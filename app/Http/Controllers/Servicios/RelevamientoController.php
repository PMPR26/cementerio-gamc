<?php

namespace App\Http\Controllers\Servicios;

use App\Models\Nicho;
use App\Models\Cuartel;
use App\Models\Bloque;
use App\Models\Servicios\ServicioNicho;
use App\Models\Difunto;
use App\Models\Responsable;
use App\Models\ResponsableDifunto;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use PDF;
use Illuminate\Support\Facades\Http;
use PhpParser\Node\Expr\Empty_;

class RelevamientoController extends Controller
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
                'nicho.*',
                'bloque.codigo as bloque',
                'responsable_difunto.tiempo as tiempo',
                'responsable_difunto.nro_renovacion as nro_renovacion',
                'responsable_difunto.monto_ultima_renov as monto_renov',
                'responsable_difunto.gestion_renov as gestion_renov',

                'cuartel.codigo as cuartel'
            )
            ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
            ->join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
            ->join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
            ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
            ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
            ->orderBy('nicho.id', 'DESC')
            ->get();



        return view('servicios/listrelev', ['servicio' => $servicio]);
    }

    public function cargarFormrel()
    {

        $headers = [
            'Content-Type' => 'application/json'
        ];
        try {
            $client = new Client();
            $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/get-services', [
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

        return view('servicios/relevamiento', ['tipo_service' => $tipo_service['response'], 'funeraria' => $funeraria, 'causa' => $causa]);
    }


    public function buscar_nichorel(Request $request)
    {
// dd($request);
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
               nicho.codigo_anterior as anterior,
               bloque.codigo as bloque,
               cuartel.codigo as cuartel,
               nicho.nro_nicho,
               nicho.cantidad_cuerpos

                ') )
            // ->join('servicio_nicho', 'servicio_nicho.codigo_nicho', '=', 'responsable_difunto.codigo_nicho')
            ->leftJoin('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
            ->leftJoin('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
            ->join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
            ->leftJoin('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
            ->leftJoin('bloque', 'bloque.id', '=', 'nicho.bloque_id')
            ->where('bloque.codigo', '=',''. $request->bloque.'')
            ->where('nicho.nro_nicho', '=',''. $request->nicho.'')
            ->where('nicho.fila', '=', $request->fila)
            ->orderBy('nicho.id', 'DESC')
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
                "id_usuario_caja" => 'required',
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



    public function createNewRelev(Request $request)
    {
        // return ($request->ci_dif);
        if ($request->isJson()) {

            if($request->externo == "externo" && $request->gratis == "gratis"){
                $this->validate($request, [

                    'ci_dif' => 'required',
                    'nombres_dif' => 'required',
                    'paterno_dif'=> 'required',
                    'tipo_dif'=> 'required',
                    'genero_dif'=> 'required',
                    'ci_resp' => 'required',

                ], [
                    'ci_dif.required' => 'El campo ci del difunto es obligatorio, si no tiene documento presione el boton "generar carnet provisional  (icono lapiz)" para asignarle un numero provisional',
                    'nombres_dif.required' => 'El campo nombres del difunto es obligatorio',
                    'paterno_dif.required'=> 'El campo primer apellido  del difunto es obligatorio',
                    'tipo_dif.required' => 'El campo tipo de difunto (adulto o parvulo) es obligatorio',
                    'genero_dif.required'=> 'El campo genero del difunto es obligatorio',
                    'ci_resp.required' => 'El campo ci del responsable es obligatorio, si no tiene documento presione el boton "generar carnet provisional (icono lapiz)" para asignarle un numero provisional',

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

            ]);
        }
           // if (!empty($request->servicio_hijos) && is_array($request->servicio_hijos)) {

                        $estado_nicho="OCUPADO";
                        $cant=1;
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
                if($request->ci_resp!=null || $request->ci_resp!="" || $request->nombres_resp!=null || $request->nombres_resp!=""){
                    // $idresp = $this->insertResponsable($request);
                    $idresp=Responsable::insertResponsable($request);
                }
                else{
                    $idresp = 28;                }


            } else {

                // $this->updateResponsable($request, $idresp);
                $idresp=Responsable::updateResponsable($request,$existeResponsable->id);

            }
            //end responsable
            //insertar tbl responsable_difunto
            //verificar que el difunto no este en otro nicho activo
            // dd($request->ci_dif);
             $existeDifuntoResp=$this->buscarDifuntoResp($request->ci_dif);
            //  print_r("asdasd");
            //  dd($existeDifuntoResp);

            // $existeDifuntoResp = ResponsableDifunto::where('ci', $request->ci_dif)->first();

            if (isset($difuntoid) && isset($idresp)) {
                if( $existeDifuntoResp==true){
                    return response([
                        'status' => false,
                        'message' => 'El difunto se encuentra registrado en otro nicho'
                    ], 201);
                }else{
                    $rf = new ResponsableDifunto();
                    $existeRespDif = $rf->searchResponsableDifunt($request);
                    if ($existeRespDif != null) {
                        $iddifuntoResp = $this->updateDifuntoResp($request, $difuntoid, $idresp, $codigo_n , $estado_nicho);
                    } else {
                        $iddifuntoResp = $this->insDifuntoResp($request, $difuntoid, $idresp, $codigo_n , $estado_nicho);
                    }
                }

            }



    }

    public function insDifuntoResp($request, $difuntoid, $idresp, $codigo_n, $estado_nicho){

        $dif = new ResponsableDifunto ;
        $dif->responsable_id = $idresp;
        $dif->difunto_id = $difuntoid;
        $dif->codigo_nicho = $codigo_n;
        $dif->fecha_adjudicacion = $request->fechadef_dif ?? null;
        $dif->tiempo = $request->tiempo;

            $dif->estado_nicho = 'OCUPADO';

        $dif->estado = 'ACTIVO';
        $dif->nro_renovacion = $request->nro_renovacion ?? null;
        $dif->monto_ultima_renov = $request->monto_ultima_renov ?? null;
        $dif->gestion_renov = $request->gestion_renov  ?? null   ;

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
            $dif->fecha_adjudicacion = $request->fechadef_dif ?? null;
            $dif->tiempo = $request->tiempo;
            if($estado_nicho=="LIBRE"){
                $dif->estado_nicho = $estado_nicho;
                $dif->fecha_liberacion= date("Y-m-d H:i:s");
                }
            $dif->estado = 'ACTIVO';
            $dif->user_id = auth()->id();
            $dif->nro_renovacion = $request->nro_renovacion ?? null;
            $dif->monto_ultima_renov = $request->monto_ultima_renov ?? null;
            $dif->gestion_renov = $request->gestion_renov  ?? null   ;
            $dif->save();
            $dif->id;
            return  $dif->id;
        }


    public function insertDifunto($request){

        $dif = new Difunto;
        $dif->ci = $request->ci_dif;
        $dif->nombres = $request->nombres_dif;
        $dif->primer_apellido = $request->paterno_dif;
        $dif->segundo_apellido = $request->materno_dif;
        $dif->fecha_nacimiento = $request->fechanac_dif ?? null;
        $dif->fecha_defuncion = $request->fecha_def_dif ?? null;
        $dif->certificado_defuncion = $request->sereci;
        $dif->causa = $request->causa;
        $dif->tipo = $request->tipo_dif;
        $dif->genero = $request->genero_dif;
        $dif->certificado_file = $request->urlcertificacion;
        $dif->funeraria = $request->funeraria;
        $dif->estado = 'ACTIVO';
        $dif->user_id = auth()->id();
        $dif->save();
        $dif->id;
        return  $dif->id;

    }

    public function updateDifunto($request, $difuntoid){
        $difunto= Difunto::where('id', $difuntoid)->first();
        $difunto->ci = $request->ci_dif;
        $difunto->nombres = $request->nombres_dif;
        $difunto->primer_apellido = $request->paterno_dif;
        $difunto->segundo_apellido = $request->materno_dif;
        $difunto->fecha_nacimiento = $request->fechanac_dif ?? null;
        $difunto->fecha_defuncion = $request->fecha_def_dif ?? null;
        $difunto->certificado_defuncion = $request->sereci;
        $difunto->causa = $request->causa;
        $difunto->tipo = $request->tipo_dif;
        $difunto->genero = $request->genero_dif;
        $difunto->certificado_file = $request->urlcertificacion;
        $difunto->funeraria = $request->funeraria;
        $difunto->estado = 'ACTIVO';
        $difunto->user_id = auth()->id();
        $difunto->save();
        return $difunto->id;
    }

    // public function insertResponsable($request){

    //     $responsable = new Responsable;
    //     $responsable->ci = $request->ci_resp;
    //     $responsable->nombres = $request->nombres_resp;
    //     $responsable->primer_apellido = $request->paterno_resp;
    //     $responsable->segundo_apellido = $request->materno_resp;
    //     //$responsable->fecha_nacimiento = $request->fechanac_resp;
    //     $responsable->genero = $request->genero_resp;
    //     $responsable->telefono = $request->telefono;
    //     $responsable->celular = $request->celular;
    //     //$responsable->estado_civil = $request->ecivil;
    //     $responsable->domicilio = $request->domicilio;
    //     //$responsable->email = $request->email;
    //     $responsable->estado = 'ACTIVO';
    //     $responsable->user_id = auth()->id();
    //     $responsable->save();
    //     $responsable->id;
    //     return  $responsable->id;

    // }

    public function insertResponsableGenerico($request){

        $responsable = new Responsable;
        $responsable->ci = $request->ci_resp;
        $responsable->nombres = $request->nombres_resp;
        $responsable->primer_apellido = $request->paterno_resp;
        $responsable->segundo_apellido = $request->materno_resp;
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

    // public function updateResponsable($request, $idresp){
    //     $responsable= Responsable::where('id', $idresp)->first();
    //     $responsable->ci = $request->ci_resp;
    //     $responsable->nombres = $request->nombres_resp;
    //     $responsable->primer_apellido = $request->paterno_resp;
    //     $responsable->segundo_apellido = $request->materno_resp;
    //     //$responsable->fecha_nacimiento = $request->fechanac_resp ?? '';
    //     $responsable->genero = $request->genero_resp;
    //     $responsable->telefono = $request->telefono;
    //     $responsable->celular = $request->celular;
    //     //$responsable->estado_civil = $request->ecivil ??'';
    //     $responsable->domicilio = $request->domicilio;
    //    // $responsable->email = $request->email ??  '';
    //     $responsable->estado = 'ACTIVO';
    //     $responsable->user_id = auth()->id();
    //     $responsable->save();
    //     return $responsable->id;
    // }

    public function generatePDF(Request $request) {
        //    return($request->codigo_nicho); die();
                   $codigo_nicho=$request->codigo_nicho;
                    if(($request->fur=="0" ||$request->fur==0 ) &&  $request->id!=null )
                    {

                      $tab=[];
                        $tablelocal=DB::table('servicio_nicho')
                        ->select('servicio_nicho.*')
                        ->where('id','=',$request->id)
                        ->orderBy('id','DESC')
                        ->first();

                            if ($tablelocal) {
                                $tab['fur']= $tablelocal->fur;
                                $tab['nombre']= $tablelocal->nombrepago." ". $tablelocal->paternopago." ".$tablelocal->maternopago??'';
                                $tab['ci']= $tablelocal->ci;
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
                                //     echo "<pre>";
                                // print_r($table);
                                // echo "</pre>";
                                // die();
                                $pdf = PDF::setPaper('A4', 'landscape');
                                $pdf = PDF::loadView('servicios/reportServ', compact('table','codigo_nicho'));
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

                                            $pdf = PDF::setPaper('A4', 'landscape');
                                            $pdf = PDF::loadView('servicios/reportServ', compact('table','codigo_nicho'));
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




    public function GenerarFur(
        $ci,
        $nombre,
        $primer_apellido,
        $ap_materno,
        $direccion,
        $telefono,
        $nombre_difunto,
        $codigo,
        $bloque,
        $nicho,
        $fila,
        $servicios_cementery
    ) {

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
        $sql=DB::table('responsable_difunto')
               ->Join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
               ->Join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
               ->Join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
               ->where('difunto.ci','=', ''.$ci_dif.'')
               ->first();

               if($sql){ return true;}
               else{ return false;}
    }

    public function buscarDifuntoResp($ci_dif){

        $sql=DB::table('responsable_difunto')
        ->Join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
        ->Join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
        ->where('difunto.ci','=', ''.$ci_dif.'')
        // ->where('responsable_difunto.difunto_id','=', ''.$ci_dif.'')

        ->first();

        if($sql){ return true;}
        else{ return false;}
    }

}
