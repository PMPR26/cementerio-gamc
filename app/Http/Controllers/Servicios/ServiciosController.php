<?php

namespace App\Http\Controllers\Servicios;

use App\Models\Servicios;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiciosController extends Controller
{

    public function __construct()
    {
       
        $this->middleware('auth', ['except' => ['updatePay']]);

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
       
        $sql =DB::table('responsable_difunto')
        ->select('responsable_difunto.*', 
                'responsable.segundo_apellido as segap_resp',   'responsable.fecha_nacimiento as nacimiento_resp', 
                'responsable.telefono as tel_resp', 
                'responsable.celular as cel_resp', 
                'responsable.estado_civil as ecivil_resp', 
                'responsable.genero as genero_resp', 
                'responsable.email as email_resp', 
                'responsable.domicilio as domicilio_resp', 
                'difunto.ci as ci_dif',
                'difunto.nombres as nombre_dif', 'difunto.primer_apellido as primerap_dif', 'difunto.segundo_apellido as segap_dif',                 
                'difunto.segundo_apellido as segap_dif',
                'difunto.fecha_nacimiento as fecha_nac_dif',
                'difunto.fecha_defuncion as fecha_def_dif',
                'difunto.causa as causa_dif',
                'difunto.tipo as tipo_dif',
                'difunto.genero as genero_dif',
                'difunto.certificado_file as certificado_file_dif',
                'servicio_nicho.fur',
                'nicho.codigo','bloque.codigo','cuartel.codigo','nicho.nro_nicho')                
        ->leftJoin('responsable' , 'responsable.id','=', 'responsable_difunto.responsable_id')
        ->leftJoin('difunto' , 'difunto.id','=', 'responsable_difunto.difunto_id')
        ->join('nicho' , 'nicho.codigo','=', 'responsable_difunto.codigo_nicho')
        ->leftJoin('cuartel' , 'cuartel.id','=', 'nicho.cuartel_id')
        ->leftJoin('bloque' , 'bloque.id','=', 'nicho.bloque_id')
        ->where('bloque.codigo','=', $request->bloque )
        ->where('nicho.nro_nicho','=', $request->nro_nicho )
        ->where('nicho.fila','=', $request->fila ) 
        ->distinct('servicio_nicho.fur')->get();
   dd($sql);
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
