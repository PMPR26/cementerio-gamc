<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


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

    public function generateCiDifunto(){
        // $ci = Difunto::select('ci')
        // ->where('ci', 'ilike', "%SCD-0%")
        // ->orderBy('ci', 'DESC')
        // ->first();

        $ci = Difunto::select('id')
               ->whereRaw('id = (select max(id) from difunto)')
                // ->where('ci', 'ilike', "%SCD-0%")
                // ->orderBy('ci', 'DESC')
                ->first();

         if($ci){
            // $text=explode('-', );
            // $number = (int) str_replace('-','',filter_var($ci, FILTER_SANITIZE_NUMBER_INT)) + 1;
            $nro=$ci->id+1;
            $number = 'SCDI-'.$nro;
            return  $number;
            // return 'SCDI-'.str_pad($number, 4, '0', STR_PAD_LEFT);
         }else{
             return 'SCD-0001';
         }
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
        $dif->certificado_file = $request->urlcertificacion;

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


}
