<?php

namespace App\Http\Controllers\Servicios;

use App\Models\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
{
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
}
