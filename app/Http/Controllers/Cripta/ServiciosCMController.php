<?php

namespace App\Http\Controllers\Cripta;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class ServiciosCMController extends Controller
{
   
    public function index(){
        $servicio = DB::table('responsable_difunto')
            ->select(
                'responsable_difunto.*',
                'responsable.nombres as nombre_resp',
                'responsable.primer_apellido as primerap_resp',
                'responsable.segundo_apellido as segap_resp',
                'difunto.nombres as nombre_dif',
                'difunto.primer_apellido as primerap_dif',
                'difunto.segundo_apellido as segap_dif',
                'cripta_mausoleo.codigo',
                'servicio_nicho.codigo_nicho',
                'servicio_nicho.tipo_servicio',
                'servicio_nicho.servicio',
                'servicio_nicho.fur',
                'servicio_nicho.monto',
                'servicio_nicho.nombrepago',
                'servicio_nicho.paternopago',
                'servicio_nicho.maternopago',
                'servicio_nicho.estado_pago',
                'servicio_nicho.id as serv_id'
            )
            ->join('responsable', 'responsable.id', '=', 'responsable_difunto.responsable_id')
            ->join('difunto', 'difunto.id', '=', 'responsable_difunto.difunto_id')
            ->join('cripta_mausoleo', 'cripta_mausoleo.codigo', '=', 'responsable_difunto.codigo_nicho')
            ->join('servicio_nicho', 'servicio_nicho.responsable_difunto_id', '=', 'responsable_difunto.id')
            ->where('servicio_nicho.estado','ACTIVO')
            ->orderBy('servicio_nicho.id', 'DESC')
            ->get();

            $funeraria=DB::table('difunto')
            ->select('funeraria')
            ->whereNotNull('funeraria')
            ->distinct()->get();
    
            $causa=DB::table('difunto')
            ->select('causa')
            ->whereNotNull('causa')
            ->distinct()->get();

        return view('cripta/servCM', ['tipo_service' => $servicio, 'funeraria' => $funeraria, 'causa' => $causa]);
    }


}
