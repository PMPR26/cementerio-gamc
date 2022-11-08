<?php

namespace App\Http\Controllers\Mantenimiento;

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
class MantenimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('api', ['except' => ['updatePayMant']]);
    }

    public function index(){
        $mant= Mantenimiento::select('mantenimiento.*',  DB::raw('CONCAT(mantenimiento.nombrepago , \' \',mantenimiento.paternopago, \' \', mantenimiento.maternopago ) AS nombre'))
                ->leftJoin('responsable', 'responsable.id', '=', 'mantenimiento.respdifunto_id')
                ->where('mantenimiento.estado', 'ACTIVO')
                ->orderBy('id', 'DESC')
                 ->get();

        return view('mantenimiento/index', compact('mant'));
    }

    public function createPay(){



        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();

        $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/525', [
        'json' => [
            ],
            'headers' => $headers,
        ]);
        $data = json_decode((string) $response->getBody(), true);


       if($data['status']==true){
            $precio = $data['response'][0]['monto1'];
            $cuenta = $data['response'][0]['cuenta'];
            $descrip = $data['response'][0]['descripcion'];
        }else{
            $precio =0;
        }

        $causa=DB::table('difunto')
        ->select('causa')
        ->whereNotNull('causa')
        ->distinct()->get();

        return view('mantenimiento/nuevoPago', ['precio' =>$precio, 'cuenta' =>$cuenta, 'descrip' =>$descrip, 'causa' => $causa]);
    }


     public function consultaMant(){

     }

    public function savePay(Request $request){

      //  dd($request);
        if($request->isJson())
        {
            $this->validate($request, [
                'nro_nicho'=> 'required',
                'bloque'=> 'required',
                'cuartel'=> 'required',
                'fila'=> 'required',
                'tipo_nicho'=> 'required',
                'ci_dif'=> 'required',
                'nombres_dif'=> 'required',
               // 'paterno_dif'=> 'required',
               // 'tipo_dif'=> 'required',
               // 'genero_dif'=> 'required',
                'ci_resp'=> 'required',
                'nombres_resp'=> 'required',
                'paterno_resp'=> 'required',
               // 'celular'=> 'required',
               // 'ecivil'=> 'required',
               // 'email'=> 'required',
               // 'domicilio'=> 'required',
             //   'genero_resp'=> 'required',
                'sel'=>'required',


            ], [
                'nro_nicho.required'=> 'El campo nicho es obligatorio',
                'bloque.required'=> 'El campo bloque es obligatorio',
                'cuartel.required'=> 'El campo cuartel es obligatorio',
                'fila.required'=> 'El fila nicho es obligatorio',
                'tipo_nicho.required'=> 'El campo tipo de nicho es obligatorio',
                'ci_dif.required'=> 'El campo ci del difunto es obligatorio, si no tiene documento presione el boton "generar carnet provisional  (icono lapiz)" para asignarle un numero provisional',

                'nombres_dif.required'=> 'El campo nombres del difunto es obligatorio',
               // 'paterno_dif.required'=> 'El campo apellido paterno es obligatorio',
                'tipo_dif.required'=> 'El campo tipo de difunto (adulto o parvulo) es obligatorio',
               // 'genero_dif.required'=> 'El campo genero del difunto es obligatorio',
               'ci_resp.required'=> 'El campo ci del responsable es obligatorio, si no tiene documento presione el boton "generar carnet provisional (icono lapiz)" para asignarle un numero provisional',
                 'nombres_resp.required'=> 'El campo nombre del responsable es obligatorio',
                 'paterno_resp.required'=> 'El campo apellido paterno del responsable  es obligatorio',
              //  'celular.required'=> 'El campo celular es obligatorio',
              //  'ecivil.required'=> 'El campo estado civil  es obligatorio',
              //  'email.required'=> 'El campo email es obligatorio',
               // 'domicilio.required'=> 'El campo domicilio es obligatorio',
              //  'genero_resp.required'=> 'El campo genero_resp es obligatorio',
                'sel.required'=>'Debe seleccionar al menos una gestion a pagar',


            ]);

            print_r(auth()->id());
           $datos_cajero=User::select()
           ->where('id',auth()->id())
           ->first();
           $cajero= $datos_cajero->user_sinot;

            //step1: nicho buscar si existe registrado el nicho recuperar el id  sino existe registrarlo
            $codigo_n=$request->cuartel.".".$request->bloque.".".$request->nro_nicho.".".$request->fila;
            $existeNicho= Nicho::where('codigo', $codigo_n)->first();

            if($existeNicho!=null){
                $id_nicho=$existeNicho->id;

            }
            else
             {      // buscar cuartel si existe recuperar id sino insertar
                    $existeCuartel= Cuartel::where('codigo', $request->cuartel)->first();
                        if($existeCuartel!=null){
                            $id_cuartel=$existeCuartel->id;
                        }else{
                            $cuart = new Cuartel;
                            $cuart->codigo = trim($request->cuartel);
                            $cuart->nombre = trim($request->cuartel);
                            $cuart->estado = 'ACTIVO';
                            $cuart->user_id = auth()->id();
                            $cuart->save();
                            $cuart->id;
                            $id_cuartel=$cuart->id;
                        }

                         //buscar bloque si existe recuperar id sino insertar
                         $existeBloque = Bloque::where('codigo', $request->bloque)
                         ->where('cuartel_id', $id_cuartel)
                         ->first();
                                    if($existeBloque!=null){
                                        $id_bloque=$existeBloque->id;
                                    }else{
                                        $bloq = new Bloque;
                                        $bloq->cuartel_id = $id_cuartel;
                                        $bloq->codigo = trim($request->bloque);
                                        $bloq->nombre = trim($request->bloque);
                                        $bloq->estado = 'ACTIVO';
                                        $bloq->user_id = auth()->id();
                                        $bloq->save();
                                        $bloq->id;
                                        $id_bloque=$bloq->id;
                                    }

                                    // insertar nicho
                                    $nicho = new Nicho;
                                    $nicho->cuartel_id = $id_cuartel;
                                    $nicho->bloque_id = $id_bloque;
                                    $nicho->nro_nicho = $request->nro_nicho;
                                    $nicho->fila = $request->fila;
                                    $nicho->tipo = $request->tipo_nicho;
                                    $nicho->codigo = $request->cuartel.".".$request->bloque.".".$request->nro_nicho.".".$request->fila;
                                    $nicho->codigo_anterior = $request->anterior;
                                    $nicho->estado_nicho = 'OCUPADO';
                                    $nicho->user_id = auth()->id();
                                    $nicho->save();
                                    $nicho->id;
                                    $id_nicho= $nicho->id;
                }
                     // end nicho

                 // step2: register difunto --- si id_difunto id_difunto es null insertar difunto insertar responsable
                 $existeDifunto= Difunto::where('ci', $request->ci_dif)->first();
                 if($request->id_difunto==""  || !$existeDifunto){
                        //insertar difunto
                         $difuntoid=$this->insertDifunto($request);
                    }else{
                        $difuntoid=$request->id_difunto;
                        $this->updateDifunto($request, $difuntoid);

                    }
                    // end difunto
                    // step4: register responsable -- si el responsable
                    $existeResponsable= Responsable::where('ci', $request->ci_resp)->first();
                            if($request->id_responsable=="" || !$existeResponsable){
                                //insertar difunto
                                 $idresp=$this->insertResponsable($request);
                            }else{
                                $idresp=$request->id_responsable;
                                $this->updateResponsable($request, $idresp);

                            }
                    //end responsable
                    //insertar tbl responsable_difunto
                            if(isset($difuntoid) && isset($idresp)){

                                $rf=new ResponsableDifunto();
                               $existeRespDif= $rf->searchResponsableDifunt($request);

                                if($existeRespDif!= null ){
                                    $iddifuntoResp= $this->updateDifuntoResp($request, $difuntoid, $idresp, $codigo_n);
                                }else{
                                    $iddifuntoResp=$this->insDifuntoResp($request, $difuntoid, $idresp, $codigo_n);
                                }

                            }


                               //insert pago
                               if($request->person!= "responsable"){
                                $pago_por="Tercera persona";
                                $nombre_pago=$request->name_pago;
                                $paterno_pago=$request->paterno_pago;
                                $materno_pago=$request->materno_pago;
                                $ci=$request->ci;
                                $domicilio= "SIN ESPECIFICACION";
                              }
                              else{
                                $pago_por="Titular responsable";
                                $nombre_pago=$request->nombres_resp;
                                if($request->paterno_resp==""){ $paterno_pago="NO DEFINIDO";}else{
                                    $paterno_pago=$request->paterno_resp;
                                }
                                if($request->domicilio==""){ $domicilio="NO DEFINIDO";}else{
                                    $domicilio= $request->domicilio;
                                }

                                $materno_pago=$request->materno_resp;
                                $ci=$request->ci_resp;

                               }
                             // dd($request);
                             $codigo_nicho=$request->cuartel.".".$request->bloque.".".$request->nicho.".".$request->fila;
                             $servicio_cementery=['525'];
                            if (!empty($request->sel) && is_array($request->sel))
                             {
                                $count = count($request->sel);

                                                if(isset($request->reg)){
                                                    $fur=$request->nrofur;
                                                }
                                           else{
                                                        /** generar fur */
                                                        $cant_gestiones=count($request->sel);
                                                     $cantgestiones=[$cant_gestiones];

                                                        $nombre_difunto=$request->nombres_dif." ".$request->paterno_dif." ".$request->materno_dif;
                                                            $obj= new ServicioNicho;

                                                            $response=$obj->GenerarFur($ci, $nombre_pago, $paterno_pago,
                                                            $materno_pago, $domicilio,  $nombre_difunto, $codigo_nicho,
                                                            $request->bloque, $request->nro_nicho, $request->fila, $servicio_cementery, $cantgestiones, $cajero, null );

                                                            if($response['status']==true){
                                                                $fur = $response['response'];
                                                }

                                                //insertar mantenimiento

                                              //  dd(count($request->sel));

                                                $last= $request->sel[count($request->sel)-1];
                                                $ultimo_pago=$last;
                                                $mant = new Mantenimiento;
                                                $mant->gestion =implode(', ', $request->sel);
                                                $mant->fur=$fur;
                                                $mant->date_in=$request->fechadef_dif;
                                                $mant->respdifunto_id=$iddifuntoResp;
                                                $mant->precio_sinot= $request->precio_sinot;
                                                $mant->cantidad_gestiones=count($request->sel);
                                                $mant->monto=$request->txttotal;
                                                $mant->nombrepago=$nombre_pago;
                                                $mant->paternopago=$paterno_pago;
                                                $mant->maternopago=$materno_pago;
                                                $mant->ci=$ci;
                                                $mant->glosa=$request->glosa;
                                                $mant->pago_por=$pago_por;
                                                $mant->id_usuario_caja = auth()->id();
                                                $mant->ultimo_pago=$ultimo_pago;
                                                $mant->estado='ACTIVO';
                                                $mant->observacion=$request->observacion;
                                                $mant->save();
                                                return  $mant->id;

                             }



                }





            }
            return $fur;
    }


    public function insDifuntoResp($request, $difuntoid, $idresp, $codigo_n){

        $dif = new ResponsableDifunto ;
        $dif->responsable_id = $idresp;
        $dif->difunto_id = $difuntoid;
        $dif->codigo_nicho = $codigo_n;
        $dif->fecha_adjudicacion = $request->fechadef_dif ?? null;
        $dif->tiempo = $request->tiempo;
        $dif->estado = 'ACTIVO';
        $dif->user_id = auth()->id();
        $dif->save();
        $dif->id;
        return  $dif->id;

    }

        public function updateDifuntoResp($request, $difuntoid, $idresp, $codigo_n){

            $dif= ResponsableDifunto::where('responsable_id', $idresp)
                               ->where('difunto_id', $difuntoid)
                               ->where('codigo_nicho', $codigo_n)->first();

            $dif->responsable_id = $idresp;
            $dif->difunto_id = $difuntoid;
            $dif->codigo_nicho = $codigo_n;
            $dif->fecha_adjudicacion = $request->fechadef_dif ?? null;
            $dif->tiempo = $request->tiempo;
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
            $difunto->ci = $request->ci_dif;
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


    public function generatePDF(Request $request)
    {

          $table = DB::table('mantenimiento')
          ->where('mantenimiento.id', $request->id)
          ->Join('responsable_difunto' , 'responsable_difunto.id','=', 'mantenimiento.respdifunto_id')
          ->Join('difunto' , 'difunto.id','=', 'responsable_difunto.difunto_id')

          ->select('mantenimiento.*', 'responsable_difunto.codigo_nicho','difunto.ci as codigo_dif','difunto.nombres','difunto.primer_apellido','difunto.segundo_apellido')
          ->first();

        //  dd($table);
                //     $td=$table->getOriginal();


                    $pdf = PDF::setPaper('A4', 'landscape');
                    $pdf = PDF::loadView('mantenimiento/reportMant', compact('table'));
                    return  $pdf-> stream("preliquidacion_mantenimiento.pdf", array("Attachment" => false));

            }


            /// buscar en la base local

            public function buscar_registros(Request $request){
                $sql=DB::table('mantenimiento')
                ->join('responsable_difunto', 'responsable_difunto.id', '=', 'mantenimiento.respdifunto_id')
                ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
                ->join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
                ->join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
                ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
                ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
                ->where( 'nicho.fila', '=', ''.$request->fila.'')
                ->where('bloque.codigo', '=', ''.$request->bloque.'')
                ->where('nicho.nro_nicho', '=',  $request->nicho)
                // ->orwhere('nicho.codigo_anterior', '=', ''. $request->anterior.'')
                ->select('mantenimiento.gestion', 'mantenimiento.pagado', 'mantenimiento.fur', 'mantenimiento.precio_sinot',
                'mantenimiento.monto', 'mantenimiento.ultimo_pago', 'mantenimiento.nombrepago',
                'mantenimiento.paternopago', 'mantenimiento.paternopago', 'mantenimiento.ci as cipago',
                'mantenimiento.gestion', 'mantenimiento.fecha_pago', 'mantenimiento.monto',  'mantenimiento.fur',
                'difunto.id as id_dif','difunto.ci as ci_dif','difunto.nombres as nombre_dif','difunto.primer_apellido as paterno_dif', 'difunto.segundo_apellido as materno_dif',
                'difunto.fecha_nacimiento as nacimiento_dif', 'difunto.fecha_defuncion', 'difunto.genero as genero_dif', 'difunto.causa', 'difunto.certificado_defuncion',
                'difunto.tipo as tipo_dif',
                'responsable_difunto.fecha_adjudicacion', 'responsable_difunto.tiempo',
                'responsable.id as id_resp','responsable.ci as ci_resp',  'responsable.nombres as nombre_resp',  'responsable.primer_apellido as paterno_resp',
                'responsable.segundo_apellido as materno_resp',  'responsable.fecha_nacimiento as nacimiento_resp',  'responsable.domicilio as dir_resp',
                'responsable.telefono',
                'responsable.celular',
                'responsable.estado_civil',  'responsable.email', 'responsable.genero as genero_resp',
                 'cuartel.codigo as cuartel', 'bloque.codigo as bloque', 'nicho.nro_nicho as nicho', 'nicho.codigo_anterior as anterior', 'nicho.fila as fila','nicho.tipo as tipo_nicho')
                 ->orderBy('mantenimiento.id', 'DESC')
                ->first();
       // dd( $sql);
                if($sql){
                    $mensaje=true;
                }
                else{
                    $mensaje= false;
                }

                $resp= [
                    "mensaje" => $mensaje,
                    "datos"=>$sql
                    ];
                 return response()->json($resp);
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




    public function updatePayMant(Request $request){
<<<<<<< HEAD
         
=======

>>>>>>> 94c7bf6328ebbd783f9035fdc30b68253fd85061
        if($request->isJson()){
            $this->validate($request,[
                "fur"=> 'required',
                 "id_usuario_caja" => 'required'
                 
            ]);

            $pago = Mantenimiento::select('id', 'fur')
            ->where(['fur' => trim($request->fur), 'pagado' => false, 'estado' => 'ACTIVO'])
            ->first();

            if($pago){
                Mantenimiento::where('fur', trim($request->fur))
                ->update([
                   'pagado' => true,
                   'id_usuario_caja' => $request->id_usuario_caja,
                   'fecha_pago'=> date('Y-m-d h:i:s')
                ]);
                return response([
                    'status'=> true
                   // 'message'=> 'El nro fur  no existe o ya fue pagado por favor recargue la pagina'
                 ],200);

            }else{
                return response([
                    'status'=> false,
                    'message'=> 'El nro fur  no existe o ya fue pagado por favor recargue la pagina'
                 ],200);
            }
        }else{
            return response([
                'status'=> false,
                'message'=> 'No autorizado'
             ],401);
        }

    }



    public function buscarFurLiquidacion(Request $request) {
        $arrayBusqueda = [];
        $arrayBusqueda[] = (string)2;
        $arrayBusqueda[] = (string)$request->fur;
        $arrayBusquedaString = json_encode($arrayBusqueda);
        $response = Http::asForm()->post('http://192.168.104.117/cobrosnotributarios/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
            'buscar' => $arrayBusquedaString
        ]);
        if ($response->successful()) {
            if($response->object()->status == true) {
                $dato = $response->object()->data->cobrosVarios[0];


                return $dato;
            }
        }
    }



   public function buscarCuartel(Request $request){
    //    dd($request);
    $sql= DB::table('nicho')
    ->Where('nicho.fila', $request->fila)
    ->Where('bloque.codigo', $request->bloque)
    ->Where('nicho.nro_nicho', $request->nicho)
    ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
    ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
    ->first();

            if($sql){
                return response([
                    'status'=> true,
                    'resp'=> $sql
                 ],200);
            }else{
                return response([
                    'status'=> false,
                    'message'=> 'No autorizado'
                 ],201);
            }


   }

   public function relevamientoPagoMant(Request $request){

            if($request->isJson()){
                $this->validate($request,[
                    "fur"=> 'required',
                    "nombrepago" => 'required',
                    "paternopago" => 'required',
                    // "maternopago" => 'required',
                    // "ci"=> 'required',
                    "ultima_gestion"=> 'required',
                    "monto"=> 'required',
                ]);

              $existe_cripta=DB::table('mantenimiento')->where('id_ubicacion', $request->cripta_mausoleo_id)->first();

                if($existe_cripta!= null || !empty($existe_cripta)){
                    $rel=Mantenimiento::where('id_ubicacion', $request->cripta_mausoleo_id)->first();
                    $rel->gestion=$request->gestiones;

                    $rel->ultimo_pago=$request->ultima_gestion;
                    $rel->nombrepago=$request->nombrepago;
                    $rel->paternopago=$request->paternopago;
                    $rel->maternopago=$request->maternopago;
                    $rel->ci=$request->ci;
                    $rel->fur=$request->fur;
                    $rel->glosa=$request->glosa;
                    $rel->monto=$request->monto;
                    $rel->observacion=$request->observacion;
                    $rel->tipo_ubicacion=$request->tipo_ubicacion;
                    $rel->cuenta_tipo_servicio="15224360";
                    $rel->cuenta_servicio="15224362";
                    $rel->id_ubicacion=$request->cripta_mausoleo_id;
                    $rel->cantidad_gestiones=$request->cantidad_gestiones;
                    $rel->precio_sinot=$request->precio_sinot;
                    $rel->fecha_pago=$request->fecha_pago;
                    $rel->respdifunto_id=$request->respdifunto_id;
                    $rel->id_ubicacion=$request->id_ubicacion;
                    $rel->codigo_ubicacion=$request->codigo_ubicacion;
                    $rel->pago_por=$request->pago_por;
                    $rel->id_usuario_caja=auth()->id();

                    $rel->estado='ACTIVO';
                    $rel->pagado=true;

                    $rel->updated_at = date("Y-m-d H:i:s");
                    $rel->save();

                }else{
                    $rel=New Mantenimiento;
                    $rel->gestion=$request->gestiones;
                    $rel->ultimo_pago=$request->ultima_gestion;
                    $rel->nombrepago=$request->nombrepago;
                    $rel->paternopago=$request->paternopago;
                    $rel->maternopago=$request->maternopago;
                    $rel->ci=$request->ci;
                    $rel->fur=$request->fur;
                    $rel->glosa=$request->glosa;
                    $rel->monto=$request->monto;
                    $rel->observacion=$request->observacion;
                    $rel->tipo_ubicacion=$request->tipo_ubicacion;
                    $rel->cuenta_tipo_servicio="15224360";
                    $rel->cuenta_servicio="15224362";
                    $rel->id_ubicacion=$request->cripta_mausoleo_id;
                    $rel->cantidad_gestiones=$request->cantidad_gestiones;
                    $rel->precio_sinot=$request->precio_sinot;
                    $rel->fecha_pago=$request->fecha_pago;
                    $rel->respdifunto_id=$request->respdifunto_id;
                    $rel->id_ubicacion=$request->id_ubicacion;
                    $rel->codigo_ubicacion=$request->codigo_ubicacion;
                    $rel->pago_por=$request->pago_por;
                    $rel->id_usuario_caja=auth()->id();

                    $rel->estado='ACTIVO';
                    $rel->pagado=true;
                    $rel->created_at = date("Y-m-d H:i:s");
                    $rel->save();
                }
                return response([
                    'status'=> true,
                    'message'=> 'Transacción exitosa'
                     ],200);
            }
            else{
                    return response([
                    'status'=> false,
                    'message'=> 'Error 401 (Unauthorized)'
                     ],401);
            }

   }


   public function getMantenimiento($id_cripta){
        $mant=Mantenimiento::where('id_ubicacion', $id_cripta)->orderBy('id', 'Desc')->first();
        if($mant!=null || !empty($man)){
            return response([
                'status'=> true,
                'resp'=> $mant
                 ],200);
        }
        else{
            return response([
                'status'=> false,
                'message'=> 'Sin resultados'
                 ],201);
        }

   }
}
