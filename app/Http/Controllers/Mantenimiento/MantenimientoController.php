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
use App\Models\Cripta;

use App\Models\Depo;

use App\Models\Mantenimiento;
use App\Models\CriptaMausoleoResp;

use App\Http\Controllers\Controller;
use App\Models\Deposito\DepositoModel;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

use PDF;
use Illuminate\Support\Facades\Http;
class MantenimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('api', ['except' => ['updatePayMant']]);
    }

    public function index(){
        if (auth()->check()) {
            $user = auth()->user();
            $rolUsuario = $user->role;

            }

            if($rolUsuario == "APOYO"){
                return view('restringidos/no_autorizado');
            }else{
                $threeMonthsAgo = now()->subMonths(3);
                $currentMonth = now()->format('m'); // Get the current month in MM format
                $currentYear = now()->format('Y');  // Get the current year in YYYY format

                $mant = Mantenimiento::select('mantenimiento.*', DB::raw('CONCAT(mantenimiento.nombrepago , \' \',mantenimiento.paternopago, \' \', mantenimiento.maternopago ) AS nombre'))
                   // ->leftJoin('responsable', 'responsable.id', '=', 'mantenimiento.respdifunto_id')
                    ->where('mantenimiento.estado', 'ACTIVO')
                    ->whereBetween('mantenimiento.created_at', [$threeMonthsAgo, now()])
                    // ->whereRaw("DATE_PART('month', mantenimiento.created_at) = ?", [$currentMonth])
                    // ->whereRaw("DATE_PART('year', mantenimiento.created_at) = ?", [$currentYear])
                    ->orderBy('id', 'DESC')
                     ->get();
                     return view('mantenimiento/index', compact('mant'));
                }
    }

    public function createPay(){

        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();

        // $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/525', [
        $response = $client->get('https://multiserv.cochabamba.bo/api/v1/cementerio/generate-servicios-nicho/525', [

        'json' => [
            ],
            'headers' => $headers,
        ]);
        $data = json_decode((string) $response->getBody(), true);


       if($data['status']==true){
            $precio = $data['response'][0]['monto1'];
            $cuenta = $data['response'][0]['cuenta'];
            $descrip = $data['response'][0]['descripcion'];
            $num_sec = $data['response'][0]['num_sec'];

        }else{
            $precio =0;
        }

        $causa=DB::table('difunto')
        ->select('causa')
        ->whereNotNull('causa')
        ->distinct()->get();

        return view('mantenimiento/nuevoPago', ['precio' =>$precio, 'cuenta' =>$cuenta, 'descrip' =>$descrip,  'num_sec' =>$num_sec, 'causa' => $causa]);
    }


     public function consultaMant(){

     }

    public function savePay(Request $request){

    //    dd($request);
        if($request->isJson())
        {
            $this->validate($request, [
                'nro_nicho'=> 'required',
                'bloque'=> 'required',
                'cuartel'=> 'required',
                'fila'=> 'required',
                'tipo_nicho'=> 'required',
                // 'ci_dif'=> 'required',
                'nombres_dif'=> 'required',
               // 'paterno_dif'=> 'required',
               // 'tipo_dif'=> 'required',
               // 'genero_dif'=> 'required',
                // 'ci_resp'=> 'required',
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
                // 'ci_dif.required'=> 'El campo ci del difunto es obligatorio, si no tiene documento presione el boton "generar carnet provisional  (icono lapiz)" para asignarle un numero provisional',

                'nombres_dif.required'=> 'El campo nombres del difunto es obligatorio',
               // 'paterno_dif.required'=> 'El campo apellido paterno es obligatorio',
                'tipo_dif.required'=> 'El campo tipo de difunto (adulto o parvulo) es obligatorio',
               // 'genero_dif.required'=> 'El campo genero del difunto es obligatorio',
            //    'ci_resp.required'=> 'El campo ci del responsable es obligatorio, si no tiene documento presione el boton "generar carnet provisional (icono lapiz)" para asignarle un numero provisional',
                 'nombres_resp.required'=> 'El campo nombre del responsable es obligatorio',
                 'paterno_resp.required'=> 'El campo apellido paterno del responsable  es obligatorio',

                'sel.required'=>'Debe seleccionar al menos una gestion a pagar',


            ]);

            // print_r(auth()->id());
           $datos_cajero=User::select()
           ->where('id',auth()->id())
           ->first();
            $cajero= $datos_cajero->user_sinot;
            $fur="";
            //step1: nicho buscar si existe registrado el nicho recuperar el id  sino existe registrarlo
            $codigo_n=$request->cuartel.".".$request->bloque.".".$request->nro_nicho.".".$request->fila;
            $existeNicho= Nicho::where('codigo', $codigo_n)->first();
            // dd(  $codigo_n);

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
                                    $ni = new Nicho();
                                    $ni->InsertNichoPartial(
                                        $id_cuartel,
                                        $id_bloque,
                                        $request->nro_nicho,
                                        $request->fila,
                                        $request->tipo_nicho,
                                        'LIBRE',
                                        0,
                                        0,
                                        $request->anterior
                                    );


                                    $id_nicho= $ni->id;
                }
                     // end nicho
// dd($id_nicho);
                 // step2: register difunto --- si id_difunto id_difunto es null insertar difunto insertar responsable
                 $d=New Difunto;
                 $existeDifunto=$d->searchDifunto($request);
                 //dd( $existeDifunto->id);
                 if(!$existeDifunto || $existeDifunto==null || empty($existeDifunto) ){
                        //insertar difunto
                         $difuntoid=$d->insertDifunto($request);
                    }else{
                        $difuntoid=$existeDifunto->id;
                        $d->updateDifunto($request, $difuntoid);

                    }

                    // end difunto
                    // step4: register responsable -- si el responsable
                    // $existeResponsable= Responsable::where('ci', $request->ci_resp)->first();
                    // step4: register responsable -- si el responsable
                    $r=New Responsable;
                    $existeResponsable=$r->searchResponsable($request);

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
                        $adjudicatario= $request->nombre_resp." ".$request->paterno_resp." ".$request->materno_resp;

                    }
                    else{

                        $ci_adjudicatario=$existeResponsable->ci ?? $request->ci_resp ;
                        $adjudicatario= $existeResponsable->nombres_resp." ".$existeResponsable->paterno_resp." ".$existeResponsable->materno_resp;

                    }



                            if (isset($difuntoid) && isset($idresp)) {
                                // dd($estado_nicho);
                                $rf = new ResponsableDifunto();
                                $existeRespDif = $rf->searchResponsableDifunt($request, $idresp, $difuntoid,  $codigo_n );
// dd($existeRespDif);
                                if ($existeRespDif != null) {
                                    $iddifuntoResp = $rf->updateDifuntoResp($request, $difuntoid, $idresp, $codigo_n , null);
                                } else {
                                    $iddifuntoResp = $rf->insDifuntoResp($request, $difuntoid, $idresp, $codigo_n , null, $id_nicho);
                                }
                            }

                               //insert pago
                               if($request->person!= "responsable"){
                                $pago_por="Tercera persona";
                                $nombre_pago=$request->name_pago;
                                $paterno_pago=$request->paterno_pago;
                                $materno_pago=$request->materno_pago;
                                $domicilio= "SIN ESPECIFICACION";
                                if($ci=$request->ci!="" || $ci=$request->ci!=null){
                                    $ci=$request->ci;
                                }else{
                                    $ci=$ci_adjudicatario;
                                }
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
                                $ci=$ci_adjudicatario;

                               }
                             $codigo_n=$request->cuartel.".".$request->bloque.".".$request->nro_nicho.".".$request->fila;
                            // dd($codigo_n);

                             $servicio_cementery=525;
                            if (!empty($request->sel) && is_array($request->sel))
                             {
                                $count = count($request->sel);

                                                if(isset($request->reg)){
                                                    $fur=$request->nrofur;
                                                }
                                           else{
                                                        /** generar fur */
                                                        $cant_gestiones=count($request->sel);
                                                        $cantgestiones=$cant_gestiones;


                                                            $nombre_difunto=$request->nombres_dif." ".$request->paterno_dif." ".$request->materno_dif;
                                                            $obj= new ServicioNicho;

                                                            $response=$obj->GenerarFurMant($ci, $nombre_pago, $paterno_pago,
                                                            $materno_pago, $domicilio,  $nombre_difunto, $codigo_n,
                                                            $request->bloque, $request->nro_nicho, $request->fila, $servicio_cementery, $cantgestiones, $cajero,
                                                             $adjudicatario, $ci_adjudicatario, $request->observacion);

                                                            if($response['status']==true){
                                                                $fur = $response['response'];
                                                             }

                                                //insertar mantenimiento

                                                $last= $request->sel[count($request->sel)-1];
                                                $ultimo_pago=$last;
                                                $mant = new Mantenimiento;
                                                $mant->gestion = implode(', ', $request->sel);
                                                $mant->fur=$fur;
                                                // $mant->date_in=date('Y-m-d');

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
                                                $mant->observacion=$request->observacion??'';
                                                $mant->tipo_ubicacion="NICHO";
                                                $mant->id_ubicacion=$id_nicho;
                                                $mant->desc_servicio=$request->text_servicio;
                                                $mant->codigo_ubicacion=$codigo_n;
                                                $mant->cuenta_tipo_servicio=$request->cuenta_tipo_servicio;
                                                $mant->cuenta_servicio=$request->cuenta_servicio;
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


    //     public function insertDifunto($request){
    //         /*******verificar si el campo ci del difunto esta vacio y generar uno provisional */
    //         if(!isset($request->ci_dif) || $request->ci_dif==null || $request->ci_dif==''){
    //          $dif=new Difunto;
    //          $ci_dif=$dif->generateCiDifunto();
    //    }else{
    //        $ci_dif=$request->ci_dif;
    //    }

    //      $dif = new Difunto;
    //      $dif->ci = $ci_dif;
    //      $dif->nombres = trim(mb_strtoupper($request->nombres_dif, 'UTF-8'));
    //      $dif->primer_apellido = trim(mb_strtoupper($request->paterno_dif, 'UTF-8'));
    //      $dif->segundo_apellido =trim(mb_strtoupper( $request->materno_dif, 'UTF-8'));
    //      $dif->fecha_nacimiento = $request->fechanac_dif ?? null;
    //      $dif->fecha_defuncion = $request->fecha_def_dif ?? null;
    //      $dif->certificado_defuncion = $request->sereci;
    //      $dif->causa = trim(mb_strtoupper($request->causa, 'UTF-8'));
    //      $dif->tipo = $request->tipo_dif;
    //      $dif->genero = $request->genero_dif ?? '';
    //      $dif->certificado_file = $request->urlcertificacion;
    //      $dif->funeraria =trim(mb_strtoupper($request->funeraria, 'UTF-8'));
    //      $dif->estado = 'ACTIVO';
    //      $dif->user_id = auth()->id();
    //      $dif->save();
    //      $dif->id;
    //      return  $dif->id;

    //  }

    //  public function updateDifunto($request, $difuntoid){

    //      $difunto= Difunto::where('id', $difuntoid)->first();
    //      // $difunto->ci = $request->ci_dif;
    //      $difunto->nombres = trim(mb_strtoupper($request->nombres_dif, 'UTF-8'));
    //      $difunto->primer_apellido = trim(mb_strtoupper($request->paterno_dif, 'UTF-8'));
    //      $difunto->segundo_apellido =trim(mb_strtoupper( $request->materno_dif, 'UTF-8'));
    //      $difunto->fecha_nacimiento = $request->fechanac_dif ?? null;
    //      $difunto->fecha_defuncion = $request->fecha_def_dif ?? null;
    //      $difunto->certificado_defuncion = $request->sereci;
    //      $difunto->causa =  trim(mb_strtoupper($request->causa, 'UTF-8'));
    //      $difunto->tipo = $request->tipo_dif;
    //      $difunto->genero = $request->genero_dif?? '';
    //      $difunto->certificado_file = $request->urlcertificacion;
    //      $difunto->funeraria = trim(mb_strtoupper($request->funeraria, 'UTF-8'));
    //      $difunto->estado = 'ACTIVO';
    //      $difunto->user_id = auth()->id();
    //      $difunto->save();
    //      return $difunto->id;
    //  }

     public function insertResponsable($request){

         $responsable = new Responsable;
         $responsable->ci = $request->ci_resp;
         $responsable->nombres =  trim(mb_strtoupper($request->nombres_resp, 'UTF-8'));
         $responsable->primer_apellido = trim(mb_strtoupper($request->paterno_resp, 'UTF-8'));
         $responsable->segundo_apellido =  trim(mb_strtoupper($request->materno_resp, 'UTF-8'));
         $responsable->fecha_nacimiento = $request->fechanac_resp ?? null;
         $responsable->genero = $request->genero_resp ?? '';
         $responsable->telefono = $request->telefono;
         $responsable->celular = $request->celular;
         $responsable->estado_civil = $request->ecivil ?? '';
         $responsable->domicilio = $request->domicilio?? '';
         $responsable->email = $request->email ?? '';
         $responsable->estado = 'ACTIVO';
         $responsable->user_id = auth()->id();
         $responsable->save();
         $responsable->id;
         return  $responsable->id;

     }

     public function updateResponsable($request, $difuntoid){
         $responsable= Responsable::where('id', $difuntoid)->first();
         if($request->ci_resp!=null || $request->ci_resp!=""){
         $responsable->ci = $request->ci_resp;

         }
         $responsable->nombres =  trim(mb_strtoupper($request->nombres_resp, 'UTF-8'));
         $responsable->primer_apellido = trim(mb_strtoupper($request->paterno_resp, 'UTF-8'));
         $responsable->segundo_apellido =  trim(mb_strtoupper($request->materno_resp, 'UTF-8'));
         $responsable->fecha_nacimiento = $request->fechanac_resp ?? null;
         $responsable->genero = $request->genero_resp ?? '';
         $responsable->telefono = $request->telefono;
         $responsable->celular = $request->celular;
         $responsable->estado_civil = $request->ecivil ??'';
         $responsable->domicilio = $request->domicilio?? '';
         $responsable->email = $request->email ??  '';
         $responsable->estado = 'ACTIVO';
         $responsable->user_id = auth()->id();
         $responsable->save();
         return $responsable->id;
     }



            /// buscar en la base local

            public function buscar_registros(Request $request){

                if($request->cuartel!=""|| $request->cuartel!=null || isset($request->cuartel)){
                    $codigo=$request->cuartel.".".$request->bloque.".".$request->nicho.".".$request->fila;
                    $sql_nicho = DB::table('nicho')
                    ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
                    ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
                    ->where( 'nicho.fila', '=', ''.$request->fila.'')
                    ->where('bloque.codigo', '=', ''.$request->bloque.'')
                    ->where('nicho.nro_nicho', '=',  ''.$request->nicho.'')
                    ->where('cuartel.codigo', '=',  ''.$request->cuartel.'')
                    ->where('nicho.codigo', $codigo)
                    ->where('nicho.estado', 'ACTIVO')
                    ->select('nicho.*')
                    ->orderBy('nicho.id', 'desc')
                    ->first();
                    if( $sql_nicho) {

                        $id_ubicacion=$sql_nicho->id;
                        $data_mantenimiento=DB::table('mantenimiento')->where('id_ubicacion', $id_ubicacion)
                        ->where('estado','ACTIVO') ->orderBy('mantenimiento.id', 'desc')->first();
                        if( $data_mantenimiento) {
                            $id_respdifunto= $data_mantenimiento->respdifunto_id;
                            //buscar los datos del responsable y difuntos
                            $respdifunto=DB::table('responsable_difunto')
                            ->where('id', $id_respdifunto)
                            ->where('estado', 'ACTIVO')
                            ->orderBy('id', 'desc')
                            ->first();
                            $id_difunto=$respdifunto->difunto_id;
                            $id_responsable=$respdifunto->responsable_id;
                            $difunto=DB::table('difunto')
                            ->where('id',$id_difunto)
                            ->where('estado','ACTIVO')
                            ->orderBy('id', 'desc')
                            ->first();
                            $responsable=DB::table('responsable')
                            ->where('id',$id_responsable)
                            ->where('estado','ACTIVO')
                            ->orderBy('id', 'desc')
                            ->first();

                            $response=[
                                "status"=> true,
                                "nicho" =>$sql_nicho,
                                "mantenimiento"=>$data_mantenimiento,
                                "respdifunto"=>$respdifunto,
                                "difunto"=>$difunto,
                                "responsable"=>$responsable
                            ];
                             return response()->json($response);


                        }
                        else{
                            $respdifunto=DB::table('responsable_difunto')
                            ->where('codigo_nicho', $codigo)
                            ->where('estado', 'ACTIVO')
                            ->orderBy('id', 'desc')
                            ->first();
                            if($respdifunto){
                                $id_difunto=$respdifunto->difunto_id;
                                $id_responsable=$respdifunto->responsable_id;
                                $difunto=DB::table('difunto')
                                ->where('id',$id_difunto)
                                ->where('estado','ACTIVO')
                                ->orderBy('id', 'desc')
                                ->first();
                                $responsable=DB::table('responsable')
                                ->where('id',$id_responsable)
                                ->where('estado','ACTIVO')
                                ->orderBy('id', 'desc')
                                ->first();

                                $response=[
                                    "status"=> true,
                                    "nicho" =>$sql_nicho,
                                    "mantenimiento"=>[],
                                    "respdifunto"=>$respdifunto,
                                    "difunto"=>$difunto,
                                    "responsable"=>$responsable
                                ];
                                 return response()->json($response);
                            }else{
                                $response=["status"=>false,"error"=>'No se encontró el nicho solicitado'];
                                return response()->json($response);
                            }

                        }

                    }else{
                        $response=["status"=>false,"error"=>'No se encontró el nicho solicitado'];
                        return response()->json($response);
                    }



                    // $data_mantenimiento=DB::table('mantenimiento')->where('')->first();
                    // $sql=DB::table('mantenimiento')
                    // ->join('responsable_difunto', 'responsable_difunto.id', '=', 'mantenimiento.respdifunto_id')
                    // ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
                    // ->join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
                    // ->join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
                    // ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
                    // ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
                    // ->where( 'nicho.fila', '=', ''.$request->fila.'')
                    // ->where('bloque.codigo', '=', ''.$request->bloque.'')
                    // ->where('nicho.nro_nicho', '=',  ''.$request->nicho.'')
                    // ->where('cuartel.codigo', '=',  ''.$request->cuartel.'')
                    // ->where('mantenimiento.estado',  'ACTIVO')
                    // ->orwhere('responsable_difunto.estado', '=', 'ACTIVO')
                    // ->select('mantenimiento.gestion', 'mantenimiento.pagado', 'mantenimiento.fur', 'mantenimiento.precio_sinot',
                    // 'mantenimiento.monto', 'mantenimiento.ultimo_pago', 'mantenimiento.nombrepago',
                    // 'mantenimiento.paternopago', 'mantenimiento.paternopago', 'mantenimiento.ci as cipago',
                    // 'mantenimiento.gestion', 'mantenimiento.fecha_pago', 'mantenimiento.monto',  'mantenimiento.fur',
                    // 'difunto.id as id_dif','difunto.ci as ci_dif','difunto.nombres as nombre_dif','difunto.primer_apellido as paterno_dif', 'difunto.segundo_apellido as materno_dif',
                    // 'difunto.fecha_nacimiento as nacimiento_dif', 'difunto.fecha_defuncion', 'difunto.genero as genero_dif', 'difunto.causa', 'difunto.certificado_defuncion',
                    // 'difunto.tipo as tipo_dif',
                    // 'responsable_difunto.fecha_adjudicacion', 'responsable_difunto.tiempo',
                    // 'responsable.id as id_resp','responsable.ci as ci_resp',  'responsable.nombres as nombre_resp',  'responsable.primer_apellido as paterno_resp',
                    // 'responsable.segundo_apellido as materno_resp',  'responsable.fecha_nacimiento as nacimiento_resp',  'responsable.domicilio as dir_resp',
                    // 'responsable.telefono',
                    // 'responsable.celular',
                    // 'responsable.estado_civil',  'responsable.email', 'responsable.genero as genero_resp',
                    //  'cuartel.codigo as cuartel', 'bloque.codigo as bloque', 'nicho.nro_nicho as nicho', 'nicho.codigo_anterior as anterior', 'nicho.fila as fila','nicho.tipo as tipo_nicho')
                    //  ->orderBy('mantenimiento.id', 'DESC')
                    // ->first();
                }
                else{
                    $response = ["status"=> false ,
                                 "error"=> 'codigo de ubicacion incorrecto o incompleto, por favor verifique si ingreso cuartel en el campo correspondiente'
                                ];
                                return response()->json($response);


                //    dd("sfesrerwrwe");
                    // $sql=DB::table('mantenimiento')
                    // ->join('responsable_difunto', 'responsable_difunto.id', '=', 'mantenimiento.respdifunto_id')
                    // ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
                    // ->join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
                    // ->join('nicho', 'nicho.codigo', '=', 'responsable_difunto.codigo_nicho')
                    // ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
                    // ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
                    // ->where( 'nicho.fila', '=', ''.$request->fila.'')
                    // ->where('bloque.codigo', '=', ''.$request->bloque.'')
                    // ->where('nicho.nro_nicho', '=',  ''.$request->nicho.'')
                    // ->where('responsable_difunto.estado',  'ACTIVO')
                    // ->where('mantenimiento.estado',  'ACTIVO')
                    // ->select('mantenimiento.gestion', 'mantenimiento.pagado', 'mantenimiento.fur', 'mantenimiento.precio_sinot',
                    // 'mantenimiento.monto', 'mantenimiento.ultimo_pago', 'mantenimiento.nombrepago',
                    // 'mantenimiento.paternopago', 'mantenimiento.paternopago', 'mantenimiento.ci as cipago',
                    // 'mantenimiento.gestion', 'mantenimiento.fecha_pago', 'mantenimiento.monto',  'mantenimiento.fur',
                    // 'difunto.id as id_dif','difunto.ci as ci_dif','difunto.nombres as nombre_dif','difunto.primer_apellido as paterno_dif', 'difunto.segundo_apellido as materno_dif',
                    // 'difunto.fecha_nacimiento as nacimiento_dif', 'difunto.fecha_defuncion', 'difunto.genero as genero_dif', 'difunto.causa', 'difunto.certificado_defuncion',
                    // 'difunto.tipo as tipo_dif',
                    // 'responsable_difunto.fecha_adjudicacion', 'responsable_difunto.tiempo',
                    // 'responsable.id as id_resp','responsable.ci as ci_resp',  'responsable.nombres as nombre_resp',  'responsable.primer_apellido as paterno_resp',
                    // 'responsable.segundo_apellido as materno_resp',  'responsable.fecha_nacimiento as nacimiento_resp',  'responsable.domicilio as dir_resp',
                    // 'responsable.telefono',
                    // 'responsable.celular',
                    // 'responsable.estado_civil',  'responsable.email', 'responsable.genero as genero_resp',
                    //  'cuartel.codigo as cuartel', 'bloque.codigo as bloque', 'nicho.nro_nicho as nicho', 'nicho.codigo_anterior as anterior', 'nicho.fila as fila','nicho.tipo as tipo_nicho')
                    //  ->orderBy('mantenimiento.id', 'DESC')
                    // ->first();



                }


                // if($sql){
                //     $mensaje=true;
                // }
                // else{
                //     $mensaje= false;
                // }

                // $resp= [
                //     "mensaje" => $mensaje,
                //     "datos"=>$sql
                //     ];
                //  return response()->json($resp);
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

        if($request->isJson()){
            $this->validate($request,[
                "fur"=> 'required',
                // "id_usuario_caja" => 'required'
            ]);

            $pago = Mantenimiento::select('id', 'fur')
            ->where(['fur' => trim($request->fur), 'pagado' => false, 'estado' => 'ACTIVO'])
            ->first();

            if(!$pago){
                $depo = DepositoModel::select('id', 'fur')
                ->where(['fur' => trim($request->fur), 'pagado' => false, 'estado' => 'ACTIVO'])
                ->first();

                if($depo){
                    DepositoModel::where('fur', trim($request->fur))
                    ->update([
                       'estado_pago' => true,
                    //    'id_usuario_caja' => $request->id_usuario_caja,
                       'fecha_pago'=> date('Y-m-d')
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
            }

            if($pago){
                Mantenimiento::where('fur', trim($request->fur))
                ->update([
                   'pagado' => true,
                //    'id_usuario_caja' => $request->id_usuario_caja,
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
        // $response = Http::asForm()->post('http://192.168.104.117/cobrosnotributarios/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
            $response = Http::asForm()->post(env('URL_SEARCH_FUR'), [

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
                    $rel->cuenta_servicio="526";
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


   /***************************************************************************** */
   /******************* seccion pago mantenimiento criptas mausoleos************* */
   /***************************************************************************** */


   public function getInfoPayCm(){

    $headers =  ['Content-Type' => 'application/json'];
    $client = new Client();

    // $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/526', [
    $response = $client->get('https://multiserv.cochabamba.bo/api/v1/cementerio/generate-servicios-nicho/526', [

    'json' => [
        ],
        'headers' => $headers,
    ]);
    $data = json_decode((string) $response->getBody(), true);

       // dd( $data);
   if($data['status']==true){
        $precio = $data['response'][0]['monto1'];
        $cuenta = $data['response'][0]['cuenta'];
        $descrip = $data['response'][0]['descripcion'];
        $num_sec = $data['response'][0]['num_sec'];

    }else{
        $precio =0;
    }


    return $data;

   // return view('mantenimiento/PagoCmant', ['precio' =>$precio, 'cuenta' =>$cuenta, 'descrip' =>$descrip, 'num_sec' => $num_sec ]);
}


public function indexcm(Request $request){
    if(($request->select_cuartel_search==null && $request->bloque_search ==null && $request->sitio_search ==null) ||
    (!isset($request->select_cuartel_search) && !isset($request->bloque_search) && !isset($request->sitio_search))){
     $cripta = Cripta::select('cripta_mausoleo.id', 'cripta_mausoleo.codigo',  'superficie','cripta_mausoleo.estado',
     'tipo_registro','enterratorios_ocupados','total_enterratorios','osarios', 'total_osarios','cenisarios', 'cripta_mausoleo.notable',
     'cripta_mausoleo_responsable.documentos_recibidos',   'cripta_mausoleo_responsable.adjudicacion', 'cripta_mausoleo.difuntos',
     'cripta_mausoleo.ultima_gestion_pagada as ultimo_pago',

    'cripta_mausoleo.sitio','cripta_mausoleo.codigo_antiguo','cripta_mausoleo.familia','cripta_mausoleo_responsable.estado as estado_rel_resp',
     DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'),
     'cuartel.codigo as cuartel_codigo','bloque.codigo as bloque_nombre')
     ->Join('cuartel','cuartel.id', '=', 'cripta_mausoleo.cuartel_id' )
     ->leftJoin('bloque','bloque.id', '=', 'cripta_mausoleo.bloque_id' )
    ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
    ->leftJoin('responsable','responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id' )
   // ->leftJoin('mantenimiento','mantenimiento.id_ubicacion', '=', 'cripta_mausoleo.id' )
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
     'cripta_mausoleo_responsable.documentos_recibidos',   'cripta_mausoleo_responsable.adjudicacion', 'cripta_mausoleo.difuntos',
         'cripta_mausoleo.ultima_gestion_pagada as ultimo_pago',

    'cripta_mausoleo.sitio','cripta_mausoleo.codigo_antiguo','cripta_mausoleo.familia','cripta_mausoleo_responsable.estado as estado_rel_resp',
     DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'),
     'cuartel.codigo as cuartel_codigo','bloque.codigo as bloque_nombre')
     ->Join('cuartel','cuartel.id', '=', 'cripta_mausoleo.cuartel_id' )
     ->leftJoin('bloque','bloque.id', '=', 'cripta_mausoleo.bloque_id' )
    ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id' )
    ->leftJoin('responsable','responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id' )
   // ->leftJoin('mantenimiento','mantenimiento.id_ubicacion', '=', 'cripta_mausoleo.id' )
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
 return view('mantenimiento/nuevoPagoCm',['cripta' => $cripta, 'cuartel' => $cuartel, 'funeraria' => $funeraria, 'causa' => $causa]);
}

// save pago mantenimiento criptas mausoleo

public function pagoMantenimientoCM(Request $request){
         // dd($request);
      if($request->isJson())
      {
          $this->validate($request, [
              'id_cripta_mausoleo'=> 'required',
              'cuenta'=> 'required',
              'descripcion'=> 'required',
              'ultima_gestion_actual'=> 'required',
              'gestiones_act'=> 'required',
              'cantidad'=> 'required',
              'codigo_unidad'=> 'required',
              'resp_id'=> 'required',
              'superficie'=> 'required',
              'nombrepago'=> 'required',
              'paternopago'=> 'required',
              'pago_por'=> 'required',
          ], [
              'id_cripta_mausoleo.required'=> 'El campo identificador del mausoleo o cripta es obligatorio',
              'cuenta.required'=> 'El nro de cuenta del servicio es requerido',
              'descripcion.required'=> 'El nro de cuenta del servicio es requerido',
              'ultima_gestion_actual.required'=> 'Debe seleccionar la(s) gestiones que desea pagar',
              'gestiones_act.required'=> 'Debe seleccionar la(s) gestiones que desea pagar',
              'cantidad.required'=> 'Debe seleccionar al menos una gestion a pagar',
              'codigo_unidad.required'=> 'El codigo de la unidad es requerido',
              'resp_id.required'=> 'La unidad debe estar asignada a un responsable',
               'superficie.required'=> 'Complete la informacion de la superficie de la ubicacion, vaya a la ficha de llenado de criptas / mausoleos',
               'nombrepago.required'=> 'El campo nombre del responsable es obligatorio',
               'paternopago.required'=> 'El campo apellido paterno del responsable  es obligatorio',
               'pago_por.required'=> 'Debe especificar si el pago se esta realizando por el propietario o un tercero',

          ]);
                 //   sacar informacion del cuartel bloque sitio de la cripta
                 $cuartel="";
                 $bloque="";
                 $sitio="";
                 $tipo="";
                 $infoCripta = DB::table('cripta_mausoleo')
                 ->join('cuartel', 'cuartel.id','=','cripta_mausoleo.cuartel_id')
                 ->join('bloque', 'bloque.id','=','cripta_mausoleo.bloque_id')
                 ->select('sitio', 'familia', 'cripta_mausoleo.codigo', 'cuartel.codigo as cuartel', 'bloque.codigo as bloque', 'cripta_mausoleo.tipo_registro' )
                 ->orderBy('cripta_mausoleo.id', 'DESC')
                 ->first();
                 if( $infoCripta){
                    $cuartel=$infoCripta->cuartel;
                    $bloque=$infoCripta->bloque;
                    $sitio=$infoCripta->sitio;
                    $tipo=$infoCripta->tipo_registro;
                 }else{
                    return response()->json(['errors' => ['general' => 'No se ha podido obtener información del mausoleo']]);
                 }

                /** generar fur */
                        //insert pago
                        if($request->pago_por!= "Titular_responsable"){
                            $pago_por="Tercera persona";
                            $nombre_pago=$request->name_pago;
                            $paterno_pago=$request->paterno_pago;
                            $materno_pago=$request->materno_pago;
                            $ci=$request->ci;
                            $domicilio= $request->domicilio ?? "SIN ESPECIFICACION";
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
                    $datos_cajero=User::select()
                    ->where('id',auth()->id())
                    ->first();
                    $cajero= $datos_cajero->user_sinot;
                    $cantidades=$request->cantidad;
                    $servicio_hijos=$request->num_sec;
                    $obj= new ServicioNicho;
                    $response=$obj->GenerarFurCMant($request->ci, $request->nombrepago, $request->paternopago, $request->maternopago, $request->domicilio, $request->codigo_unidad,
                    $servicio_hijos , $cantidades, $cajero, $request->resp_id, $request->observacion , $request->superficie, $cuartel, $bloque, $sitio, $tipo);


                    if($response['status']==true){
                        $fur = $response['response'];
                     }

                     $cripta= Cripta::where('id', $request->id_cripta_mausoleo)->first();
                     $cripta->list_ant_difuntos=$cripta->difuntos;
                     $cripta->ult_gestion_pagada_ant=$cripta->ultima_gestion_pagada;
                     $cripta->gestiones_pagadas_ant=$cripta->gestiones_pagadas;
                     $cripta->gestiones_pagadas = $request->gestiones_act;
                     $cripta->ultima_gestion_pagada = $request->ultima_gestion_actual;

                     $cripta->save();

                                    $serv = new Mantenimiento();
                                    $serv->codigo_ubicacion=$request->codigo_unidad;
                                    $serv->date_in= date("Y-m-d H:i:s");
                                    $serv->cuenta_tipo_servicio=$request->cuenta; //$request->tipo_servicio;
                                    $serv->desc_servicio= $request->descripcion;
                                    $serv->glosa= $request->descripcion;
                                    $serv->estado="ACTIVO";
                                    $serv->cuenta_servicio= $request->num_sec;
                                    $serv->respdifunto_id=$request->resp_id;
                                    $serv->fur=$fur;
                                    $serv->gestion=$request->gestiones_act;
                                    $serv->cantidad_gestiones=$request->cantidad;
                                    $serv->ultimo_pago=$request->ultima_gestion_actual;
                                    $serv->precio_sinot=$request->precio_sinot;
                                    $serv->monto=$request->total_monto;
                                    $serv->nombrepago=$request->nombrepago;
                                    $serv->paternopago=$request->paternopago;
                                    $serv->maternopago=$request->maternopago;
                                    $serv->ci=$request->ci;
                                    $serv->pago_por=$request->pago_por;
                                    $serv->observacion=$request->observacion;
                                    $serv->tipo_ubicacion=$request->tipo_registro;
                                    $serv->id_ubicacion =$request->id_cripta_mausoleo ;

                                    $serv->save();

                                if($serv->id){
                                    return response([
                                        'status'=> true,
                                        'mensage'=>"servicio registrado con exito"
                                    ],200);
                                }else{
                                    return response([
                                        'status'=> false,
                                        'mensage'=>"algo fallo en la transaccion intentelo nuevamente"
                                    ],201);
                                }






      }
    }


    public function verificarPagoMant(Request $request){
        $service=New ServicioNicho;
        $estado_pago=$service->buscarFur($request);

        if($estado_pago->estado_pago=="AC"){
            $this->updatePayMant($request);
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


    public function anularFurMant(Request $request){
        // todo: terminar modulo
        //dd($request);
        $sn=New Mantenimiento;
        $serv=$sn->anularServicio($request);
        return $serv;
     }


       //imprimir preliquidacion para criptas mausoleos

    public function generatePDFCM(Request $request) {
                         //    return($request->codigo_nicho); die();
                     //
                        $tab=[];
                        $tablelocal=DB::table('mantenimiento')
                        ->select('mantenimiento.*')
                        ->where('id','=',$request->id)
                        // ->where('tipo','=',$request->tipo)
                        ->orderBy('id','DESC')
                        ->first();
                            //dd($tablelocal->tipo_ubicacion);
                        $datos_ubicacion=$tablelocal->id_ubicacion??'';
                        $tipo_ubicacion=$tablelocal->tipo_ubicacion??'';
                        $det_exhum=$tablelocal->det_exhum ??'';
                        $responsable_difunto_id=$tablelocal->respdifunto_id;
                        $pago_por= $tablelocal->pago_por;
                        $codigo_ubicacion=$tablelocal->codigo_ubicacion;

                        if($tipo_ubicacion=="CRIPTA" || $tipo_ubicacion== "MAUSOLEO" ){
                            $sq=CriptaMausoleoResp::where('cripta_mausoleo_responsable.cripta_mausole_id', '=',$datos_ubicacion )
                            ->join('responsable', 'responsable.id', '=', 'cripta_mausoleo_responsable.responsable_id')
                            ->select('responsable.nombres as nombre_resp', 'responsable.primer_apellido as paterno_resp', 'responsable.segundo_apellido as materno_resp', 'responsable.ci as ci_resp' )->first();
                            $resp=$sq->nombre_resp. " " . $sq->paterno_resp. " ".$sq->materno_resp;
                            $ci_resp="  C.I.: ".$sq->ci_resp;
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
                                $id_s= $tablelocal->cuenta_servicio;


                                            $headers =  ['Content-Type' => 'application/json'];
                                            $client = new Client();

                                             $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/'.trim($id_s).'', [
                                               // $response = $client->get('https://multiserv.cochabamba.bo/api/v1/cementerio/generate-servicios-nicho/'.trim($id_s).'', [
                                            'json' => [
                                                ],
                                                'headers' => $headers,
                                            ]);
                                            $data = json_decode((string) $response->getBody(), true);

                                        if($data['status']==true){
                                            $tab['cobrosDetalles']['cuenta']=$data['response'][0]['cuenta'];
                                            $tab['cobrosDetalles']['detalle']=$data['response'][0]['descripcion'];
                                            $tab['cobrosDetalles']['monto']=0;
                                            }



                                    $table = json_decode(json_encode($tab));

                                $pdf = PDF::setPaper('A4', 'landscape');
                                $pdf = PDF::loadView('mantenimiento/reportServCM', compact('table','codigo_ubicacion', 'observacion', 'det_exhum', 'resp', 'datoSitio' ,  'pago_por'));
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
                                        $data=json_decode($response->body()) ;


                                    if ($response->successful()) {
                                        if($response->object()->status == true) {
                                            $table = $data->data->cobrosVarios[0];
                                            $observacion= $tablelocal->observacion;

                                            $pdf = PDF::setPaper('A4', 'landscape');
                                            $pdf = PDF::loadView('mantenimiento/reportServCM', compact('table','codigo_ubicacion', 'observacion', 'det_exhum', 'resp','ci_resp', 'datoSitio',  'pago_por'));
                                            return  $pdf-> stream("preliquidacion_servicio.pdf", array("Attachment" => false));
                                        }
                                }
                        }
        }




    public function generatePDF(Request $request)
    {
        //dd("entra");

          $table = DB::table('mantenimiento')
          ->where('mantenimiento.id', $request->id)
          ->where('mantenimiento.estado', 'ACTIVO')
          ->select('mantenimiento.*')
          ->first();
          $datos_ubicacion=$table->id_ubicacion;
          $tipo_ubicacion=$table->tipo_ubicacion;
          $observacion=$table->observacion;
         // dd($datos_ubicacion);


        $sql=ResponsableDifunto::where('responsable_difunto.id',$table->respdifunto_id)
        ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
        ->select('responsable.id as id_resp','responsable.ci as ci_resp', 'responsable.nombres as nombre_resp', 'responsable.primer_apellido as paterno_resp', 'responsable.segundo_apellido as materno_resp')
        ->first();
       // dd(  $sql);

        $resp=$sql->nombre_resp. " " . $sql->paterno_resp. " ".$sql->materno_resp;
        $ci_resp=$sql->ci_resp;
        $codigo_nicho=$table->codigo_ubicacion;

        //     $sq=Nicho::where('nicho.id', '=',$datos_ubicacion )
        //     ->join('responsable_difunto1', 'responsable_difunto.codigo_nicho', '=', 'nicho.codigo')
        //     ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
        //     ->select('responsable.nombres as nombre_resp', 'responsable.primer_apellido as paterno_resp', 'responsable.segundo_apellido as materno_resp', 'responsable.ci as ci_resp', 'nicho.codigo' )->first();

        // dd($sq);

                    $arrayBusqueda = [];
                    $arrayBusqueda[] = (string)2;
                    $arrayBusqueda[] = (string)$request->fur;
                    $arrayBusquedaString = json_encode($arrayBusqueda);
                    $response = Http::asForm()->post(env('URL_SEARCH_FUR'), [

                        'buscar' => $arrayBusquedaString
                    ]);
                        $data=json_decode($response->body()) ;
        //  dd( $data->data->cobrosVarios[0]->cobrosDetalles);

                        if ($response->successful()) {
                            if($response->object()->status == true) {
                                $tableFur = $data->data->cobrosVarios[0]->cobrosDetalles;
                                $observacion= $table->observacion;

                                $pdf = PDF::setPaper('A4', 'landscape');
                                $pdf = PDF::loadView('mantenimiento/reportMant', compact('table', 'resp', 'ci_resp', 'observacion', 'tableFur', 'codigo_nicho'));
                                return  $pdf-> stream("preliquidacion_mantenimiento.pdf", array("Attachment" => false));
                            }
                    }



            }




}
