<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;

    protected $table = 'responsable';
    protected $fillable = [
        'ci',
        'nombres',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'telefono',
        'celular',
        'estado_civil',
        'genero',
        'email',
        'domicilio',
        'estado',
        'user_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];


    //generate ci reposnsable
    public function generateCiResponsable(){

        $ci = Responsable::select('ci')
                ->where('ci', 'ilike', "%SCR-0%")
                ->orderBy('ci', 'DESC')
                ->first();

         if($ci){
            $number = (int) str_replace('-','',filter_var($ci, FILTER_SANITIZE_NUMBER_INT)) + 1;
            return 'SCR-'.str_pad($number, 4, '0', STR_PAD_LEFT);
         }else{
             return 'SCR-0001';
         }   
    }

    public function insertResponsable($request){

        $responsable = new Responsable;
        $responsable->ci = $request->ci_resp;
        $responsable->nombres = $request->nombres_resp;
        $responsable->primer_apellido = $request->paterno_resp;
        $responsable->segundo_apellido = $request->materno_resp;
        $responsable->fecha_nacimiento = $request->fechanac_resp;
        $responsable->genero = $request->genero_resp;  
        $responsable->telefono = $request->telefono;  
        $responsable->celular = $request->celular;  
        $responsable->estado_civil = $request->ecivil;  
        $responsable->domicilio = $request->domicilio; 
        $responsable->email = $request->email;  
        $responsable->estado = 'ACTIVO';  
        $responsable->user_id = auth()->id();
        $responsable->save();
        $responsable->id;
        return  $responsable->id;

    }

    public function updateResponsable($request, $difuntoid){
        $responsable= Responsable::where('id', $difuntoid)->first();
        $responsable->ci = $request->ci_resp;
        $responsable->nombres = $request->nombres_resp;
        $responsable->primer_apellido = $request->paterno_resp;
        $responsable->segundo_apellido = $request->materno_resp;
        $responsable->fecha_nacimiento = $request->fechanac_resp;
        $responsable->genero = $request->genero_resp;  
        $responsable->telefono = $request->telefono;  
        $responsable->celular = $request->celular;  
        $responsable->estado_civil = $request->ecivil;  
        $responsable->domicilio = $request->domicilio;  
        $responsable->email = $request->email;  
        $responsable->estado = 'ACTIVO';  
        $responsable->user_id = auth()->id();
        $responsable->save();
        return $responsable->id;
    }

}
