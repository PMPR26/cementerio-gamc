<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class Difunto extends Model
{
    use HasFactory;

    protected $table = 'difunto';
    protected $fillable = [
        'ci',
        'nombres',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'fecha_defuncion',
        'certificado_defuncion',
        'causa',
        'tipo',
        'genero',
        'certificado_file',
        'estado',
        'user_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];

public function generateCiDifunto()
{
    return DB::transaction(function () {
        $lastDifunto = Difunto::select('id')->orderBy('id', 'desc')->first();

        if ($lastDifunto) {
            $nro = $lastDifunto->id + 1;
        } else {
            $nro = 1;
        }

        $number = 'SCDI-' . str_pad($nro, 4, '0', STR_PAD_LEFT);

        // Insert the new difunto record with this generated number if needed
        // ...

        return $number;
    });
}







    public function insertDifunto($request){
        if($request->ci_dif==null ||$request->ci_dif=="" ){
            $ci_dif=$this->generateCiDifunto();
        }else{
            $ci_dif=$request->ci_dif;
        }
        $dif = new Difunto;
        $dif->ci = $ci_dif;
        $dif->ci = $ci_dif;
        $dif->nombres = trim(mb_strtoupper($request->nombres_dif, 'UTF-8'));
        $dif->primer_apellido = trim(mb_strtoupper($request->paterno_dif, 'UTF-8'));
        $dif->segundo_apellido =trim(mb_strtoupper( $request->materno_dif, 'UTF-8'));
        $dif->fecha_nacimiento = $request->fechanac_dif ?? null;
        $dif->fecha_defuncion = $request->fecha_def_dif ?? null;
        // $dif->fecha_defuncion = $request->fechadef_dif;
        $dif->certificado_defuncion = $request->sereci ?? null;
        $dif->causa = trim(mb_strtoupper($request->causa, 'UTF-8'));
        // $dif->edad = $request->edad ?? '';

        $dif->tipo = $request->tipo_dif;
        $dif->genero = $request->genero_dif;
        $dif->funeraria =trim(mb_strtoupper($request->funeraria, 'UTF-8'));
        // $dif->certificado_file = trim($request->certificado_file);
        $dif->certificado_file = $request->urlcertificacion??null;

        $dif->estado = 'ACTIVO';
        $dif->user_id = auth()->id();
        $dif->save();
        $dif->id;
        return  $dif->id;

    }




    public function updateDifunto($request, $difuntoid){
        $difunto= Difunto::where('id', $difuntoid)->first();
        if($request->ci_dif==null ||$request->ci_dif=="" ){
        }else{
            $difunto->ci=$request->ci_dif;
        }

        $difunto->nombres = trim(mb_strtoupper($request->nombres_dif, 'UTF-8'));
        $difunto->primer_apellido = trim(mb_strtoupper($request->paterno_dif, 'UTF-8'));
        $difunto->segundo_apellido =trim(mb_strtoupper( $request->materno_dif, 'UTF-8'));
        $difunto->fecha_nacimiento = $request->fechanac_dif ?? null;
        $difunto->fecha_defuncion = $request->fecha_def_dif ?? null;
        // $difunto->fecha_defuncion = $request->fechadef_dif;
        $difunto->certificado_defuncion = $request->sereci ?? null;
        $difunto->causa =  trim(mb_strtoupper($request->causa, 'UTF-8'));
        $difunto->tipo = $request->tipo_dif;
        $difunto->genero = $request->genero_dif;
        $difunto->funeraria = trim(mb_strtoupper($request->funeraria, 'UTF-8'));
        $difunto->certificado_file = trim($request->urlcertificacion);
        // $difunto->certificado_file = trim($request->url_certificacion);
        // $difunto->edad = $request->edad ?? '';
        $difunto->estado = 'ACTIVO';
        $difunto->user_id = auth()->id();
        $difunto->save();
        return $difunto->id;
    }




    public function deleteDifunto($id_difunto){
        //buscar difunto en pagos servicios
        // si esta en servicios retornar falso, no eliminar
        // si no esta en servicios  buscar en nicho y/o criptas-mausoleos
            //si esta en nichos inactivar row tabla responsable_difunto
            //si esta en criptas mausoleos, modificar columna difunto de tabla cripta_mausoleo
            //eliminar difunto

        //buscar difunto en nicho
        // si difunto esta en nicho
        //buscar difunto en cripta/mausoleo


    }

    public function searchDifunto(Request $request){
          if($request->ci_dif !=null){
                $existeDifunto=Difunto::where("ci", "=", trim($request->ci_dif))->where("estado", "=", 'ACTIVO')->orderBy('id', 'desc')
                ->first();
             }
             else if($request->fecha_def_dif== null || $request->fecha_def_dif==''){
                if($request->materno_dif==null || $request->materno_dif==''){
                    $existeDifunto =Difunto::whereRaw('nombres=\''.trim(mb_strtoupper($request->nombres_dif, 'UTF-8')).'\'')
                    ->whereRaw('primer_apellido=\''.trim(mb_strtoupper($request->paterno_dif, 'UTF-8')).'\'')
                    ->select()
                    ->first();
                }else{
                    $existeDifunto =Difunto::whereRaw('nombres=\''.trim(mb_strtoupper($request->nombres_dif, 'UTF-8')).'\'')
                    ->whereRaw('primer_apellido=\''.trim(mb_strtoupper($request->paterno_dif, 'UTF-8')).'\'')
                    ->whereRaw('segundo_apellido=\''.trim(mb_strtoupper($request->materno_dif, 'UTF-8')).'\'')
                    ->select()
                    ->first();
                }

            }else if(($request->materno_dif== null || $request->materno_dif=='') &&( $request->fecha_def_dif !='' || $request->fecha_def_dif !=null )){
                        $existeDifunto =Difunto::whereRaw('nombres=\''.trim(mb_strtoupper($request->nombres_dif, 'UTF-8')).'\'')
                    ->whereRaw('primer_apellido=\''.trim(mb_strtoupper($request->paterno_dif, 'UTF-8')).'\'')
                    ->whereRaw('fecha_defuncion=\''.trim($request->fecha_def_dif).'\'')
                    ->select()
                    ->first();
            }else{
                $existeDifunto =Difunto::whereRaw('nombres=\''.trim(mb_strtoupper($request->nombres_dif, 'UTF-8')).'\'')
                ->whereRaw('primer_apellido=\''.trim(mb_strtoupper($request->paterno_dif, 'UTF-8')).'\'')
                ->whereRaw('segundo_apellido=\''.trim(mb_strtoupper($request->materno_dif, 'UTF-8')).'\'')
                ->whereRaw('fecha_defuncion=\''.trim($request->fecha_def_dif).'\'')
                ->select()
                ->first();
            }
            return $existeDifunto;
    }
    //para armar array de listado de difuntos
    public function buscarDifunto($ci_dif, $nombres_dif, $paterno_dif, $materno_dif, $fecha_def_dif){
        if($ci_dif !=null){
            $existeDifunto=Difunto::where("ci", "=", trim($ci_dif))->where("estado", "=", 'ACTIVO')->orderBy('id', 'desc')
            ->first();
         }
         else if($fecha_def_dif== null || $fecha_def_dif==''){
            if($materno_dif==null || $materno_dif==''){
                $existeDifunto =Difunto::whereRaw('nombres=\''.trim(mb_strtoupper($nombres_dif, 'UTF-8')).'\'')
                ->whereRaw('primer_apellido=\''.trim(mb_strtoupper($paterno_dif, 'UTF-8')).'\'')
                ->select()
                ->first();
            }else{
                $existeDifunto =Difunto::whereRaw('nombres=\''.trim(mb_strtoupper($nombres_dif, 'UTF-8')).'\'')
                ->whereRaw('primer_apellido=\''.trim(mb_strtoupper($paterno_dif, 'UTF-8')).'\'')
                ->whereRaw('segundo_apellido=\''.trim(mb_strtoupper($materno_dif, 'UTF-8')).'\'')
                ->select()
                ->first();
            }

        }else if(($materno_dif== null || $materno_dif=='') &&( $fecha_def_dif !='' || $fecha_def_dif !=null )){
                    $existeDifunto =Difunto::whereRaw('nombres=\''.trim(mb_strtoupper($nombres_dif, 'UTF-8')).'\'')
                ->whereRaw('primer_apellido=\''.trim(mb_strtoupper($paterno_dif, 'UTF-8')).'\'')
                ->whereRaw('fecha_defuncion=\''.trim($fecha_def_dif).'\'')
                ->select()
                ->first();
        }else{
            $existeDifunto =Difunto::whereRaw('nombres=\''.trim(mb_strtoupper($nombres_dif, 'UTF-8')).'\'')
            ->whereRaw('primer_apellido=\''.trim(mb_strtoupper($paterno_dif, 'UTF-8')).'\'')
            ->whereRaw('segundo_apellido=\''.trim(mb_strtoupper($materno_dif, 'UTF-8')).'\'')
            ->whereRaw('fecha_defuncion=\''.trim($fecha_def_dif).'\'')
            ->select()
            ->first();
        }
        return $existeDifunto;
    }
    public function searchDifuntoByCI($ci_dif){
                if($ci_dif !=null){
                    $existeDifunto=Difunto::where("ci", "=", trim($ci_dif))->where("estado", "=", 'ACTIVO')->orderBy('id', 'desc')
                    ->first();
                }
                else {
                    $existeDifunto=null;
                }
               return $existeDifunto;
     }


    public function desvincularDifuntoCripta($ci_dif, $difuntos, $idCripta)
    {
        // dd($difuntos);
        $newdif = [];
                if(isset($difuntos))
                {
                    $dif = new Difunto;


                                    foreach($difuntos as $key => $value)
                                    {
                                                if($value['fecha_nacimiento']=="null"){
                                                        $fecha_nac=null;
                                                    }
                                                    else{
                                                        $fecha_nac=$value['fecha_nacimiento'];
                                                    }

                                                    // dd($value['ci']);
                                                    if($value['ci']!=$ci_dif){

                                                        $newdif[] = [
                                                            "ci" => $value['ci'], // Usa el valor actual de $ci_dif
                                                            "nombres" => $value['nombres'],
                                                            "primer_apellido" => $value['primer_apellido'],
                                                            "segundo_apellido" => $value['segundo_apellido'],
                                                            "ceresi" => $value['ceresi'],
                                                            "tipo" => $value['tipo'],
                                                            "fecha_nacimiento" => $fecha_nac,
                                                            "fecha_defuncion" => $value['fecha_defuncion'] ?? null,
                                                            "causa" => trim(strtoupper($value['causa'])),
                                                            "funeraria" => trim(strtoupper($value['funeraria'])),
                                                            "genero" => $value['genero'],
                                                            "url" => trim($value['url'])
                                                        ];

                                                    }
                                    }
                                    // dd($newdif);


                                    $cript=Cripta::where('id',$idCripta )->first();
                                    $cript->list_ant_difuntos= $cript->difuntos;
                                    $cript->difuntos=json_encode($newdif);
                                    $cript->save();

                                if($cript){
                                        return response([
                                            'status'=> true,
                                            'message'=> 'registro con exito..!'
                                            ],200);
                                }
                                else{
                                    return response([
                                        'status'=> false,
                                        'message'=> 'Ocurrio un error al ejecutar la transacción..!'
                                        ],201);
                                }
                    }else{
                        return response([
                            'status'=> false,
                            'message'=> 'Ocurrio un error al ejecutar la transacción..!'
                            ],201);
                    }



    }


}
