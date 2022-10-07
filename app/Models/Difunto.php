<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
            $number = (int) str_replace('-','',filter_var($ci, FILTER_SANITIZE_NUMBER_INT)) + 1;
            return 'SCDI-'.str_pad($number, 4, '0', STR_PAD_LEFT);
         }else{
             return 'SCD-0001';
         }
    }


    public function insertDifunto($request){
        if($request->ci_dif==null ||$request->ci_dif=="" ){
            $ci_resp=$this->generateCiDifunto();
        }else{
            $ci_dif=$request->ci_dif;
        }
        $dif = new Difunto;
        $dif->ci = $ci_dif;
        $dif->nombres = $request->nombres_dif;
        $dif->primer_apellido = $request->paterno_dif;
        $dif->segundo_apellido = $request->materno_dif;
        $dif->fecha_nacimiento = $request->fechanac_dif;
        $dif->fecha_defuncion = $request->fechadef_dif;
        $dif->certificado_defuncion = $request->sereci;
        $dif->causa = $request->causa;
        $dif->edad = $request->edad ?? '';

        $dif->tipo = $request->tipo_dif;
        $dif->genero = $request->genero_dif;
        $dif->funeraria = trim($request->funeraria);
        $dif->certificado_file = trim($request->certificado_file);
        $dif->estado = 'ACTIVO';
        $dif->user_id = auth()->id();
        $dif->save();
        $dif->id;
        return  $dif->id;

    }

    public function updateDifunto($request, $difuntoid){
        if($request->ci_dif==null ||$request->ci_dif=="" ){
            $ci_dif=$this->generateCiDifunto();
        }else{
            $ci_dif=$request->ci_dif;
        }
        $difunto= Difunto::where('id', $difuntoid)->first();
        $difunto->ci = $ci_dif;
        $difunto->nombres = $request->nombres_dif;
        $difunto->primer_apellido = $request->paterno_dif;
        $difunto->segundo_apellido = $request->materno_dif;
        $difunto->fecha_nacimiento = $request->fechanac_dif;
        $difunto->fecha_defuncion = $request->fechadef_dif;
        $difunto->certificado_defuncion = $request->sereci;
        $difunto->causa = $request->causa;
        $difunto->tipo = $request->tipo_dif;
        $difunto->genero = $request->genero_dif;
        $difunto->funeraria = trim($request->funeraria);
        $difunto->certificado_file = trim($request->url_certificacion);
        $difunto->edad = $request->edad ?? '';

       // $difunto->certificado_file=$request->adjunto;
      //  $difunto->tiempo = $request->tiempo;
        $difunto->estado = 'ACTIVO';
        $difunto->user_id = auth()->id();
        $difunto->save();
        return $difunto->id;
    }

}
