<?php

namespace App\Http\Controllers\Difunto;

use App\Models\Cripta;
use App\Models\Difunto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DifuntoController extends Controller
{
    //
    public function index(Request $request){

        $funeraria=DB::table('difunto')
                    ->select('funeraria')
                    ->whereNotNull('funeraria')
                    ->distinct()->get();

        // $difunto= DB::table('difunto')
        //         ->select('difunto.id','difunto.ci',DB::raw('CONCAT(difunto.nombres , \' \',difunto.primer_apellido, \' \', difunto.segundo_apellido ) AS nombre'),'difunto.fecha_nacimiento','difunto.fecha_defuncion','difunto.certificado_defuncion',
        //         'difunto.causa','difunto.tipo','difunto.estado','difunto.genero','difunto.funeraria', 'difunto.certificado_file')
        //         ->orderBy('id','DESC')
        //         ->get();



                $difunto = DB::table('difunto')
                ->select(
                    'difunto.id',
                    'difunto.ci',
                    DB::raw('CONCAT(difunto.nombres, \' \', difunto.primer_apellido, \' \', difunto.segundo_apellido) AS nombre'),
                    'difunto.fecha_nacimiento',
                    'difunto.fecha_defuncion',
                    'difunto.certificado_defuncion',
                    'difunto.causa',
                    'difunto.tipo',
                    'difunto.estado',
                    'difunto.genero',
                    'difunto.funeraria',
                    'difunto.certificado_file',
                    'nicho.codigo'
                )
                ->leftJoin('responsable_difunto', 'responsable_difunto.difunto_id', '=', 'difunto.id')
                ->leftJoin('nicho', 'responsable_difunto.codigo_nicho', '=', 'nicho.codigo')
                // ->where('difunto.primer_apellido', 'ILIKE', $letter . '%')
                ->where(function($query) {
                    $query->orWhere('responsable_difunto.estado', '=', 'ACTIVO')
                          ->orWhereNull('responsable_difunto.estado');
                })
                ->orderBy('difunto.id', 'DESC')
                ->get();



                // dd($difunto);
        return view('difunto/index', compact('difunto', 'funeraria'));
    }

    public function createNewDifunto(Request $request){

        if($request->isJson()){

            $this->validate($request, [
                'ci' => 'required|unique:difunto'
            ], [
                'nombres.required'  => 'El campo nombre de responsable es obligatorio!',
                'ci.required'    => 'El campo cedula de identidad es obligatorio!',
                'ci.unique' => 'El numero de cedula '.$request->ci.' ya se encuentra en uso!.'
            ]);


           $new_difunto =  Difunto::create([
            'ci' => trim($request->ci),
            'nombres' => trim(mb_strtoupper($request->nombres, 'UTF-8')),
            'primer_apellido' => trim(mb_strtoupper($request->primer_apellido ,'UTF-8')),
            'segundo_apellido' => trim(mb_strtoupper($request->segundo_apellido ,'UTF-8')),
            'fecha_nacimiento' => trim($request->fecha_nacimiento),
            'fecha_defuncion' => trim($request->fecha_defuncion),
            'certificado_defuncion' => trim($request->certificado_defuncion),
            'causa' => trim($request->causa),
            'tipo' => trim($request->tipo),
            'genero' => trim($request->genero),
            'funeraria' => trim($request->funeraria),
            'user_id' => auth()->id(),
            'certificado_file' => $request->certificado_file,
            'estado' => 'ACTIVO',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
           ]);


            return response([
                'status'=> true,
                'response'=> $new_difunto
             ],201);

        }else{

            return response([
                'status'=> false,
                'message'=> 'Error 401 (Unauthorized)'
             ],401);
        }
    }

    public function disableAndEnableDifunto($id){

        $difunto = Difunto::select()
                        ->where('id', $id)
                        ->first();

        if($difunto->estado == 'ACTIVO'){

            $disable_difunto =  Difunto::where('id', $difunto->id)
               ->update([
                   'estado' => 'INACTIVO'
               ]);

               return response([
                'status'=> true,
                'response'=> '!Difunto desactivado!'
             ],200);
        }else{
            Difunto::where([
                'id' => $difunto->id
               ])
               ->update([
                   'estado' => 'ACTIVO'
               ]);

               return response([
                'status'=> true,
                'response'=> '!Difunto Activo!'
             ],200);
        }

    }
    public function getDifunto($id){

        $difunto =  Difunto::where('id', $id)->first();

               return response([
                'status'=> true,
                'response'=> $difunto
             ],200);
    }

    public function updateDifunto(Request $request){

        $this->validate($request, [
            'ci' => 'required',
            'nombres' => 'required',
            'id' => 'required'
        ], [
            'nombres.required'  => 'El campo nombre de difunto es obligatorio!'
        ]);

        $disable_difunto =  Difunto::where('id', $request->id)
        ->update([
            'ci' => $request->ci,
            'nombres' => trim(mb_strtoupper($request->nombres,'UTF-8')),
            'primer_apellido' => trim(mb_strtoupper($request->primer_apellido,'UTF-8')),
            'segundo_apellido' => trim(mb_strtoupper($request->segundo_apellido,'UTF-8')),
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'fecha_defuncion' => $request->fecha_defuncion,
            'funeraria' => trim(mb_strtoupper($request->funeraria, 'UTF-8')),
            'certificado_file' => trim($request->url_certificacion),
            'certificado_defuncion' => $request->certificado_defuncion,
            'causa' => $request->causa,
            'tipo' => $request->tipo,
            'genero' => $request->genero,
            'estado' => $request->status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return response([
            'status'=> true,
            'response'=> 'done'
         ],200);
    }


    public function verRegistroDifunto($id_difunto){
        // dd($id_difunto);
        $band=0;
        $datos_difuntos=Difunto::where('id', $id_difunto)->first();

        //buscar difunto en pagos servicios
        $difunto_responsable=DB::table('responsable_difunto')
                             ->where('difunto_id', $id_difunto)
                             ->first();

        if($difunto_responsable != null || !empty( $difunto_responsable))
        {
            $difunto_servicio=DB::table('servicio_nicho')
            ->where('responsable_difunto_id', $difunto_responsable->difunto_id)
            ->first();


            if( $difunto_servicio!=null || !empty($difunto_servicio)){
                return response([
                    'status'=> true,
                    'response'=>  ["codigo"=>$difunto_servicio->codigo_nicho,
                             "id"=>$difunto_servicio->id,
                             "tipo"=>"servicio",
                             "ci_dif"=>$datos_difuntos->ci,
                            //  "band"=>$band

                        ]
                 ],200);
            }else{
                return response([
                    'status'=> true,
                    'response'=>["codigo"=>$difunto_responsable->codigo_nicho,
                                  "id"=>$difunto_responsable->id,
                                   "tipo"=>"nicho",
                                   "ci_dif"=>$datos_difuntos->ci,
                            //  "band"=>$band

                    ]
                 ],200);
            }

        }
        else{


            $ci= $datos_difuntos->ci;
            $dfc = Cripta::query();
            $difunto_cripta_mausoleo = $dfc->where('estado','ACTIVO')
            ->whereNotNull('difuntos')->get();
            if($difunto_cripta_mausoleo!=null || !empty($difunto_cripta_mausoleo)){


                foreach($difunto_cripta_mausoleo as $value)
                {
                    $dif=json_decode($value->difuntos, true);
                    //             echo "<pre>";
                    //  print_r($dif);
                    //  echo "</pre>";
                    foreach($dif as $difunto){
                        // dd($difunto['ci']."******".$ci);
                        if($difunto['ci']==$ci){

                            $band=1;
                            return response([
                                'status'=> true,
                                'response'=> ["codigo"=>$value->codigo,
                                               "id"=>$value->id,
                                              "tipo"=>$value->tipo_registro,
                                              "ci_dif"=>$datos_difuntos->ci,
                                              'band'=>$band
                                               ]
                             ],200);
                        }
                    }

                }
                if($band==0){
                    return response([
                        'status'=> false,
                        'mensaje'=> 'No se encontraron resultados'
                     ],201);
                }
            }
            else{

                return response([
                    'status'=> false,
                    'mensaje'=> 'No se encontraron resultados'
                 ],201);
            }
        }

        // // dd("zasdsd");
        //         return response([
        //             'status'=> false,
        //             'mensaje'=> 'Ocurrio un error, intente nuevamente'
        //          ],201);
    }

    public function eliminarDifunto(Request $request){
        //borrar primero en tablas relacionales
        // dd($request);

        if($request->tipo=="MAUSOLEO" || $request->tipo=="CRIPTA")
        {
            $d=Cripta::where('id', $request->id_tabla)->first();
            $njson=[];
           $ar_difuntos= json_decode($d->difuntos, true);
            foreach($ar_difuntos as $key=> $value){

                if($value['ci'] == $request->ci_dif){
                    unset($ar_difuntos[$key]);
                }
            }
           $d->difuntos=json_encode($ar_difuntos);
           $d->save();
        }
        else{
            if($request->id_tabla==null || $request->tipo==null){
              $del=DB::table('difunto')->where('id',$request->id_difunto)->delete();
            }
            $del=DB::table(''.$request->tbl.'')->where('id',$request->id_tabla)->delete();
        }


        $result=Difunto::where('id','=',$request->id_difunto)->delete();
        return true;
        // dd($request->tabla);


    //    return response()->json($request);
    }


}
