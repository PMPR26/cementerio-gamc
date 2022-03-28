<?php

namespace App\Http\Controllers\Cripta;

use App\Models\Cripta;
use App\Models\Cuartel;
use App\Models\Bloque;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CriptaController extends Controller
{
    public function index(){

        $cripta = Cripta::select('cripta.id', 'cripta.codigo', 'cuartel.nombre as cuartel_name', 'cripta.nombre as cripta_name', 'cripta.estado')
        ->join('cuartel', 'cuartel.id', 'cripta.cuartel_id')
        ->orderBy('cripta.nombre', 'DESC')
        ->get();

         $cuartel = Cuartel::select('id', 'nombre')
                    ->where('estado', 'ACTIVO')
                    ->orderBy('nombre', 'DESC')
                    ->get();

        return view('cripta.index', ['cripta' => $cripta, 'cuartel' => $cuartel]);

    }

    public function saveCripta(Request $request){

        $this->validate($request, [
            'id_cuartel' => 'required',
            'codigo' => 'required',
            'name' => 'required',
            'superficie' => 'required|numeric',
            'status' => 'required'
        ],[
            'id_cuartel.required' => 'El campo cuartel es requerido!',
            'codigo.required' => 'El campo codigo es requerido!',
            'name.required' => 'Nombre de la cripta es requerido!',
            'superficie.required' => ':attribute es requerido!' ,
            'numeric' => 'La :attribute debe ser un número!'
        ]);

        $cripta = Cripta::create([
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
            'response'=> $cripta
         ],201);
    }


    public function getCripta($id){

        $cripta = Cripta::select()
                    ->where('id', $id)
                    ->first();

        return response([
              'status'=> true,
              'response'=> $cripta
                 ],201);
    }

    public function updateCripta(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'superficie' => 'required|numeric',
            'status' => 'required'
        ],[
            'name.required' => 'Nombre de la cripta es requerido!',
            'superficie.required' => ':attribute es requerido!' ,
            'numeric' => 'La :attribute debe ser un número!'
        ]);

        $cripta = Cripta::where('id', $cuartel->id)
        ->update([
            'estado' => 'INACTIVO'
        ]);



        $bloque = Bloque::select('id', 'nombre')
        ->where(['estado' => 'ACTIVO', ''])
        ->orderBy('nombre', 'DESC')
        ->get();

        return response([
            'status'=> true,
            'response'=> $bloque
               ],200);
    }
}
