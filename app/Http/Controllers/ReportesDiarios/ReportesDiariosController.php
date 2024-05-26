<?php

namespace App\Http\Controllers\ReportesDiarios;

use App\Http\Controllers\Controller;
use App\Models\Mantenimiento;
use App\Models\Servicios\ServicioNicho;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use PDF;

class ReportesDiariosController extends Controller
{
    //
    public function index(){
        return view('reportes_diarios/form_report');
    }

    public function generadorReport(Request $request){
        $validator = Validator::make($request->all(), [
            'tipo_reporte' => ['required'],
            'frecuencia' => ['required']
            ],[
                'tipo_reporte.required' => 'El tipo de reporte es requerido',
                'frecuencia.required' => 'La frecuencia es requerida'
            ]);
        $fecha = $request->fecha;
        $fecha_inicial = $request->fecha_inicial;
        $fecha_final = $request->fecha_final;
        $tipo_reporte=$request->tipo_reporte;
        $frecuencia=$request->frecuencia;

        if($tipo_reporte=='SERVICIOS' && $frecuencia=='DIARIO'){
          return($this->serviciosDiarios($fecha,null, null));
        }
        elseif($tipo_reporte=='SERVICIOS' && $frecuencia=='RANGO'){
            return($this->serviciosDiarios(null,$fecha_inicial,$fecha_final));
        }
        elseif($tipo_reporte=='MANTENIMIENTO' && $frecuencia=='DIARIO'){
            return($this->mantenimientosDiarios($fecha,null, null));
        }
        elseif($tipo_reporte=='MANTENIMIENTO' && $frecuencia=='RANGO'){
            return($this->mantenimientosDiarios(null,$fecha_inicial,$fecha_final));
        }


    }
    public function serviciosDiarios($fecha, $fecha_inicial, $fecha_final){
        // Establecer el huso horario a Bolivia
        date_default_timezone_set('America/La_Paz');
        // Obtener la fecha actual
        // Obtener la fecha actual de Bolivia
        $fechaBolivia = Carbon::now()->toDateString(); // Obtener solo la fecha sin la hora
       if($fecha != null){

          // Realizar la consulta
          $servicios = ServicioNicho::whereDate('created_at', $fecha) // Utilizar whereDate para comparar solo la fecha
          ->where('estado', 'ACTIVO')
          ->select('codigo_nicho','fur', 'monto','servicio', \DB::raw("CONCAT(nombrepago, ' ', paternopago, ' ', maternopago) AS nombre_completo"),
          'estado_pago','pago_por','observacion','created_at') // Utilizar \DB::raw para concatenar columnas
          ->get();


       }
       elseif($fecha_inicial != null && $fecha_final != null){

            // Realizar la consulta
            $fecha_final_carbon = Carbon::parse($fecha_final)->addDay();
            $fecha_inicial_carbon = Carbon::parse($fecha_inicial)->addDay();


            // Realizar la consulta
            $servicios = ServicioNicho::whereBetween('created_at', [$fecha_inicial_carbon, $fecha_final_carbon])
                ->where('estado', 'ACTIVO')
            ->where('estado', 'ACTIVO')
            ->select('codigo_nicho', 'fur','monto', 'servicio', \DB::raw("CONCAT(nombrepago, ' ', paternopago, ' ', maternopago) AS nombre_completo"),
                'estado_pago', 'pago_por', 'observacion', 'created_at')
            ->get();
       }
       else{
        $servicios = ServicioNicho::whereDate('created_at', $fechaBolivia) // Utilizar whereDate para comparar solo la fecha
        ->where('estado', 'ACTIVO')
        ->select('codigo_nicho','fur','monto', 'servicio', \DB::raw("CONCAT(nombrepago, ' ', paternopago, ' ', maternopago) AS nombre_completo"),
        'estado_pago','pago_por','observacion','created_at') // Utilizar \DB::raw para concatenar columnas
        ->get();

       }



               $pdf = new PDF();
               $pdf = PDF::loadView('reportes_diarios/reporteDiarioServicios', compact('servicios'))->setPaper('a4', 'landscape');
               return  $pdf-> stream("servicios_diarios_".$fechaBolivia.".pdf", array("Attachment" => false));

    }

    public function mantenimientosDiarios($fecha, $fecha_inicial, $fecha_final){
        // Establecer el huso horario a Bolivia
        date_default_timezone_set('America/La_Paz');
        // Obtener la fecha actual
        // Obtener la fecha actual de Bolivia
        $fechaBolivia = Carbon::now()->toDateString(); // Obtener solo la fecha sin la hora
       if($fecha != null){

            // Realizar la consulta
            $mantenimiento = Mantenimiento::whereDate('created_at', $fecha) // Utilizar whereDate para comparar solo la fecha
            ->where('estado', 'ACTIVO')
            ->select('codigo_ubicacion','fur', 'desc_servicio as servicio','cantidad_gestiones',
            'monto', \DB::raw("CONCAT(nombrepago, ' ', paternopago, ' ', maternopago) AS nombre_completo"),
            'pagado','pago_por','observacion','created_at') // Utilizar \DB::raw para concatenar columnas
            ->get();
            }
            elseif($fecha_inicial != null && $fecha_final != null){

                // Realizar la consulta
                $fecha_final_carbon = Carbon::parse($fecha_final)->addDay();
                $fecha_inicial_carbon = Carbon::parse($fecha_inicial)->addDay();
                // Realizar la consulta
                $mantenimiento =  Mantenimiento::whereBetween('created_at', [$fecha_inicial_carbon, $fecha_final_carbon])
                ->where('estado', 'ACTIVO')
                ->select('codigo_ubicacion','fur', 'desc_servicio as servicio','cantidad_gestiones',
                'monto', \DB::raw("CONCAT(nombrepago, ' ', paternopago, ' ', maternopago) AS nombre_completo"),
                'pagado','pago_por','observacion','created_at') // Utilizar \DB::raw para concatenar columnas
                ->get();
            } else{
                $mantenimiento = Mantenimiento::whereDate('created_at', $fechaBolivia) // Utilizar whereDate para comparar solo la fecha
                ->where('estado', 'ACTIVO')
                ->select('codigo_ubicacion','fur', 'desc_servicio as servicio','cantidad_gestiones',
                'monto', \DB::raw("CONCAT(nombrepago, ' ', paternopago, ' ', maternopago) AS nombre_completo"),
                'pagado','pago_por','observacion','created_at') // Utilizar \DB::raw para concatenar columnas
                ->get();
            }

               $pdf = new PDF();
               $pdf = PDF::loadView('reportes_diarios/reporteDiarioMantenimiento', compact('mantenimiento'))->setPaper('a4', 'landscape');
               return  $pdf-> stream("mantenimiento_diarios_".$fechaBolivia.".pdf", array("Attachment" => false));

    }
}
