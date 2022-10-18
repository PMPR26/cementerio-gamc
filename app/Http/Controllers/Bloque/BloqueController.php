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


        $bloque =DB::table('bloque')
                 ->select('bloque.*', 'cuartel.codigo as cuartel_cod')
                 ->join('cuartel' , 'cuartel.id','=', 'bloque.cuartel_id')
                 ->orderBy('id', 'Desc')

                // ->where('bloque.estado', '=', 'ACTIVO')
                 ->get();

        return view('bloque/index', ['bloque' =>$bloque , 'cuartel' => $cuartel]);
    }

    public function createNewBloque(Request $request){

        if($request->isJson()){

            $this->validate($request, [
                'name' => 'required',
                // 'codigo' => 'required|unique:cuartel',
                'codigo' => 'required',

                'cuartel' => 'required',
                'estado' => 'required'
            ], [
                'name.required'  => 'El campo nombre de cuartel es obligatorio!',
                'cuartel.required' => 'El campo Codigo cuartel es obligatorio!',
                'codigo.required' => 'El campo código es obligatorio!.'

                // 'codigo.unique' => 'El código '.$request->codigo.' ya se encuentra en uso!.'
            ]);

            $rep= $this->repetidoins( $request->codigo, $request->cuartel   );
          //dd($rep);

            if($rep=="no"){
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
                        'message'=> 'Error, codigo existente, duplicado!)'
                     ],400);
                  }
            }
    }

    public function getBloque($id){

        $bloque =  Bloque::where('id', $id)->first();

               return response([
                'status'=> true,
                'response'=> $bloque
             ],200);
    }


    public function updateBloque(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'cuartel' => 'required',
            'codigo' => 'required',
            'id' => 'required'
        ], [
            'name.required'  => 'El campo nombre de bloque es obligatorio!',
            'codigo.required'  => 'El campo codigo de bloque es obligatorio!',
            'cuartel.required'  => 'El campo cuartel de bloque es obligatorio!'


        ]);
       $rep= $this->repetido( $request->id,$request->codigo);


      if($rep=="no"){
        $bloque =  Bloque::where('id', $request->id)
        ->update([
            'nombre' => $request->name,
            'cuartel_id' => $request->cuartel,
            'codigo' => $request->codigo,
            'estado' => $request->estado,
            'user_id' => auth()->id(),
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
    public function repetido($id, $codigo){
        $repetido =  DB::table('bloque')
                    ->where('id', '!=', $id)
                    ->where('codigo', '=', ''.$codigo.'')
                    ->first();
            if($repetido==null){
                return $resp="no";
            }
            else{
               return $resp="si";
            }

    }

    public function repetidoins($codigo, $cuartel){
        $repetido =  DB::table('bloque')

                    ->where('codigo', '=', ''.$codigo.'')
                    ->where('cuartel_id', '=', ''.$cuartel.'')

                    ->first();
            //  dd($repetido)     ;
            if($repetido==null){
                return $resp="no";
            }
            else{
               return $resp="si";
            }

    }

}
