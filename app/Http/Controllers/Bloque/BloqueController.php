<?php

namespace App\Http\Controllers\Bloque;

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
                 ->select('bloque.*')
                 ->where('estado', '=', 'ACTIVO')
                 ->get();

        return view('bloque/index', compact('bloque', 'cuartel'));
    }
    public function create(){      
       
    }

    public function register(){    
          

        return redirect('/Bloque/index');
    }

    public function listCuartel(){
        $cuartel=DB::table('cuartel')
                ->select('cuartel.*')
                ->where('estado', '=', 'ACTIVO')
                ->get();
               
                if($cuartel){
                return response([
                    'status'=> true,
                    'response'=> $cuartel
                 ],201);

               
               }else{
    
                return response([
                    'status'=> false,
                    'message'=> 'Error 401 (Unauthorized)'
                 ],401);
            }
    }
    
}
