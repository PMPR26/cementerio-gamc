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

        $cuartel=DB::table('cuartel')
                 ->select('cuartel.*')
                 ->where('estado', '=', 'ACTIVO')
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
       
    
}
