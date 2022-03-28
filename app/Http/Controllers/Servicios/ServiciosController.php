<?php

namespace App\Http\Controllers\Servicios;

use App\Models\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
{
    public function index(){
        
        $servicio =DB::table('servicio_nicho')
                 ->select('servicio_nicho.*', 'responsable.id as responsable_id',
                  'responsable.nombres as nombre_resp', 
                 'responsable.primer_apellido as primerap_res', 'responsable.segundo_apellido as segap_resp', 
                 'difunto.nombres as nombre_dif', 
                 'difunto.primer_apellido as primerap_dif', 'difunto.segundo_apellido as segap_dif')
                 ->join('responsable' , 'responsable.id','=', 'servicio_nicho.responsable_id')
                 ->join('difunto' , 'difunto.id','=', 'servicio_nicho.difunto_id')
                // ->where('bloque.estado', '=', 'ACTIVO')
                 ->get();
// dd($servicio);
        return view('servicios/index',['servicio' =>$servicio]);
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
