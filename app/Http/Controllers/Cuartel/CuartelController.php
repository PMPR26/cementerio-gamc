<?php

namespace App\Http\Controllers\Cuartel;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                'cod' => 'required'
            ], [
                'name.required'  => 'El campo nombre de cuartel es obligatorio!',
                'name.required'    => 'El campo Codigo cuartel es obligatorio!'
            ]);
            

           $new_cuartel =  Cuartel::create([
            'id_user' => auth()->id(),
            'num_gral' => trim($request->num_gral),
            'num_cite' => trim($request->num_cite),
            'description' => trim($request->descripcion),
            'date_register_request' => $request->fecha,
           ]);


            return response([
                'status'=> true,
                'response'=> $new_request
             ],201);
        }else{

            return response([
                'status'=> false,
                'message'=> 'Error 401 (Unauthorized)'
             ],401);
        }
    }
       
    
}
