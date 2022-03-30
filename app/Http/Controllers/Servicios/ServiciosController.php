<?php

namespace App\Http\Controllers\Servicios;

use App\Models\Servicios;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Servicios\ServicioNicho;

class ServiciosController extends Controller{

    public function __construct()
    {
        $this->middleware('api', ['except' => ['updatePay']]);
    }


    public function index(){
        
        $servicio =DB::table('responsable_difunto')
                 ->select('responsable_difunto.*', 
                  'responsable.nombres as nombre_resp', 'responsable.primer_apellido as primerap_resp', 
                  'responsable.segundo_apellido as segap_resp',  
                  'difunto.nombres as nombre_dif', 'difunto.primer_apellido as primerap_dif', 'difunto.segundo_apellido as segap_dif',
                  'nicho.codigo',
                  'servicio_nicho.codigo_nicho', 'servicio_nicho.tipo_servicio', 'servicio_nicho.fur' )                
                 ->join('responsable' , 'responsable.id','=', 'responsable_difunto.responsable_id')
                 ->join('difunto' , 'difunto.id','=', 'responsable_difunto.difunto_id')
                 ->join('nicho' , 'nicho.codigo','=', 'responsable_difunto.codigo_nicho')
                 ->join('servicio_nicho' , 'servicio_nicho.responsable_difunto_id','=', 'responsable_difunto.id')
                 ->distinct('servicio_nicho.fur')->get();
            
                     return view('servicios/index',['servicio' =>$servicio]);
    }

    public function cargarForm(){
        
       
        return view('servicios/formRegistro');
    }

    public function buscar_nicho(Request $request){
       
        $sql=null;

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



    public function generateFur(Request $request){

        $this->validate($request, [
            'ci' => 'required',
            'nombre' => 'required',
            'primer_apellido' => 'required',
            'ap_materno' => 'max:30',
            'direccion' => 'max:200',
            'telefono' => 'max:10',
            'nombre_difunto' => 'required|max:50',
            'codigo' => 'required',
            'bloque' => 'required',
            'nicho' => 'required',
            'fila' => 'required',
            'servicios_cementery' => 'required'
        ]);

        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();
        $response = $client->post(env('URL_MULTISERVICE') . '/api/v1/cementerio/generate-fur-cementery', [
            'json' => [
                'ci' => $request->ci,
                'nombre' => $request->nombre,
                'primer_apellido' => $request->primer_apellido,
                'ap_materno' => $request->ap_materno,
                'direccion' => $request->direccion,
                'telefono' => $request->telefono,
                'nombre_difunto' => $request->nombre_difunto,
                'codigo' => $request->codigo,
                'bloque' => $request->bloque,
                'fila' => $request->fila,
                'nicho' => $request->nicho,
                'servicios_cementery' => $request->servicios_cementery
            ],
            'headers' => $headers,
        ]);
        $fur_response = json_decode((string) $response->getBody(), true);
      
        return $fur_response;
    }

    //service update pay from sinot
    public function updatePay(Request $request){
          
        if($request->isJson()){
            $this->validate($request,[
                "fur"=> 'required',
                "id_usuario_caja" => 'required'
            ]);

            $servicio = ServicioNicho::select('id', 'fur')
            ->where(['fur' => trim($request->fur), 'estado_pago' => false, 'estado' => 'ACTIVO'])
            ->first();

            if($servicio){
                NichoServicioModel::where('fur', trim($request->fur))
                ->update([      
                   'estado_pago' => true,
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





}
