<?php

namespace App\Models\Servicios;

use App\Models\Nicho;
use App\Models\ResponsableDifunto;
use App\Models\Cripta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log;

use PDF;


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

    public function GenerarFurDeposito(
        $ci,
        $nombre,
        $primer_apellido,
        $ap_materno,
        $nombre_difunto,
        $cuartel,
        $bloque,
        $nicho,
        $fila,
        $cuenta,
        $precio,
        $descripcion,
        $num_sec,
        $cantidades,
        $monto,
        $cajero,
        $nombre_adjudicatario,
        $ci_adjudicatario,
        $glosa
    ) {
        // dd( $servicios_cementery);
        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();
        $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery-deposito', [
            // $response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementery', [

            'json' => [
                'ci' => $ci,
                'nombre' => $nombre,
                'primer_apellido' => $primer_apellido,
                'ap_materno' => $ap_materno,
                'nombre_difunto' => $nombre_difunto,
                'cuartel' => $cuartel,
                'bloque' => $bloque,
                'nicho' => $nicho,
                'fila' => $fila,
                'cuenta' => $cuenta,
                'precio' => $precio,
                'descripcion' => $descripcion,
                'num_sec' => $num_sec,
                'cantidad' => $cantidades,
                'monto' => $monto,
                'cajero' => $cajero,
                'nombre_adjudicatario' => $nombre_adjudicatario,
                'ci_adjudicatario' => $ci_adjudicatario,
                'glosa' => $glosa
            ],
            'headers' => $headers,
        ]);

        $fur_response = json_decode((string) $response->getBody(), true);

        return $fur_response;
    }
    public function GenerarFur(
        $ci,
        $nombre,
        $primer_apellido,
        $ap_materno,
        $direccion,
        $nombre_difunto,
        $codigo,
        $bloque,
        $nicho,
        $fila,
        $servicios_cementery,
        $cantidades,
        $servicio_montos,
        $cajero,
        $nombre_adjudicatario,
        $ci_adjudicatario,
        $observacion,
        $asignado,
        $nuevo_sitio
    ) {
        // dd( $servicios_cementery);
        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();
        $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery', [
            // $response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementery', [

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
                'montos' => $servicio_montos,
                'cajero' => $cajero,
                'nombre_adjudicatario' => $nombre_adjudicatario,
                'ci_adjudicatario' => $ci_adjudicatario,
                'tblobs' => $observacion,
                'asignado' => $asignado,
                'nuevo_sitio' => $nuevo_sitio

            ],
            'headers' => $headers,
        ]);

        $fur_response = json_decode((string) $response->getBody(), true);

        return $fur_response;
    }
    public function GenerarFurExterno(
        $ci,
        $nombre,
        $primer_apellido,
        $ap_materno,
        $direccion,
        $nombre_difunto,
        $servicios_cementery,
        $cantidades,
        $cajero,
        $nombre_adjudicatario,
        $ci_adjudicatario,
        $observacion
    ) {
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
                'cajero' => $cajero,
                'nombre_adjudicatario' => $nombre_adjudicatario,
                'ci_adjudicatario' => $ci_adjudicatario,
                'tblobs' => $observacion
            ],
            'headers' => $headers,
        ]);

        $fur_response = json_decode((string) $response->getBody(), true);

        return $fur_response;
    }

    public function GenerarFurCM(
        $ci,
        $nombre,
        $primer_apellido,
        $ap_materno,
        $direccion,
        $codigo,
        $servicios_cementery,
        $cantidades,
        $cajero,
        $adjudicatario,
        $tblobs,
        $asignado,
        $nuevo_sitio,
        $nombre_difunto
    ) {

        //   dd( $ci." ". $nombre." ". $primer_apellido." ".$ap_materno ." ".$direccion ." ".$codigo);
        //   dd( $servicios_cementery );
        //   dd($cantidades);
        //   dd($cajero." ". $adjudicatario);
        //   dd($nombre_difunto . "llego ...");
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
                'cajero' => $cajero,
                'adjudicatario' => $adjudicatario,
                'tblobs' => $tblobs,
                'asignado' => $asignado,
                'nuevo_sitio' => $nuevo_sitio,
                'nombre_difunto' => $nombre_difunto
            ],
            'headers' => $headers,
        ]);
        $fur_response = json_decode((string) $response->getBody(), true);
        return $fur_response;
    }



    //fur mantenimiento criptas
    public function GenerarFurCMant(
        $ci,
        $nombre,
        $primer_apellido,
        $ap_materno,
        $direccion,
        $codigo,
        $servicios_cementery,
        $cantidades,
        $cajero,
        $adjudicatario,
        $tblobs,
        $superficie,
        $cuartel,
        $bloque,
        $sitio,
        $tipo
    ) {

        //  dd($cuartel."-".$bloque."-".$sitio);
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
                'cajero' => $cajero,
                'adjudicatario' => $adjudicatario,
                'tblobs' => $tblobs,
                'superficie' => $superficie,
                'cuartel' => $cuartel,
                'bloque' => $bloque,
                'sitio' => $sitio,
                'tipo' => $tipo,
            ],
            'headers' => $headers,
        ]);
        $fur_response = json_decode((string) $response->getBody(), true);
        // dd($fur_response);
        return $fur_response;
    }


    //fur mantenimiento nichos
    public function GenerarFurMant(
        $ci,
        $nombre,
        $primer_apellido,
        $ap_materno,
        $direccion,
        $nombre_difunto,
        $codigo,
        $bloque,
        $nicho,
        $fila,
        $servicios_cementery,
        $cantidades,
        $cajero,
        $adjudicatario,
        $ci_adjudicatario,
        $tblobs
    ) {

        //dd($cajero);
        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();
        $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementeryMant', [
            //$response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementeryMant', [

            'json' => [
                'ci' => $ci,
                'nombre' => $nombre,
                'primer_apellido' => $primer_apellido,
                'ap_materno' => $ap_materno,
                'direccion' => $direccion,
                'codigo' => $codigo,
                'servicios_cementery' => $servicios_cementery,
                'cantidad' => $cantidades,
                'cajero' => $cajero,
                'adjudicatario' => $adjudicatario,
                'observacion' => $tblobs,
                'bloque' => $bloque,
                'nicho' => $nicho,
                'fila' => $fila,
                'nombre_difunto' => $nombre_difunto,
                'ci_adjudicatario' => $ci_adjudicatario,
            ],
            'headers' => $headers,
        ]);
        $fur_response = json_decode((string) $response->getBody(), true);
        return $fur_response;
    }



    public function getSevHijosByFather(Request $request)
    {
        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();
        $response = $client->post('https://multiserv.cochabamba.bo/api/v1/cementerio/generate-all-servicios-cm', [
            'json' => [
                'data' => $request->data
            ],
            'headers' => $headers,
        ]);
        //$sevicio = json_decode((string) $response->getBody(), true);
        return $response;
    }


    //verificar pago qr
    public function verificarPagos(Request $request)
    {
        // URL_BASE_APIPAY
        $fur = (string)$request->fur;
        // dd( $fur);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6ImM0MTE5NTc1LWI1NTItNGIxOC04MDA0LTAwYmVlY2NhNGM3MCIsImlhdCI6MTY4ODE2MDE4M30.w6Cav55fRELcRSHBInz7xdIX7_yNyL95FgvAr1t7Suw',
            ])
                ->get(env('URL_BASE_APIPAY') . '/qr/verificar', [
                    'fur' => $fur
                ]);

            // dd( $response->json());
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

    public function buscarFur(Request $request)
    {
        $arrayBusqueda = [];
        $arrayBusqueda[] = (string)2;
        $arrayBusqueda[] = (string)$request->fur;
        $arrayBusquedaString = json_encode($arrayBusqueda);

        $url = env('URL_SEARCH_FUR');
        // $response = Http::asForm()->post('http://192.168.104.117/cobrosnotributarios/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [

        try {
            $response = Http::asForm()->post($url, [
                'buscar' => $arrayBusquedaString
            ]);
            // return $response->object()->data->cobrosVarios[0];

            if ($response->successful()) {
                if ($response->object()->status == true) {
                    $dato = $response->object()->data->cobrosVarios[0];
                    return $dato;
                }
            }
        } catch (RequestException $e) {
            return response([
                'status' => false,
                'message' => 'Error al procesar su solicitud' . $e->getMessage()
            ], 201);
        }
    }


    public function ocuparNichoTemporal($request, $difuntoid, $idresp, $codigo_n, $estado_nicho, $id_nicho)
    {

        $nicho = new Nicho;
        $data = $nicho::where('id', $id_nicho)->first();
        $data->estado_nicho = "OCUPADO";
        $data->cantidad_anterior = $data->cantidad_cuerpos;
        $data->cantidad_cuerpos = 1;
        $data->save();

        //vincular con  responsable
        $rf = new ResponsableDifunto();
        $id_resp_dif = $rf->insDifuntoResp($request, $difuntoid, $idresp, $codigo_n, 'OCUPADO', $id_nicho);


        return $id_resp_dif;
    }



    public function anularServicio(Request $request)
    {
        $data = ServicioNicho::where('id', $request->id)->first();
        $id_responsable_difunto = $data->responsable_difunto_id;
        $id_nicho = $data->ubicacion_id;
        $asignado = $data->asignado;
        $destino = $data->destino;


        // volver a los valores anteriores el nicho liberado
        $nicho = new Nicho;
        $data_nicho = $nicho::where('id', $id_nicho)->first();
        $cantidad = $data_nicho->cantidad_anterior;
        $codigo_nicho = $data_nicho->codigo;


        $resp_dif = new ResponsableDifunto;

        $verif = $this->verificarServicioAnulado($request->id);
        $result =  json_decode($verif->getContent(), true);

        if ($asignado == "asignado") {
            $data_nicho->cantidad_cuerpos = $cantidad;
            $data_nicho->estado_nicho = "OCUPADO";
            $data_nicho->save();

            $resp_dif_nicho_origen = ResponsableDifunto::where('codigo_nicho', $data->codigo_nicho)->orderBy('id', 'DESC')->first();

            $resp_dif_nicho_origen->estado = 'ACTIVO';
            $resp_dif_nicho_origen->save();

            $nicho_destino = Nicho::where('codigo', $destino)->where('estado', 'ACTIVO')->first();
            // dd( $nicho_destino);

            $nicho_destino->cantidad_cuerpos = $nicho_destino->cantidad_cuerpos - 1;
            if ($nicho_destino->cantidad_cuerpos < 1) {
                $nicho_destino->estado_nicho = "LIBRE";
            }

            $nicho_destino->save();

            $resp_dif_nicho_destino = ResponsableDifunto::where('codigo_nicho', $data->destino)->orderBy('id', 'DESC')->first();
            // dd($resp_dif_nicho_destino);
            $resp_dif_nicho_destino->estado = 'INACTIVO';
            $resp_dif_nicho_destino->save();
        } else {
            if ($result['in'] == true) {
                $est = "LIBRE";
                $estado = "INACTIVO";
                $nicho->CambiarEstadoNicho($id_nicho, $est, $cantidad);
                $resp_dif->revertirAnulacionRespDif($id_responsable_difunto, $est, $estado, NULL, null, 'no_ingresar');
            }

            if ($result['out'] == true) {
                $est = "OCUPADO";
                $estado = "ACTIVO";
                $nicho = new Nicho;
                $data_nicho = $nicho::where('id', $id_nicho)->first();
                $cantidad = $data_nicho->cantidad_anterior;
                $nicho->CambiarEstadoNicho($id_nicho, $est, $cantidad);
                if ($asignado == "asignado") {
                    //buscar id responsable  nueva asignacion
                    $codigo_nicho_nuevo = $data->destino;
                    $new_respdif = new ResponsableDifunto;
                    $reg = DB::table('responsable_difunto')->where('id', $id_responsable_difunto)->first();
                    $responsable_id = $reg->responsable_id;
                    $difunto_id = $reg->difunto_id;

                    $newreg = DB::table('responsable_difunto')
                        ->where('responsable_id', $responsable_id)
                        ->where('difunto_id', $difunto_id)
                        ->where('codigo_nicho', $codigo_nicho_nuevo)
                        ->where('estado', 'ACTIVO')->select()->orderBy('id', 'DESC')->first();

                    //inactivar nuevo registro responsable difunto
                    $new_respdif->cambiarEstadoRespDif($newreg->id,  'INACTIVO');

                    //revertir la tupla anterior activar tupla anterior q fue inactivada
                    $old_respdif = ResponsableDifunto::where('id', $id_responsable_difunto)
                        ->where('codigo_nicho', $codigo_nicho)->first();
                    $resp_dif->revertirAnulacionRespDif($old_respdif->id, 'OCUPADO', 'ACTIVO', null, null, 'no_liberar');
                } else {
                    $resp_dif->revertirAnulacionRespDif($id_responsable_difunto, 'OCUPADO', 'ACTIVO', null, null, 'no_liberar');
                }
            }

            if ($result['ren'] == true) {
                $id = $request->id;

                    // Buscar el registro por ID
                    $servicioNicho = ServicioNicho::find($id);

                    if ($servicioNicho) {
                        // Actualizar el estado a 'INACTIVO'
                        $servicioNicho->estado = 'INACTIVO';
                        $servicioNicho->save();
                    }

            }
        }
        $a = $this->anular_fur($request);

        if ($a['fur_estado'] == "IN") {
            $data->estado = "INACTIVO";
            $data->save();
            return response()->json(['status' => true, 'message' => 'Se anuló el registro con exito']);
        } else {
            return $a;
        }
    }

    public function anularServicioExterno(Request $request)
    {
        $data = ServicioNicho::where('id', $request->id)->first();
        $a = $this->anular_fur($request);
        if ($a['fur_estado'] == "IN" || $request->fur == 0) {
            $data->estado = "INACTIVO";
            $data->save();
            return response()->json(['status' => true, 'message' => 'Se anuló el registro con exito']);
        } else {
            return $a;
        }
    }

    public function anularServicioCM(Request $request)
    {
        $data = ServicioNicho::where('id', $request->id)->first();
        $cm = Cripta::where('id', $data->ubicacion_id)->first();
        // dd($cm);
        if ($cm->list_ant_difuntos != null || $cm->list_ant_difuntos != "") {
            $cm->difuntos = $cm->list_ant_difuntos;
        }

        if ($cm->ult_gestion_pagada_ant != null || $cm->ult_gestion_pagada_ant != "") {
            $cm->ultima_gestion_pagada = $cm->ult_gestion_pagada_ant;
        }


        if ($cm->gestiones_pagadas_ant != null || $cm->gestiones_pagadas_ant != "") {
            $cm->gestiones_pagadas = $cm->gestiones_pagadas_ant;
        }

        $cm->save();

        if ($data->asignado == "asignado") {
            $rd = ResponsableDifunto::where('id', $data->responsable_difunto_id)
                ->where('estado', 'ACTIVO')
                ->whereDate('created_at', '=', date('Y-m-d', strtotime($data->created_at)))
                ->first();
            if (!empty($rd)) {
                $rd->estado = 'INACTIVO';
                $rd->save();
            }

            //ACTUALIZAR EL NICHO OCUPADO
            $n = Nicho::where('codigo', $data->destino)
                ->where('estado', 'ACTIVO')
                ->update(['cantidad_cuerpos' => \DB::raw('cantidad_cuerpos - 1')]);
        }

        $a = $this->anular_fur($request);

        if ($a['fur_estado'] == "IN") {
            $data->estado = "INACTIVO";
            $data->save();
            return response()->json(['status' => true, 'message' => 'Se anuló el registro con exito']);
        } else {
            return $a;
        }
    }

    public function verificarServicioAnulado($id)
    {
        $data = ServicioNicho::where('id', $id)->first();
        $services = $data->servicio_id;
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
    public function anular_fur(Request $request)
    {

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


    //fur para tasas por  otros servicios
    public function GenerarFurServicios(
        $ci,
        $nombre,
        $primer_apellido,
        $ap_materno,
        $direccion,
        $codigo,
        $bloque,
        $nicho,
        $fila,
        $servicios_cementery,
        $cantidades,
        $cajero,
        $adjudicatario,
        $ci_adjudicatario,
        $tblobs
    ) {

        //dd($cajero);
        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();
        $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery-serv', [
            //$response = $client->post('http://192.168.220.117:8006/api/v1/cementerio/generate-fur-cementeryMant', [

            'json' => [
                'ci' => $ci,
                'nombre' => $nombre,
                'primer_apellido' => $primer_apellido,
                'ap_materno' => $ap_materno,
                'direccion' => $direccion,
                'codigo' => $codigo,
                'servicios_cementery' => $servicios_cementery,
                'cantidad' => $cantidades,
                'cajero' => $cajero,
                'adjudicatario' => $adjudicatario,
                'observacion' => $tblobs,
                'bloque' => $bloque,
                'nicho' => $nicho,
                'fila' => $fila,
                'ci_adjudicatario' => $ci_adjudicatario,
            ],
            'headers' => $headers,
        ]);
        $fur_response = json_decode((string) $response->getBody(), true);
        return $fur_response;
    }

    // public function verificarRenovacion(Request $request) {
    //     $codigo_nicho = $request->cuartel . "." . $request->bloque . "." . $request->nro_nicho . "." . $request->fila;
    //     // dd($$codigo_nicho);

    //     $year = date('Y'); // Obtén el año actual

    //     // try {
    //         // Consulta usando Eloquent con whereRaw para manejar correctamente los valores vacíos
    //         $result = ServicioNicho::where('codigo_nicho1', $codigo_nicho)
    //                     ->whereNotNull('nro_renovacion')
    //                     ->where('nro_renovacion', '>', 0)
    //                     ->where('estado_pago', 1)
    //                     ->where('estado', 'ACTIVO')
    //                     ->whereYear('fecha_pago', $year)
    //                     ->get();


    //         if($result->isNotEmpty()){
    //             return response()->json(['status' => true, 'mensaje' => 'El nicho ya tiene renovación activa', 'codigo_nicho'=>$codigo_nicho, 'result'=>$result]);
    //         } else {
    //             return response()->json(['status' => false, 'mensaje' => 'El nicho no tiene renovación activa', 'codigo_nicho'=>$codigo_nicho,]);
    //         }

    //     // } catch (Exception $e) {
    //     //     // Manejo de errores
    //     //     Log::error("Error en verificarRenovacion: " . $e->getMessage());
    //     //     return response()->json(['error' => 'Error al verificar la renovación'], 500);
    //     // }
    // }

    public function verificarRenovacion(Request $request) {
        $codigo_nicho = $request->cuartel . "." . $request->bloque . "." . $request->nro_nicho . "." . $request->fila;

        $year = date('Y'); // Obtén el año actual

        // try {
            // Consulta usando Eloquent
            $result = ServicioNicho::where('codigo_nicho', $codigo_nicho)
            ->whereNotNull('nro_renovacion')
            ->Orwhere('nro_renovacion', '>', 0)
            ->where('estado', 'ACTIVO')
            ->whereYear('fecha_pago', $year)
            ->select('estado_pago')
            ->orderByDesc('id')
            ->first();

            // Depura para verificar qué está devolviendo la consulta
            // dd($result);

            if($result) {
                if($result->estado_pago == true) {
                    return response()->json([
                        'status' => true,
                        'mensaje' => 'El nicho ya tiene renovación activa',
                        'codigo_nicho' => $codigo_nicho,
                        'result' => $result
                    ]);
                }else{
                    return response()->json([
                        'status' => true,
                        'mensaje' => 'El nicho tiene renovación pendiente de pago',
                        'codigo_nicho' => $codigo_nicho,
                        'result' => $result
                    ]);
                }

            } else {
                return response()->json([
                    'status' => false,
                    'mensaje' => 'El nicho no tiene renovación activa',
                    'codigo_nicho' => $codigo_nicho
                ]);
            }

        // } catch (Exception $e) {
        //     // Manejo de errores
        //     Log::error("Error en verificarRenovacion: " . $e->getMessage());
        //     return response()->json(['error' => 'Error al verificar la renovación'], 500);
        // }
    }

}
