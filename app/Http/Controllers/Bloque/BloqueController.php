<?php

namespace App\Http\Controllers\Bloque;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BloqueController extends Controller
{
    public function index(){

        $bloque=DB::table('bloque')
                 ->select('bloque.*')
                 ->where('estado', '=', 'ACTIVO')
                 ->get();

        return view('bloque/index', compact('bloque'));
    }
    public function create(){      

        return view('bloque/create');
    }

    public function register(){    
          

        return redirect('/Bloque/index');
    }
}
