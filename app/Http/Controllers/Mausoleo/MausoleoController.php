<?php

namespace App\Http\Controllers\Mausoleo;

use App\Models\Mausoleo;
use App\Models\Cuartel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MausoleoController extends Controller
{
    public function index(){

        $mausoleo = Mausoleo::select('mausoleo.id', 'mausoleo.codigo',  'mausoleo.superficie', 'cuartel.nombre as cuartel_name', 'mausoleo.nombre as mausoleo_name', 'mausoleo.estado')
        ->join('cuartel', 'cuartel.id', 'mausoleo.cuartel_id')
        ->orderBy('mausoleo.nombre', 'DESC')
        ->get();

         $cuartel = Cuartel::select('id', DB::raw("CONCAT(codigo,' - ',nombre) as nombre"))
                    ->where('estado', 'ACTIVO')
                    ->orderBy('nombre', 'DESC')
                    ->get();

        return view('mausoleo.index', ['mausoleo' => $mausoleo, 'cuartel' => $cuartel]);

    }

    public function savemausoleo(Request $request){

        $this->validate($request, [
            'id_cuartel' => 'required',
            'codigo' => 'required',
            'name' => 'required',
            'superficie' => 'required|numeric',
            'status' => 'required'
        ],[
            'id_cuartel.required' => 'El campo cuartel es requerido!',
            'codigo.required' => 'El campo codigo es requerido!',
            'name.required' => 'Nombre de la mausoleo es requerido!',
            'superficie.required' => ':attribute es requerido!' ,
            'numeric' => 'La :attribute debe ser un número!'
        ]);
        $rep= $this->repetidoins( $request->codigo, $request->id_cuartel);
      

        if($rep=="no"){
        $mausoleo = Mausoleo::create([
            'user_id' => auth()->id(),
            'cuartel_id' => $request->id_cuartel,
            'codigo' => trim($request->codigo),
            'nombre' => trim($request->name),
            'superficie' => trim($request->superficie),
            'estado' => $request->status,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);


        return response([
            'status'=> true,
            'response'=> $mausoleo
         ],201);
        }else{
            return response([
                'status'=> false,
                'message'=> 'Error, codigo existente, duplicado!)'
             ],400);
          }
    }


    public function getmausoleo($id){

        $mausoleo = Mausoleo::select()
                    ->where('id', $id)
                    ->first();

        return response([
              'status'=> true,
              'response'=> $mausoleo
                 ],201);
    }

  
    public function updateMausoleo(Request $request){

        $this->validate($request, [
            'id_cuartel' => 'required',
            'codigo' => 'required',
            'name' => 'required',
            'superficie' => 'required|numeric',
            'status' => 'required'
        ],[
            'id_cuartel.required' => 'El campo cuartel es requerido!',
            'codigo.required' => 'El campo codigo es requerido!',
            'name.required' => 'Nombre de la mausoleo es requerido!',
            'superficie.required' => ':attribute es requerido!' ,
            'numeric' => 'La :attribute debe ser un número!'
        ]);
       $rep= $this->repetido( $request->id,$request->codigo, $request->id_cuartel);
      

      if($rep=="no"){
        $mausoleo =  Mausoleo::where('id', $request->id)
        ->update([
            'user_id' => auth()->id(),
            'cuartel_id' => $request->id_cuartel,
            'codigo' => trim($request->codigo),
            'nombre' => trim($request->name),
            'superficie' => trim($request->superficie),
            'estado' => $request->status,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return response([
            'status'=> true,
            'response'=> 'done'
         ],200);
      }else{
        return response([
            'status'=> false,
            'message'=> 'Error, codigo existente, duplicado!)'
         ],400);
      }

    }

    public function repetido($id, $codigo, $cuartel){
        $repetido =  DB::table('mausoleo')
                    ->where('id', '!=', $id)
                    ->where('codigo', '=', ''.$codigo.'')
                    ->where('cuartel_id', '=', ''.$cuartel.'')

                    ->first();
                   
            if($repetido==null){
                return $resp="no";
            }
            else{
               return $resp="si";
            }      

    }

    public function repetidoins($codigo, $cuartel){
        $repetido =  DB::table('mausoleo')
                   
                    ->where('codigo', '=', ''.$codigo.'')
                    ->where('cuartel_id', '=', ''.$cuartel.'')

                    ->first();
                   
            if($repetido==null){
                return $resp="no";
            }
            else{
               return $resp="si";
            }      

    }
}
