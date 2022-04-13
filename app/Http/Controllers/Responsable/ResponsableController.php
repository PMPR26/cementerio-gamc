<?php

namespace App\Http\Controllers\Responsable;

use App\Models\Difunto;
use App\Models\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ResponsableController extends Controller
{
    //
    public function index(){

        //$responsable= Responsable::select('responsable.*')
                // ->orderBy('codigo', 'DESC')
                // ->get();

        $responsable= DB::table('responsable') 
                ->select('responsable.id','responsable.ci',DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'),'responsable.telefono','responsable.celular','responsable.fecha_nacimiento','responsable.estado_civil','responsable.email','responsable.domicilio','responsable.estado','responsable.genero')        
                ->get();
            
        return view('responsable/index', compact('responsable'));
    }

    public function createNewResponsable(Request $request){

        if($request->isJson()){
            
            $this->validate($request, [
                'ci' => 'required|unique:responsable|max:9',
                'nombres' => 'required',
                'primer_apellido' => 'required',
                'fecha_nacimiento' => 'required',
                'telefono' => 'digits:7|numeric',
                'domicilio' => 'required',
                'genero' => 'required'
            ], [
                'nombres.required'  => 'El campo nombre de responsable es obligatorio!',
                'ci.required'    => 'El campo cedula de identidad es obligatorio!',
                'ci.unique' => 'El numero de cedula '.$request->ci.' ya se encuentra en uso!.',
                'min' => 'El :attribute debe tener al menos 8 caracteres.',
                'telefono' => 'El telefono no debe ser mayor a 7 digitos.',
                'ci.max' => 'CI no debe ser mayor a 10 caracteres.',
                'required' => 'El campo :attribute es requerido.'
            ]);
            

           $new_responsable =  Responsable::create([
            'ci' => trim($request->ci),
            'nombres' => trim($request->nombres),
            'primer_apellido' => trim($request->primer_apellido),
            'segundo_apellido' => trim($request->segundo_apellido),
            'fecha_nacimiento' => trim($request->fecha_nacimiento),
            'telefono' => trim($request->telefono),
            'celular' => trim($request->celular),
            'estado_civil' => trim($request->estado_civil),
            'genero' => trim($request->genero),
            'email' => trim($request->email),
            'domicilio' => trim($request->domicilio),
            'user_id' => auth()->id(),
            'estado' => 'ACTIVO',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
           ]);


            return response([
                'status'=> true,
                'response'=> $new_responsable
             ],201);

        }else{

            return response([
                'status'=> false,
                'message'=> 'Error 401 (Unauthorized)'
             ],401);
        }
    }

    public function disableAndEnableResponsable($id){

        $responsable = Responsable::select()
                        ->where('id', $id)
                        ->first();
      
        if($responsable->estado == 'ACTIVO'){

            $disable_responsable =  Responsable::where('id', $responsable->id)
               ->update([
                   'estado' => 'INACTIVO'
               ]);

               return response([
                'status'=> true,
                'response'=> '!Responsable desactivado!'
             ],200);
             
        }else{
            Responsable::where([
                'id' => $responsable->id
               ])
               ->update([
                   'estado' => 'ACTIVO'
               ]);

               return response([
                'status'=> true,
                'response'=> '!Responsable Activo!'
             ],200);
        }

    }

    public function getResponsable($id){

        $responsable =  Responsable::where('id', $id)->first();

               return response([
                'status'=> true,
                'response'=> $responsable
             ],200);
    }


    public function updateResponsable(Request $request){

        $this->validate($request, [
            'ci' => 'required',
            'nombres' => 'required',
            'id' => 'required'
        ], [
            'nombres.required'  => 'El campo nombre de responsable es obligatorio!'
        ]);

        $disable_responsable =  Responsable::where('id', $request->id)
        ->update([
            'ci' => $request->ci,
            'nombres' => $request->nombres,
            'primer_apellido' => $request->primer_apellido,
            'segundo_apellido' => $request->segundo_apellido,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
            'telefono' => $request->telefono,
            'celular' => $request->celular,
            'estado_civil' => $request->estado_civil,
            'email' => $request->email,
            'domicilio' => $request->domicilio,

            //'estado' => $request->status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return response([
            'status'=> true,
            'response'=> 'done'
         ],200);

    }

    public function searchResponsableAndDifunt(Request $request){
        
        if($request->isJson()){
            $this->validate($request, [
                'ci' => 'required',
                'type' => 'required' // responsable
            ]);

            if(trim($request->type) == 'deceased'){
                $person = Difunto::select()
                            ->where(['ci' => trim($request->ci)])
                            ->first();

                return response([
                       'status'=> true,
                       'response'=> $person
                                ],200);
            }else if(trim($request->type) == 'responsable'){
                $person = Responsable::select()
                            ->where(['ci' => trim($request->ci)])
                            ->first();

                return response([
                       'status'=> true,
                       'response'=> $person
                                ],200);
            }else{

                return response([
                    'status'=> false,
                    'message'=> 'Parametro type solo acepta los siguientes valores: deceased = "difunto" y responsable = "responsable"'
                 ],200);
            }

        }else{

            return response([
                'status'=> false,
                'message'=> 'Error 401 (Unauthorized)'
             ],401);
        }
    }

}
