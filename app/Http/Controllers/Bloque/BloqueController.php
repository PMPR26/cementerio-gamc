<?php

namespace App\Http\Controllers\Bloque;
use App\Models\Bloque;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BloqueController extends Controller
{
    public function index(){
        $cuartel=DB::table('cuartel')
                 ->select('cuartel.id', 'cuartel.codigo')
                 ->where('estado', '=', 'ACTIVO')
                 ->get();


        $bloque=DB::table('bloque')
                 ->select('bloque.*', 'cuartel.codigo as cuartel_cod')
                 ->join('cuartel' , 'cuartel.id','=', 'bloque.cuartel_id')
                 ->where('bloque.estado', '=', 'ACTIVO')
                 ->get();

        return view('bloque/index', compact('bloque', 'cuartel'));
    }
    public function createNewBloque(Request $request){

        if($request->isJson()){
            
            $this->validate($request, [
                'name' => 'required',
                'codigo' => 'required|unique:cuartel',
                'cuartel' => 'required',
                'estado' => 'required'
            ], [
                'name.required'  => 'El campo nombre de cuartel es obligatorio!',
                'cuartel.required' => 'El campo Codigo cuartel es obligatorio!',
                'codigo.unique' => 'El código '.$request->codigo.' ya se encuentra en uso!.'
            ]);
            

           $new_bloque =  Bloque::create([
            'codigo' => trim($request->codigo),
            'nombre' => trim($request->name),
            'cuartel_id' => trim($request->cuartel),

            'user_id' => auth()->id(),
            'estado' => 'ACTIVO',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
           ]);


            return response([
                'status'=> true,
                'response'=> $new_bloque
             ],201);

        }else{

            return response([
                'status'=> false,
                'message'=> 'Error 401 (Unauthorized)'
             ],401);
        }
    }
    
}
