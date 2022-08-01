<?php

namespace App\Http\Controllers\Cripta;

use App\Models\Bloque;
use App\Models\Cripta;
use App\Models\Cuartel;
use App\Models\Responsable;
use App\Models\CriptaMausoleo;
use App\Models\CriptaMausoleoResp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CriptaController extends Controller
{
    public function index(){

        $cripta = Cripta::select('id', 'codigo',  'superficie','estado', 'tipo_registro')     
        ->orderBy('tipo_registro', 'DESC')  
        // ->orderBy('nombre', 'DESC')
        ->get();

         $cuartel = Cuartel::select('id','codigo')
                    ->where('estado', 'ACTIVO')                   
                    ->orderBy('nombre', 'DESC')
                    ->get();

        return view('cripta.index', ['cripta' => $cripta, 'cuartel' => $cuartel]);

    }

    public function saveCripta(Request $request){
     
    
     
        $this->validate($request, [
            'id_cuartel' => 'required',
            'codigo' => 'required', 
            'bloque' => 'required',            
            'sitio' => 'required',  
            // 'name' => 'required',
            'superficie' => 'required|numeric',
            // 'status' => 'required'
        ],[
            'id_cuartel.required' => 'El campo cuartel es requerido!',
            'codigo.required' => 'El campo código es requerido!',
            'sitio.required' => 'El campo sitio es requerido!',
            'bloque.required' => 'El campo bloque es requerido!',
            // 'name.required' => 'Nombre de la cripta es requerido!',
            'superficie.required' => ':attribute es requerido!' ,
            'numeric' => 'La :attribute debe ser un número!'
        ]);
        $existe=$this->existeCripta($request);
        // dd($request->ci_resp);
        if($existe==false)
        {
            $cripta = New Cripta;
            $cripta->user_id = auth()->id();
            $cripta->cuartel_id = trim($request->id_cuartel);
            $cripta->bloque_id = trim(strtoupper($request->bloque));
            $cripta->sitio = trim($request->sitio);
            $cripta->codigo = trim($request->codigo);
            // $cripta->nombre = trim($request->nombres_resp)." ".trim($request->paterno_resp)." ".trim($request->materno_resp);
            $cripta->superficie = trim($request->superficie);
            $cripta->ocupados = trim($request->ocupados);
            $cripta->total_cajones = trim($request->total_cajones);
            $cripta->estado_construccion = trim($request->estado_construccion);
            $cripta->observaciones = trim($request->observaciones);
            $cripta->foto = trim($request->foto);
            $cripta->estado = 'ACTIVO';         
            $cripta->tipo_registro = $request->tipo_reg;
            $cripta->created_at = date("Y-m-d H:i:s");
            $cripta->updated_at = date("Y-m-d H:i:s");
            $cripta->save();
            $cripta_id=$cripta->id;

            $existe_resp=Responsable::where('ci', $request->ci_resp)->first();
            //  dd($existe_resp);
            // si se envian datos del propietario del mausoleo o cripta entonces se busca en la tabla responsable para actualizar datos y no duplicar
            // caso contrario se insterta
                    if($request->ci_resp!=null)
                    {       if( isset($existe_resp->id)){ $responsable_id=Responsable::updateResponsable($request,   $existe_resp->id);  }
                            else{ $responsable_id=Responsable::insertResponsable($request); }
                                // si se envian los datos del responsable entonces se registra la relacion entre responsable y cripta o mausoleo
                                // buscar si no existe ya la relacion
                                $search_relacion=DB::table('cripta_mausoleo_responsable')
                                                ->join('cripta_mausoleo','cripta_mausoleo.id', 'cripta_mausoleo_responsable.cripta_mausole_id' )
                                                ->where('responsable_id',$responsable_id)
                                                ->where('cripta_mausole_id',  $cripta_id)
                                                ->where('cripta_mausoleo.estado', 'ACTIVO')
                                                ->where('cripta_mausoleo.cuartel_id',$request->id_cuartel)
                                                ->where('cripta_mausoleo.bloque_id',$request->bloque)
                                                ->where('cripta_mausoleo.sitio',$request->sitio)
                                                ->where('cripta_mausoleo.superficie',$request->superficie)
                                                ->where('cripta_mausoleo.sitio',$request->sitio)
                                                ->first();   
                                                if(!$search_relacion) {
                                                        $criptaMauseleo = New CriptaMausoleoResp;                                                  
                                                        $criptaMauseleo->responsable_id = $responsable_id;
                                                        $criptaMauseleo->cripta_mausole_id = $cripta_id;
                                                        $criptaMauseleo->save();    
                                                }            
                        }
              
                   return response([
                        'status'=> true,
                        'response'=> $cripta
                    ],201);
        }
        else{
            return response([
                'status'=> false,
                'response'=> "El sitio ya esta ocupado"
            ],201);
        }
    }


    public function getCripta($id){

        $cripta = Cripta::select('cripta_mausoleo.*', 'responsable.id as responsable_id', 'responsable.nombres','responsable.primer_apellido', 
                                  'responsable.segundo_apellido', 'responsable.ci', 'responsable.domicilio', 'responsable.nombres',
                                  'responsable.genero', 'cripta_mausoleo_responsable.id as cripta_mausoleo_resp_id' )
                    ->leftJoin('cripta_mausoleo_responsable', 'cripta_mausoleo_responsable.cripta_mausole_id','=','cripta_mausoleo.id')
                    ->leftJoin('responsable', 'responsable.id','=','cripta_mausoleo_responsable.responsable_id')
                    ->where('cripta_mausoleo.id', $id)
                    ->first();

        return response([
              'status'=> true,
              'response'=> $cripta
                 ],201);
    }

    public function updateCripta(Request $request){
        // return response()->json([ $request->id_cripta]);
        $this->validate($request, [
            'id_cripta' => 'required',          
            'superficie' => 'required|numeric',
           
        ],[
         
            'superficie.required' => ':attribute es requerido!' ,
            'numeric' => 'La :attribute debe ser un número!'
        ]);

        // $existe=$this->existeCripta($request);

        // if($existe==false){
  
                    $cripta = Cripta::where('id', $request->id_cripta)
                    ->update([
                        'user_id' => auth()->id(),
                        'cuartel_id' => trim($request->id_cuartel),
                        'bloque_id' => trim(strtoupper($request->bloque))??'',
                        'sitio' => trim($request->sitio),
                        'codigo' => trim($request->codigo),
                        // 'nombre' => trim($request->name),
                        'superficie' => trim($request->superficie),
                        'estado' => $request->status,
                        'tipo_registro' => $request->tipo_reg,                      
                        'ocupados' => trim($request->ocupados),
                        'total_cajones' => trim($request->total_cajones),
                        'estado_construccion' => trim($request->estado_construccion),
                        'observaciones' => trim($request->observaciones),
                        'foto' => trim($request->foto),                           
                        'updated_at' => date("Y-m-d H:i:s")     
                    ]);
                    $ex_resp=DB::table('responsable')->where('ci', ''. $request->ci_resp.'')
                    ->first();
                      
                        // si se envian datos del propietario del mausoleo o cripta entonces se busca en la tabla responsable para actualizar datos y no duplicar
                        // caso contrario se insterta
                    if($request->ci_resp!=null)
                    {
                        if( isset($ex_resp->id)){ $responsable_id=Responsable::updateResponsable($request,   $ex_resp->id);  }
                        else{ $responsable_id=Responsable::insertResponsable($request); }
                                
                                // si se envian los datos del responsable entonces se registra la relacion entre responsable y cripta o mausoleo
                                // buscar si no existe ya la relacion
        
                                $search_relacion=DB::table('cripta_mausoleo_responsable')
                                                ->join('cripta_mausoleo','cripta_mausoleo.id', 'cripta_mausoleo_responsable.cripta_mausole_id' )
                                                ->where('responsable_id',$responsable_id)
                                                ->where('cripta_mausole_id',  $request->id_cripta)
                                                ->where('cripta_mausoleo.estado', 'ACTIVO')
                                                ->where('cripta_mausoleo.cuartel_id',$request->id_cuartel)
                                                ->where('cripta_mausoleo.bloque_id',$request->bloque)
                                                ->where('cripta_mausoleo.sitio',$request->sitio)
                                                ->where('cripta_mausoleo.superficie',$request->superficie)
                                                ->where('cripta_mausoleo.sitio',$request->sitio)
                                                ->first();    
        
        
                                                if(!$search_relacion) {
                                                        $criptaMauseleo = New CriptaMausoleoResp;                                                  
                                                        $criptaMauseleo->responsable_id = $responsable_id;
                                                        $criptaMauseleo->cripta_mausole_id =  $request->id_cripta;
                                                        $criptaMauseleo->save();    
                                                }            
                        }
                    return response([
                        'status'=> true,
                        'response'=> $cripta
                    ],201);
        // }
        // else{
        //     return response([
        //         'status'=> false,
        //         'response'=> "El sitio ya esta ocupado"
        //     ],201);
        // }
    }

    public function existeCripta(Request $request){

         $cripta = DB::table('cripta_mausoleo')->where('cuartel_id', $request->id_cuartel)
                           ->where('bloque_id', $request->bloque)
                           ->where('sitio', $request->sitio)
                           ->first();
                    //    dd($request->id_cripta )    ;     
                           if(!empty($cripta)){
                            if($cripta->id != $request->id_cripta)
                                     return  true;
                                else
                                return false;
                           }

                           return false;
       

      
    }
}
