<?php

namespace App\Http\Controllers\Mantenimiento;
use App\Models\Mantenimiento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;


class MantenimientoController extends Controller
{
    public function index(){
        $mant= Mantenimiento::select('mantenimiento_nicho.*',  DB::raw('CONCAT(responsable.nombres , \' \',responsable.primer_apellido, \' \', responsable.segundo_apellido ) AS nombre'))
                ->leftJoin('responsable', 'responsable.id', '=', 'mantenimiento_nicho.responsable_id')
                ->orderBy('id', 'DESC')
                 ->get();

                

        return view('mantenimiento/index', compact('mant'));
    }

    public function createPay(){

        $headers =  ['Content-Type' => 'application/json'];
        $client = new Client();
       
        $response = $client->get(env('URL_MULTISERVICE').'/api/v1/cementerio/generate-servicios-nicho/525', [
        'json' => [
            ],
            'headers' => $headers,
        ]);
        $data = json_decode((string) $response->getBody(), true);
          
       
       if($data['status']==true){
            $precio = $data['response'][0]['monto1'];
            $cuenta = $data['response'][0]['cuenta'];
            $descrip = $data['response'][0]['descripcion'];
        }else{
            $precio =0;
        }
        

        return view('mantenimiento/nuevoPago', ['precio' =>$precio, 'cuenta' =>$cuenta, 'descrip' =>$descrip]);
    }


    public function savePay(Request $request){
        
        dd($request);
        if($request->isJson()){            
            $this->validate($request, [
                'nro_nicho'=> 'required',
                'bloque'=> 'required',
                'cuartel'=> 'required',
                'fila'=> 'required',
                'tipo'=> 'required',
                'columna'=> 'required',
                'ci_dif'=> 'required',
                'nombres_dif'=> 'required',
                'paterno_dif'=> 'required',
                'tipo_dif'=> 'required',
                'genero_dif'=> 'required',
                'ci_resp'=> 'required',
                'nombres_resp'=> 'required',
                'paterno_resp'=> 'required',
                'celular'=> 'required',
                'ecivil'=> 'required',
                'email'=> 'required',
                'domicilio'=> 'required',
                'genero_resp'=> 'required',
//pedir a gus gus
                'tipo_serv'=> 'required|array',
                'serv'=> 'required|array',
                'servname'=> 'required|array',  
                // 'cantidad' => 'required',
                // 'unidad' => 'required',
                // 'precio_unitario' => 'required',
                // 'monto' => 'required',
                // 'ultimopago'=>'required',
                // 'hserv'=>'required',
                // 'servicio'=>'required',
                // 'cuenta'=>'required',
                // 'tipo_serv'=>'required'

                
            ], [
                'cantidad.required'  => 'El campo cantidad es obligatorio!',
                'unidad.required' => 'El campo Codigo cuartel es obligatorio!',
                'cuenta.required' => 'Debe asignar al menos un servicio!.'
            ]);

            //step1: nicho buscar si existe registrado el nicho recuperar el id  sino existe registrarlo
            $codigo_n=$request->cuartel.".".$request->bloque.".".$request->nro_nicho.".".$request->fila;
            $existeNicho= Nicho::where('codigo', $codigo_n)->first();
                      
            if($existeNicho!=null){
                $id_nicho=$existeNicho->id;
            }
            else{

                // buscar cuartel si existe recuperar id sino insertar
                  $existeCuartel= Cuartel::where('codigo', $request->cuartel)->first();
                    if($existeCuartel!=null){
                        $id_cuartel=$existeCuartel->id;
                    }else{
                        $cuart = new Cuartel;
                        $cuart->codigo = trim($request->cuartel);
                        $cuart->nombre = trim($request->cuartel);
                        $cuart->estado = 'ACTIVO';
                        $cuart->user_id = auth()->id();
                        $cuart->save();
                        $cuart->id;
                        $id_cuartel=$cuart->id;
                    }

                //buscar bloque si existe recuperar id sino insertar
                $existeBloque= Bloque::where('codigo', $request->bloque)->first();
                        if($existeBloque!=null){
                            $id_bloque=$existeBloque->id;
                        }else{
                            $bloq = new Cuartel;
                            $bloq->cuartel_id = $cuart->id;
                            $bloq->codigo = trim($request->bloque);
                            $bloq->nombre = trim($request->bloque);
                            $bloq->estado = 'ACTIVO';
                            $bloq->user_id = auth()->id();
                            $bloq->save();
                            $bloq->id;
                            $id_bloque=$bloq->id;
                        }

                         // insertar nicho
                        $nicho = new Nicho;
                        $nicho->cuartel_id = $id_cuartel;
                        $nicho->bloque_id = $id_bloque;
                        $nicho->nro_nicho = $request->nro_nicho;
                        $nicho->fila = $request->fila;
                        $nicho->codigo = $request->cuartel.".".$request->bloque.".".$request->nro_nicho.".".$request->fila; 
                        $nicho->codigo_anterior = $request->anterior;  
                        $nicho->user_id = auth()->id();
                        $nicho->save();
                        $nicho->id;
                        $id_nicho= $nicho->id;
            }
            // end nicho

                 // step2: register difunto --- si id_difunto id_difunto es null insertar difunto insertar responsable
                    if($request->id_difunto==""){
                        //insertar difunto
                         $difuntoid=$this->insertDifunto($request);
                    }else{
                        $difuntoid=$request->difunto_id;
                        $this->updateDifunto($request, $difuntoid);
                        
                    }
                    // end difunto
                    // step4: register responsable -- si el responsable     
                            if($request->id_responsable==""){
                                //insertar difunto
                                 $resp=$this->insertReponsables($request);
                            }else{
                                $resp=$request->difunto_id;
                                $this->updateResponsable($request, $difuntoid);
                                
                            }
                    //end responsable
              
                    //insert services 
              

                if (!empty($request->servicios) && is_array($request->servicios)) {
                    $count = count($request->servicios);
                    $codigo_nicho=$request->cuartel.".".$request->bloque.".".$request->nicho.".".$request->fila;

                    
                    /** generar fur */
                    $nombre_difunto=$request->nombres_dif." ".$request->primerap_dif." ".$request->segap_dif;
                    // $response = $this->GenerarFur($request->search_resp, $request->nombres_resp, $request->primerap_resp,
                    // $request->segapresp, $request->domicilio, $request->telefono, $nombre_difunto, $codigo_nicho,
                    // $request->bloque, $request->nro_nicho, $request->fila, $request->servicio );
                   
                    // if($response['status']==true){
                    //     $fur = $response['response'];
                       
                    // }
                    $fur="165235";
                   
                    //   
                    
                }


           
              
              
            }
    }


}
