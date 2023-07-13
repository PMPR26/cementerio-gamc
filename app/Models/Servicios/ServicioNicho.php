<?php

namespace App\Models\Servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
     $bloque, $nicho, $fila, $servicios_cementery , $cantidades, $cajero,   $nombre_adjudicatario, $ci_adjudicatario, $observacion)
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
                  'tblobs'=>$observacion
              ],
              'headers' => $headers,
          ]);


          $fur_response = json_decode((string) $response->getBody(), true);
        //   dd( $fur_response);
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
            // $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementeryCM', [
           $response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementeryCM', [

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





}
