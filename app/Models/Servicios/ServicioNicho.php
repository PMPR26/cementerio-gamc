<?php

namespace App\Models\Servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
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
     $bloque, $nicho, $fila, $servicios_cementery , $cantidades, $cajero, $desc_exhum,  $nombre_adjudicatario, $ci_adjudicatario)
     {


// dd( $servicios_cementery);
          $headers =  ['Content-Type' => 'application/json'];
          $client = new Client();
        //   $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery', [
         $response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementery', [

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
                  'desc_exhum'=>$desc_exhum,
                  'nombre_adjudicatario'=>$nombre_adjudicatario,
                  'ci_adjudicatario'=>$ci_adjudicatario
              ],
              'headers' => $headers,
          ]);


          $fur_response = json_decode((string) $response->getBody(), true);
        //   dd( $fur_response);
          return $fur_response;
      }


      public function GenerarFurCM($ci, $nombre, $primer_apellido,
      $ap_materno, $direccion, $codigo,
       $servicios_cementery , $cantidades, $cajero, $desc_exhum, $adjudicatario)
        {
      //   dd( $desc_exhum)
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
                    'desc_exhum'=>$desc_exhum,
                    'adjudicatario'=>$adjudicatario
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



}
