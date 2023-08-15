<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Responsable extends Model
{
    use HasFactory;

    protected $table = 'responsable';
    protected $fillable = [
        'ci',
        'nombres',
        'primer_apellido',
        'segundo_apellido',
        // 'fecha_nacimiento',
        'telefono',
        'celular',
        // 'estado_civil',
        'genero',
        // 'email',
        // 'domicilio',
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

        $ci = Responsable::select('id')
        ->whereRaw('id = (select max(id) from responsable)')
                ->first();

         if($ci){
            // $number = (int) str_replace('-','',filter_var($ci, FILTER_SANITIZE_NUMBER_INT)) + 1;
            // return 'SCRI-'.str_pad($number, 4, '0', STR_PAD_LEFT);
            $nro=$ci->id+1;
            $number = 'SCRI-'.$nro;
            return  $number;
         }else{
             return 'SCRI-0001';
         }
    }

    public function insertResponsable($request){
        // dd("llega  sdasd");
        if(!isset($request->ci_resp) || $request->ci_resp==null || $request->ci_resp==''){
            $resp=new Responsable;
            $ci_resp=$resp->generateCiResponsable();

        }else{
            $ci_resp=$request->ci_resp;
        }
        $responsable = new Responsable;
        $responsable->ci = $ci_resp;
        $responsable->nombres = $request->nombres_resp;
        $responsable->primer_apellido = $request->paterno_resp;
        $responsable->segundo_apellido = $request->materno_resp ?? null;
        $responsable->fecha_nacimiento = $request->fechanac_resp ?? null;
        $responsable->genero = $request->genero_resp ?? null;
        $responsable->telefono = $request->telefono ?? null;
        $responsable->celular = $request->celular ?? null;
        // $responsable->estado_civil = $request->ecivil ?? null;
        // $responsable->domicilio = $request->domicilio;
        // $responsable->email = $request->email ?? null;
        $responsable->estado = 'ACTIVO';
        $responsable->user_id = auth()->id();
        $responsable->save();
        $responsable->id;
        return  $responsable->id;
    }





    public function updateResponsableByDif($request, $difuntoid){
        if($request->ci_resp==null ||$request->ci_resp=="" ){
           // $respons = new Responsable;  // correct

           // $ci_resp= $respons->generateCiResponsable();;
        }else{
            $ci_resp=$request->ci_resp;
        }
        $responsable= Responsable::where('id', $difuntoid)->first();
        $responsable->ci = $request->ci_resp;
        $responsable->nombres = $request->nombres_resp;
        $responsable->primer_apellido = $request->paterno_resp;
        $responsable->segundo_apellido = $request->materno_resp?? null;
        $responsable->fecha_nacimiento = $request->fechanac_resp ?? null;
        $responsable->genero = $request->genero_resp;
        $responsable->telefono = $request->telefono ?? null;
        $responsable->celular = $request->celular ?? null;
        // $responsable->estado_civil = $request->ecivil ?? null;
        // $responsable->domicilio = $request->domicilio ?? null;
        // $responsable->email = $request->email ?? null;
        $responsable->estado = $request->estado ??'ACTIVO';
        $responsable->user_id = auth()->id();
        $responsable->save();
        return $responsable->id;
    }

    public function updateResponsable($request, $id_resp){

        $responsable= Responsable::where('id', $id_resp)->first();
        // dd($responsable);
        if($request->ci_resp==null || $request->ci_resp==""){

        }else{
            $responsable->ci=$request->ci_resp;
        }

        $responsable->nombres=trim(mb_strtoupper($request->nombres_resp,'UTF-8'));
        $responsable->primer_apellido= trim(mb_strtoupper($request->paterno_resp,'UTF-8'));
        $responsable->segundo_apellido=trim(mb_strtoupper($request->materno_resp,'UTF-8'))?? '';
        $responsable->genero=$request->genero_resp ?? '';
        $responsable->telefono=$request->telefono ?? 0;
        $responsable->celular=$request->celular ?? 0;
        $responsable->updated_at=date("Y-m-d H:i:s");
        $responsable->save();
        return $responsable->id;
    }

    public function getCiResp($id_resp){
        $q= Responsable::where('id', $id_resp)->first();
        $ci_responsable=$q->ci;
        return $ci_responsable;
    }

    public function searchResponsable(Request $request){
        // dd($request->search_resp);
        if(isset($request->ci_resp) && ($request->ci_resp!=null || $request->ci_resp!='')){
            $existeResponsable = Responsable::whereRaw('ci=\''. trim($request->ci_resp).'\'')
            ->orderBy('id', 'desc')
            ->first();

        }else if(isset($request->materno_resp) && ($request->materno_resp!=null || $request->materno_resp!='')){
            $existeResponsable = Responsable::whereRaw('nombres=\''. trim($request->nombres_resp).'\'')
            ->whereRaw('primer_apellido=\''.trim($request->paterno_resp).'\'')
            ->whereRaw('segundo_apellido=\''.trim($request->materno_resp).'\'')
            ->orderBy('id', 'desc')
            ->first();
        }
        else if(isset($request->fechanac_resp) && ($request->fechanac_resp!=null || $request->fechanac_resp!='') && ($request->materno_resp==null || $request->materno_resp=='')){
            $existeResponsable = Responsable::whereRaw('nombres=\''. trim($request->nombres_resp).'\'')
            ->whereRaw('primer_apellido=\''.trim($request->paterno_resp).'\'')
            ->whereRaw('fecha_nacimiento=\''.trim($request->fechanac_resp).'\'')
            ->orderBy('id', 'desc')
            ->first();
        }
        else if(isset($request->fechanac_resp) && ($request->fechanac_resp!=null || $request->fechanac_resp!='') && ($request->materno_resp!=null || $request->materno_resp!='')){
            $existeResponsable = Responsable::whereRaw('nombres=\''. trim($request->nombres_resp).'\'')
            ->whereRaw('primer_apellido=\''.trim($request->paterno_resp).'\'')
            ->whereRaw('segundo_apellido=\''.trim($request->materno_resp).'\'')
            ->whereRaw('fecha_nacimiento=\''.trim($request->fechanac_resp).'\'')
            ->orderBy('id', 'desc')
            ->first();
        }else{
            $existeResponsable = Responsable::whereRaw('nombres=\''. trim($request->nombres_resp).'\'')
            ->whereRaw('primer_apellido=\''.trim($request->paterno_resp).'\'')
            ->orderBy('id', 'desc')
            ->first();
        }

                 // dd($existeResponsable);
                 return $existeResponsable;
    }
}
