<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Mantenimiento extends Model
{
    use HasFactory;
   
    protected $table = 'mantenimiento_nicho';
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
  
    public function verificarFur($dato)
      {
        
  //dd( $servicios_cementery);
          $headers =  ['Content-Type' => 'application/json'];
          $client = new Client();
          $response = $client->post('http://192.168.104.117/cobrosnotributarios/web/index.php?r=tramites/ws-mt-comprobante-valores/busqueda', [
              'json' => [
                  'buscar' => $dato              
  
              ],
              'headers' => $headers,
          ]);
          $resp = json_decode((string) $response->getBody(), true);
        
          return $resp;
      }

}
