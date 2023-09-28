<?php

namespace App\Models\Servicios;

use App\Models\Nicho;
use App\Models\ResponsableDifunto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;


use Illuminate\Http\Exceptions;

class ServicioNicho extends Model
{
    use HasFactory;


    protected $table = 'servicio_nicho';

    protected $fillable = [
        'codigo_nicho',
        'fecha_registro',
        'tipo_servicio_id',
        'servicio_id',
        'servicio',
        'responsable_difunto_id',
        'fur',
        'gestion_pagada',
        'fecha_pago',
        'id_usuario_caja',
        'estado_pago',
        'user_id',
        'estado',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];


    public function GenerarFur($ci, $nombre, $primer_apellido,
    $ap_materno, $direccion, $nombre_difunto, $codigo,
     $bloque, $nicho, $fila, $servicios_cementery , $cantidades, $cajero,   $nombre_adjudicatario, $ci_adjudicatario, $observacion, $asignado, $nuevo_sitio)
     {
       // dd( $servicios_cementery);
          $headers =  ['Content-Type' => 'application/json'];
          $client = new Client();
          $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery', [
        //  $response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementery', [

              'json' => [
                  'ci' => $ci,
                  'nombre' => $nombre,
                  'primer_apellido' => $primer_apellido,
                  'ap_materno' => $ap_materno,
                  'direccion' => $direccion,
                  'nombre_difunto' => $nombre_difunto,
                  'codigo' => $codigo,
                  'bloque' => $bloque,
                  'fila' => $fila,
                  'nicho' => $nicho,
                  'servicios_cementery' => $servicios_cementery,
                  'cantidad' => $cantidades,
                  'cajero'=>$cajero,
                  'nombre_adjudicatario'=>$nombre_adjudicatario,
                  'ci_adjudicatario'=>$ci_adjudicatario,
                  'tblobs'=>$observacion,
                  'asignado'=>$asignado,
                  'nuevo_sitio'=>$nuevo_sitio

              ],
              'headers' => $headers,
          ]);

          $fur_response = json_decode((string) $response->getBody(), true);

          return $fur_response;
      }
      public function GenerarFurExterno($ci, $nombre, $primer_apellido,
      $ap_materno, $direccion, $nombre_difunto, $servicios_cementery , $cantidades, $cajero,   $nombre_adjudicatario, $ci_adjudicatario, $observacion)
       {
         // dd( $servicios_cementery);
            $headers =  ['Content-Type' => 'application/json'];
            $client = new Client();
            $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery-externo', [
          //  $response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementery', [

                'json' => [
                    'ci' => $ci,
                    'nombre' => $nombre,
                    'primer_apellido' => $primer_apellido,
                    'ap_materno' => $ap_materno,
                    'direccion' => $direccion,
                    'nombre_difunto' => $nombre_difunto,
                    'servicios_cementery' => $servicios_cementery,
                    'cantidad' => $cantidades,
                    'cajero'=>$cajero,
                    'nombre_adjudicatario'=>$nombre_adjudicatario,
                    'ci_adjudicatario'=>$ci_adjudicatario,
                    'tblobs'=>$observacion
                ],
                'headers' => $headers,
            ]);

            $fur_response = json_decode((string) $response->getBody(), true);

            return $fur_response;
        }

      public function GenerarFurCM($ci, $nombre, $primer_apellido,
      $ap_materno, $direccion, $codigo,
       $servicios_cementery , $cantidades, $cajero,  $adjudicatario, $tblobs)
        {
      //
    //   dd( $ci." ". $nombre." ". $primer_apellido." ".$ap_materno ." ".$direccion ." ".$codigo);
    //   dd( $servicios_cementery );
    //   dd($cantidades);
    //   dd($cajero." ". $adjudicatario);
    //   dd($tblobs);
            $headers =  ['Content-Type' => 'application/json'];
            $client = new Client();
             $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementeryCM', [


                'json' => [
                    'ci' => $ci,
                    'nombre' => $nombre,
                    'primer_apellido' => $primer_apellido,
                    'ap_materno' => $ap_materno,
                    'direccion' => $direccion,
                    'codigo' => $codigo,
                    'servicios_cementery' => $servicios_cementery,
                    'cantidad' => $cantidades,
                    'cajero'=>$cajero,
                    'adjudicatario'=>$adjudicatario,
                    'tblobs'=>$tblobs
                ],
                'headers' => $headers,
            ]);
            $fur_response = json_decode((string) $response->getBody(), true);
            return $fur_response;
        }



 //fur mantenimiento criptas
      public function GenerarFurCMant($ci, $nombre, $primer_apellido,
      $ap_materno, $direccion, $codigo,
       $servicios_cementery , $cantidades, $cajero,  $adjudicatario, $tblobs, $superficie)
        {

            $headers =  ['Content-Type' => 'application/json'];
            $client = new Client();
             $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementeryCMant', [
            //  $response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementeryCMant', [

                'json' => [
                    'ci' => $ci,
                    'nombre' => $nombre,
                    'primer_apellido' => $primer_apellido,
                    'ap_materno' => $ap_materno,
                    'direccion' => $direccion,
                    'codigo' => $codigo,
                    'servicios_cementery' => $servicios_cementery,
                    'cantidad' => $cantidades,
                    'cajero'=>$cajero,
                    'adjudicatario'=>$adjudicatario,
                    'tblobs'=>$tblobs,
                    'superficie'=>$superficie
                ],
                'headers' => $headers,
            ]);
            $fur_response = json_decode((string) $response->getBody(), true);
            return $fur_response;
        }


        //fur mantenimiento nichos
      public function GenerarFurMant($ci, $nombre, $primer_apellido,
      $ap_materno, $direccion, $nombre_difunto, $codigo, $bloque, $nicho, $fila,
       $servicios_cementery , $cantidades, $cajero,  $adjudicatario,$ci_adjudicatario, $tblobs)
        {

            $headers =  ['Content-Type' => 'application/json'];
            $client = new Client();
             $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementeryMant', [
            //  $response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementeryCMant', [

                'json' => [
                    'ci' => $ci,
                    'nombre' => $nombre,
                    'primer_apellido' => $primer_apellido,
                    'ap_materno' => $ap_materno,
                    'direccion' => $direccion,
                    'codigo' => $codigo,
                    'servicios_cementery' => $servicios_cementery,
                    'cantidad' => $cantidades,
                    'cajero'=>$cajero,
                    'adjudicatario'=>$adjudicatario,
                    'observacion'=>$tblobs,
                    'bloque'=>$bloque,
                    'nicho'=>$nicho,
                    'fila'=>$fila,
                    'nombre_difunto'=>$nombre_difunto,
                    'ci_adjudicatario'=>$ci_adjudicatario
                 ],
                'headers' => $headers,
            ]);
            $fur_response = json_decode((string) $response->getBody(), true);
            return $fur_response;

        }



        public function getSevHijosByFather(Request $request){
                $headers =  ['Content-Type' => 'application/json'];
                $client = new Client();
                $response = $client->post( 'https://multiserv.cochabamba.bo/api/v1/cementerio/generate-all-servicios-cm', [
               'json' => [
                        'data' => $request->data
                    ],
                    'headers' => $headers,
                ]);
                //$sevicio = json_decode((string) $response->getBody(), true);
                return $response;
        }


          //verificar pago qr
          public function verificarPagos(Request $request){
            // URL_BASE_APIPAY
            $fur=(string)$request->fur;
            // dd( $fur);

                try {
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Authorization' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6ImM0MTE5NTc1LWI1NTItNGIxOC04MDA0LTAwYmVlY2NhNGM3MCIsImlhdCI6MTY4ODE2MDE4M30.w6Cav55fRELcRSHBInz7xdIX7_yNyL95FgvAr1t7Suw',
                    ])
                        ->get(env('URL_BASE_APIPAY').'/qr/verificar', [
                            'fur'=>$fur
                        ]);

                        dd( $response->json());
                        return response([
                            'status' => false,
                            'data' => $response->json()
                        ], 200);

                } catch (RequestException $re) {
                    return response([
                        'status' => false,
                        'message' => 'Error al procesar su solicitud'
                    ], 201);
                }

            }

            public function buscarFur(Request $request) {
                $arrayBusqueda = [];
                $arrayBusqueda[] = (string)2;
                $arrayBusqueda[] = (string)$request->fur;
                $arrayBusquedaString = json_encode($arrayBusqueda);

                $url=env('URL_SEARCH_FUR');
                                // $response = Http::asForm()->post('http://192.168.104.117/cobrosnotributarios/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [

                   try{
                    $response = Http::asForm()->post($url, [
                        'buscar' => $arrayBusquedaString
                    ]);
                   // return $response->object()->data->cobrosVarios[0];

                    if ($response->successful()) {
                        if($response->object()->status == true) {
                            $dato = $response->object()->data->cobrosVarios[0];
                            return $dato;
                        }
                   }

                } catch (RequestException $e) {
                    return response([
                        'status' => false,
                        'message' => 'Error al procesar su solicitud'. $e->getMessage()
                    ], 201);
                }
            }


            public function actualizarPago(Request $request){

            }




            public function ocuparNichoTemporal($request,$difuntoid, $idresp, $codigo_n, $estado_nicho, $id_nicho){

                $nicho=New Nicho;
                $data= $nicho::where('id', $id_nicho)->first();
                $data->estado_nicho="OCUPADO";
                $data->cantidad_anterior=$data->cantidad_cuerpos;
                $data->cantidad_cuerpos=1;
                $data->save();

                //vincular con  responsable
                $rf = new ResponsableDifunto();
                $id_resp_dif=$rf->insDifuntoResp($request, $difuntoid, $idresp, $codigo_n, 'OCUPADO', $id_nicho);


                return $id_resp_dif;
            }



            public function anularServicio(Request $request){
                $data= ServicioNicho::where('id', $request->id)->first();
                $id_responsable_difunto=$data->responsable_difunto_id;
                $id_nicho=$data->ubicacion_id;
                $asignado=$data->asignado;
                $nicho=New Nicho;
                $data_nicho= $nicho::where('id',$id_nicho )->first();
                $cantidad=$data_nicho->cantidad_anterior;
                $codigo_nicho=$data_nicho->codigo;

                $resp_dif=New ResponsableDifunto;

                $verif=$this->verificarServicioAnulado($request->id);
                $result=  json_decode($verif->getContent(), true);
                   // dd( $id_responsable_difunto);
                if( $result['in']==true){
                    $est="LIBRE";
                    $estado="INACTIVO";
                    $nicho->CambiarEstadoNicho( $id_nicho,$est, $cantidad);
                    $resp_dif->revertirAnulacionRespDif( $id_responsable_difunto, $est, $estado, NULL, null, 'no_ingresar' );
                }

                if( $result['out']==true){

                    $est="OCUPADO";
                    $estado="ACTIVO";
                    $nicho=New Nicho;
                    $data_nicho= $nicho::where('id',$id_nicho )->first();
                    $cantidad=$data_nicho->cantidad_anterior;
                    $nicho->CambiarEstadoNicho( $id_nicho,$est, $cantidad);
                    if($asignado=="asignado"){
                        //buscar id responsable  nueva asignacion
                         $codigo_nicho_nuevo=$data->destino;
                         $new_respdif=New ResponsableDifunto;
                         $reg=DB::table('responsable_difunto')->where('id',$id_responsable_difunto )->first();
                         $responsable_id=$reg->responsable_id;
                         $difunto_id=$reg->difunto_id;

                         $newreg=DB::table('responsable_difunto')
                         ->where('responsable_id',$responsable_id )
                         ->where('difunto_id',$difunto_id )
                         ->where('codigo_nicho',$codigo_nicho_nuevo )
                         ->where('estado','ACTIVO')->select()->orderBy('id', 'DESC')->first();

                         //inactivar nuevo registro responsable difunto
                        $new_respdif->cambiarEstadoRespDif($newreg->id,  'INACTIVO');

                        //revertir la tupla anterior activar tupla anterior q fue inactivada
                        $old_respdif=ResponsableDifunto::where('id',$id_responsable_difunto )
                         ->where('codigo_nicho',$codigo_nicho )->first();
                        $resp_dif->revertirAnulacionRespDif(  $old_respdif->id, 'OCUPADO','ACTIVO', null, null, 'no_liberar' );
                    }
                    else{
                        $resp_dif->revertirAnulacionRespDif(  $id_responsable_difunto, 'OCUPADO','ACTIVO', null, null, 'no_liberar' );
                    }
                }

                if( $result['ren']==true){
                    $renov_ant=$data_nicho->renov_anterior;
                    $monto_renov_anterior=$data_nicho->monto_renov_anterior;
                    $nicho->restaurarRenov($id_nicho, $renov_ant,  $monto_renov_anterior);
                  }

                 $a= $this->anular_fur( $request);

                 if($a['fur_estado']== "IN"  ){
                    $data->estado="INACTIVO";
                    $data->save();
                    return response()->json(['status'=>true, 'message'=>'Se anuló el registro con exito']);
                 }
                 else{
                    return $a;
                 }
            }

            public function anularServicioExterno(Request $request){
                $data= ServicioNicho::where('id', $request->id)->first();
                $a= $this->anular_fur( $request);
                if($a['fur_estado']== "IN"  ){
                    $data->estado="INACTIVO";
                    $data->save();
                    return response()->json(['status'=>true, 'message'=>'Se anuló el registro con exito']);
                 }
                 else{
                    return $a;
                 }
            }

            function verificarServicioAnulado($id){
                $data= ServicioNicho::where('id', $id)->first();
                $services=$data->servicio_id;
              //  dd( $services);
               // $services="1999, 631";

                $servicesArray = explode(',', $services); // Convertir la cadena en un array

                $inhumaciones = array("530", "1981", "1980", "529", "623", "622", "1977", "1979", "1978", "1982");
                $exhumaciones = array("629", "631", "630", "628");
                $renovacion = array("642");
                $mant_nicho = array("525");
                $mant_cm = array("526");

                $in = array_intersect($servicesArray, $inhumaciones);
                $out = array_intersect($servicesArray, $exhumaciones);
                $ren = array_intersect($servicesArray, $renovacion);
                $mnicho = array_intersect($servicesArray, $mant_nicho);
                $mcm = array_intersect($servicesArray, $mant_cm);

                //dd($in);
                return response([
                    'in' =>  !empty($in),
                    'out' =>  !empty($out),
                    'ren' =>  !empty($ren),
                    'mnicho' => !empty($mnicho),
                    'mcm' =>  !empty($mcm)
                ], 200);

            }
            public function anular_fur(Request $request){

                // 2do si no esta pagado llamar servicio multiserv http://192.168.220.117:8006/api/v1/cementerio/anular-fur para inactivar el fur
                $headers =  ['Content-Type' => 'application/json'];
                $client = new Client();
                 $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/anular-fur', [
                //$response = $client->post( 'http://192.168.220.117:8006/api/v1/cementerio/anular-fur', [

                  'json' => [
                        'fur' => $request->fur
                    ],
                    'headers' => $headers,
                ]);

                $res = json_decode((string) $response->getBody(), true);
                return $res;
            }



}
