<?php

namespace App\Http\Controllers\Cripta;

use App\Models\Cripta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CriptaController extends Controller
{
    public function index(){

        $cripta = Cripta::select('cripta.codigo', 'cuartel.nombre as cuartel_name', 'bloque.nombre as bloque_name', 'cripta.nombre as cripta_name', 'cripta.estado')
        ->join('cuartel', 'cuartel.id', 'cripta.cuartel_id')
        ->join('bloque', 'bloque.id', 'cripta.bloque_id')
        ->orderBy('cripta.nombre', 'DESC')
         ->get();

      
        return view('cripta.index', ['cripta' => $cripta]);


    }
}
