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

        $ci = Difunto::select('ci')
                ->where('ci', 'ilike', "%SCD-0%")
                ->orderBy('ci', 'DESC')
                ->first();

         if($ci){
            $number = (int) str_replace('-','',filter_var($ci, FILTER_SANITIZE_NUMBER_INT)) + 1;
            return 'SCD-'.str_pad($number, 4, '0', STR_PAD_LEFT);
         }else{
             return 'SCD-0001';
         }   
    }

    
    public function insertDifunto($request){

        $dif = new Difunto;
        $dif->ci = $request->ci_dif;
        $dif->nombres = $request->nombres_dif;
        $dif->primer_apellido = $request->paterno_dif;
        $dif->segundo_apellido = $request->materno_dif;
        $dif->fecha_nacimiento = $request->fechanac_dif;
        $dif->fecha_defuncion = $request->fechadef_dif;
        $dif->certificado_defuncion = $request->sereci;
        $dif->causa = $request->causa;
        $dif->tipo = $request->tipo_dif; 
        $dif->genero = $request->genero_dif;  
       // $dif->certificado_file=$request->adjunto;               
      //  $dif->tiempo = $request->tiempo;  
        $dif->estado = 'ACTIVO';  
        $dif->user_id = auth()->id();
        $dif->save();
        $dif->id;
        return  $dif->id;

    }

    public function updateDifunto($request, $difuntoid){
        $difunto= Difunto::where('id', $difuntoid)->first();
        $difunto->ci = $request->ci_dif;
        $difunto->nombres = $request->nombres_dif;
        $difunto->primer_apellido = $request->paterno_dif;
        $difunto->segundo_apellido = $request->materno_dif;
        $difunto->fecha_nacimiento = $request->fechanac_dif;
        $difunto->fecha_defuncion = $request->fechadef_dif;
        $difunto->certificado_defuncion = $request->sereci;
        $difunto->causa = $request->causa;
        $difunto->tipo = $request->tipo_dif; 
        $difunto->genero = $request->genero_dif;  
       // $difunto->certificado_file=$request->adjunto;       
      //  $difunto->tiempo = $request->tiempo;  
        $difunto->estado = 'ACTIVO';  
        $difunto->user_id = auth()->id();
        $difunto->save();
        return $difunto->id;
    }

}
