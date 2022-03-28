<?php

namespace App\Http\Controllers\Difunto;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Difunto;
use Illuminate\Support\Facades\DB;

class DifuntoController extends Controller
{
    //
    public function index(){

        //$responsable= Responsable::select('responsable.*')
                // ->orderBy('codigo', 'DESC')
                // ->get();

        $difunto= DB::table('difunto') 
                ->select('difunto.id','difunto.ci',DB::raw('CONCAT(difunto.nombres , \' \',difunto.primer_apellido, \' \', difunto.segundo_apellido ) AS nombre'),'difunto.fecha_nacimiento','difunto.fecha_defuncion','difunto.certificado_defuncion','difunto.causa','difunto.tipo','difunto.estado','difunto.genero')        
                ->get();
            
        return view('difunto/index', compact('difunto'));
    }

    public function createNewDifunto(Request $request){

        if($request->isJson()){
            
            $this->validate($request, [
                'ci' => 'required|unique:difunto'
                // 'email' => 'required|unique:responsable',
                // 'nombres'=> 'required',
                // 'primer_apellido'=> 'required',
                // 'celular'=> 'required'
            ], [
                'nombres.required'  => 'El campo nombre de responsable es obligatorio!',
                'ci.required'    => 'El campo cedula de identidad es obligatorio!',
                'ci.unique' => 'El numero de cedula '.$request->ci.' ya se encuentra en uso!.'
            ]);
            

           $new_difunto =  Difunto::create([
            'ci' => trim($request->ci),
            'nombres' => trim($request->nombres),
            'primer_apellido' => trim($request->primer_apellido),
            'segundo_apellido' => trim($request->segundo_apellido),
            'fecha_nacimiento' => trim($request->fecha_nacimiento),
            'fecha_defuncion' => trim($request->fecha_defuncion),
            'certificado_defuncion' => trim($request->certificado_defuncion),
            'causa' => trim($request->causa),
            'tipo' => trim($request->tipo),
            'genero' => trim($request->genero),
            'user_id' => auth()->id(),
            'estado' => 'ACTIVO',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
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
            'nombres' => $request->nombres,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'fecha_defuncion' => $request->fecha_defuncion,
            'certificado_defuncion' => $request->certificado_defuncion,
            'causa' => $request->causa,
            'tipo' => $request->tipo,
            'genero' => $request->genero,
            //'estado' => $request->status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return response([
            'status'=> true,
            'response'=> 'done'
         ],200);


    }

}
