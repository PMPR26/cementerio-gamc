<?php

namespace App\Http\Controllers\Cuartel;

use App\Models\Cuartel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CuartelController extends Controller
{
    //
    public function index(){

        $cuartel= Cuartel::select('cuartel.*')
                ->orderBy('codigo', 'DESC')
                 ->get();

        return view('cuartel/index', compact('cuartel'));
    }
    public function createNewCuartel(Request $request){

        if($request->isJson()){
            
            $this->validate($request, [
                'name' => 'required',
                'codigo' => 'required|unique:cuartel'
            ], [
                'name.required'  => 'El campo nombre de cuartel es obligatorio!',
                'codigo.required'    => 'El campo Codigo cuartel es obligatorio!',
                'codigo.unique' => 'El código '.$request->codigo.' ya se encuentra en uso!.'
            ]);
            

           $new_cuartel =  Cuartel::create([
            'codigo' => trim($request->codigo),
            'nombre' => trim($request->name),
            'user_id' => auth()->id(),
            'estado' => 'ACTIVO',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
           ]);


            return response([
                'status'=> true,
                'response'=> $new_cuartel
             ],201);

        }else{

            return response([
                'status'=> false,
                'message'=> 'Error 401 (Unauthorized)'
             ],401);
        }
    }
       
    public function disableAndEnableCuartel($id){

        $cuartel = Cuartel::select()
                        ->where('id', $id)
                        ->first();
      
        if($cuartel->estado == 'ACTIVO'){

            $disable_cuartel =  Cuartel::where('id', $cuartel->id)
               ->update([
                   'estado' => 'INACTIVO'
               ]);

               return response([
                'status'=> true,
                'response'=> '!Cuartel desactivado!'
             ],200);
        }else{
            Cuartel::where([
                'id' => $cuartel->id
               ])
               ->update([
                   'estado' => 'ACTIVO'
               ]);

               return response([
                'status'=> true,
                'response'=> '!Cuartel Activo!'
             ],200);
        }

    }

    public function getCuartel($id){

        $cuartel =  Cuartel::where('id', $id)->first();

               return response([
                'status'=> true,
                'response'=> $cuartel
             ],200);
    }

    public function updateCuartel(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'id' => 'required'
        ], [
            'name.required'  => 'El campo nombre de cuartel es obligatorio!'
        ]);

        $disable_cuartel =  Cuartel::where('id', $request->id)
        ->update([
            'nombre' => $request->name,
            'estado' => $request->status,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return response([
            'status'=> true,
            'response'=> 'done'
         ],200);


    }
    
}
