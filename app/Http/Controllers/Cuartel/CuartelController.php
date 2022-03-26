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
    public function create(){      

        return view('cuartel/create');
    }

    public function register(){    
          

        return redirect('/Cuartel/index');
    }
}
