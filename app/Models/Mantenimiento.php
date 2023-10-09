<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class Mantenimiento extends Model
{
    use HasFactory;

    protected $table = 'mantenimiento';
    protected $fillable = [
        'id',
        'date_in', // fecha ingreso al nicho
        'gestion',
        'pagado',
        'fecha_pago',
        'fur',
        'responsable_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];


    public function anularServicio(Request $request){
        $data= Mantenimiento::where('id', $request->id)->first();

        if($request->tipo_sitio=="CRIPTA_MAUSELEO"){
            $cm= Cripta::where('id', $data->id_ubicacion)->first();
            $cm->difuntos=$cm->list_ant_difuntos;
            $cm->ultima_gestion_pagada=$cm->ult_gestion_pagada_ant;
            $cm->gestiones_pagadas=$cm->gestiones_pagadas_ant;
            $cm->save();
        }
        // else{
        //     // actualizar los datos del nicho  luego anular
        //     $ni=Nicho::where('id', $data->id_ubicacion)->first();
        //     $ni->monto_renov= $ni->monto_renov_anterior;
        //     $ni->renovacion= $ni->renov_anterior;

        // }



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
