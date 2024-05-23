<?php

namespace App\Http\Controllers\Nicho;

use App\Models\Nicho;
use App\Http\Controllers\Controller;
use App\Models\Cuartel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;

class NichoController extends Controller
{

    public function index(Request $request){

        if (auth()->check()) {
            $user = auth()->user();
            $rolUsuario = $user->role;

            }

            if($rolUsuario == "APOYO"){
                return view('restringidos/no_autorizado');
            }else{
                        $cuartel = DB::table('cuartel')
                        ->select('cuartel.id', 'cuartel.codigo as codigo')
                        // ->select('cuartel.id', DB::raw("CONCAT(codigo,' - ',nombre) as codigo"))
                        ->where('estado', '=', 'ACTIVO')
                        ->get();
                // dd( $cuartel);
                        $bloque= DB::table('bloque')
                        ->select('bloque.id', 'bloque.codigo')
                        ->where('estado', '=', 'ACTIVO')
                        ->get();
                       // dd( $request->select_cuartel_searc);

                if(($request->select_cuartel_search==null  || !isset($request->select_cuartel_search) )){
                    $letter="A";

                    $nicho = DB::table('nicho')
                    ->select(
                        'nicho.*',
                        'cuartel.codigo as cuartel_cod',
                        'bloque.codigo as bloque_id',
                        DB::raw("
                            CASE
                                WHEN nicho.estado_nicho = 'LIBRE' THEN ''
                                ELSE CONCAT(difunto.nombres, ' ', difunto.primer_apellido, ' ', difunto.segundo_apellido)
                            END as difunto
                        ")
                    )
                    ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
                    ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
                    ->leftJoin('responsable_difunto', function($join) {
                        $join->on('responsable_difunto.codigo_nicho', '=', 'nicho.codigo')
                             ->where('nicho.estado_nicho', '<>', 'LIBRE');
                    })
                    ->leftJoin('difunto', function($join) {
                        $join->on('difunto.id', '=', 'responsable_difunto.difunto_id')
                             ->where('nicho.estado_nicho', '<>', 'LIBRE');
                    })
                    ->where('nicho.estado', '=', 'ACTIVO')
                    ->where('nicho.codigo', 'ILIKE', $letter . '%')
                    ->get();

                }else{
                    // dd($request->select_cuartel_search);

                    if($request->select_cuartel_search=="todos"){
                        $nicho = DB::table('nicho')
                        ->select(
                            'nicho.*',
                            'cuartel.codigo as cuartel_cod',
                            'bloque.codigo as bloque_id',
                            DB::raw("
                                CASE
                                    WHEN nicho.estado_nicho = 'LIBRE' THEN ''
                                    ELSE CONCAT(difunto.nombres, ' ', difunto.primer_apellido, ' ', difunto.segundo_apellido)
                                END as difunto
                            ")
                        )
                        ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
                        ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
                        ->leftJoin('responsable_difunto', function($join) {
                            $join->on('responsable_difunto.codigo_nicho', '=', 'nicho.codigo')
                                 ->where('nicho.estado_nicho', '<>', 'LIBRE');
                        })
                        ->leftJoin('difunto', function($join) {
                            $join->on('difunto.id', '=', 'responsable_difunto.difunto_id')
                                 ->where('nicho.estado_nicho', '<>', 'LIBRE');
                        })
                        ->where('nicho.estado', '=', 'ACTIVO')
                        ->get();


                    }else{
                            $c=Cuartel::where('id',$request->select_cuartel_search)->where('estado', 'ACTIVO')->first();
                            $letter=$c->codigo;

                            $nicho = DB::table('nicho')
                                ->select(
                                    'nicho.*',
                                    'cuartel.codigo as cuartel_cod',
                                    'bloque.codigo as bloque_id',
                                    DB::raw("
                                        CASE
                                            WHEN nicho.estado_nicho = 'LIBRE' THEN ''
                                            ELSE CONCAT(difunto.nombres, ' ', difunto.primer_apellido, ' ', difunto.segundo_apellido)
                                        END as difunto
                                    ")
                                )
                                ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
                                ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
                                ->leftJoin('responsable_difunto', function($join) {
                                    $join->on('responsable_difunto.codigo_nicho', '=', 'nicho.codigo')
                                        ->where('nicho.estado_nicho', '<>', 'LIBRE');
                                })
                                ->leftJoin('difunto', function($join) {
                                    $join->on('difunto.id', '=', 'responsable_difunto.difunto_id')
                                        ->where('nicho.estado_nicho', '<>', 'LIBRE');
                                })
                                ->where('nicho.estado', '=', 'ACTIVO')
                                ->where('nicho.codigo', 'ILIKE', $letter . '%')
                                ->get();
                        }

                }

                       return view('nicho/index', ['bloque' =>$bloque , 'cuartel' => $cuartel , 'nicho' => $nicho]);
            }
    }

    public function createNewNicho(Request $request){

        if($request->isJson()){

            $this->validate($request, [
                'bloque' => 'required',
                'codigo' => 'required|unique:nicho',
                'cuartel' => 'required',
                'tipo' => 'required',
                'fila' => 'required',
                 'nro' => 'required',
                'cantidad' => 'required',
                'estado' => 'required'
            ], [
                'bloque.required'  => 'El campo bloque  es obligatorio!',
                'codigo.required'  => 'El campo codigo  es obligatorio!',
                'cuartel.required' => 'El campo  cuartel es obligatorio!',
                'nro.required' => 'El campo Nro  es obligatorio!',
                'fila.required' => 'El campo fila  es obligatorio!',
                'cantidad.required' => 'El campo cantidad de cuerpos  es obligatorio!',
                'tipo.required' => 'El campo tipo nicho  es obligatorio!',
                'codigo.unique' => 'El código '.$request->codigo.' ya se encuentra en uso!.'
            ]);

           $rep= $this->repetidoins(  $request->nro , $request->cuartel,$request->bloque);
           // dd($rep);

            if($rep=="no"){
                            $new_nicho =  Nicho::create([
                                'codigo' => trim($request->codigo),
                                'bloque_id' => trim($request->bloque),
                                'cuartel_id' => trim($request->cuartel),
                                'nro_nicho' => trim($request->nro),
                                'fila' => trim($request->fila),

                                'codigo' => trim($request->codigo),
                                'codigo_anterior' => trim($request->codigo_anterior),
                                'cantidad_cuerpos' => trim($request->cantidad),
                                'tipo' => trim($request->tipo),
                                //'estado_nicho' => trim($request->estado_nicho),
                                'estado' => trim($request->estado),

                                'user_id' => auth()->id(),
                                'estado' => 'ACTIVO',
                                'created_at' => date("Y-m-d H:i:s"),
                                'updated_at' => date("Y-m-d H:i:s"),
                            ]);


                                return response([
                                    'status'=> true,
                                    'response'=> $new_nicho
                                ],201);
                        }

                            else{
                                return response([
                                    'status'=> false,
                                    'message'=> 'Error, codigo existente, duplicado!)'
                                ],400);
                            }
                }
        }


    public function getNicho($id){

        $nicho =  Nicho::where('nicho.id', $id)
        ->join('bloque', 'bloque.id', '=', 'nicho.bloque_id')
        ->join('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
        ->select('nicho.*', 'bloque.codigo as bloque', 'bloque.id as bloque_id', 'cuartel.codigo as cuartel', 'cuartel.id as cuartel_id')
        ->first();
               return response([
                'status'=> true,
                'response'=> $nicho
             ],200);
    }


    public function updateNicho(Request $request){
       // dd($request);
        $this->validate($request, [
            'bloque' => 'required',
            'cuartel' => 'required',
            'codigo' => 'required',
            'fila' => 'required',
            'cantidad' => 'required',
            'tipo' => 'required',
            // 'estado' => 'required',
            'id' => 'required'
        ], [
            'bloque.required'  => 'El campo bloque es obligatorio!',
            'codigo.required'  => 'El campo codigo de nicho es obligatorio!',
            'cuartel.required'  => 'El campo cuartel de bloque es obligatorio!',
            'fila.required'  => 'El campo fila es obligatorio!',
            'nro.required'  => 'El campo nro nicho es obligatorio!',
            'cantidad.required'  => 'El campo cantidad es obligatorio!',
            'tipo.required'  => 'El campo tipo de nicho es obligatorio (temporal o perpetuo)!',
            // 'estado.required'  => 'El campo cuartel de bloque es obligatorio!'
        ]);
       $rep= $this->repetido( $request->id, $request->nro , $request->cuartel,$request->bloque);


      if($rep=="no"){
        $nicho =  Nicho::where('id', $request->id)
        ->update([
            'bloque_id' => $request->bloque,
            'cuartel_id' => $request->cuartel,
            'nro_nicho' => $request->nro,
            'fila' => $request->fila,
            'cantidad_cuerpos' => $request->cantidad,
            'codigo_anterior' => $request->anterior,
            'codigo' => $request->codigo,
            'tipo' => $request->tipo,

            'estado_nicho'=>$request->estado_nicho,
            'user_id' => auth()->id(),
            'estado' => $request->estado,
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
    public function repetido($id, $codigo,$cuartel,$bloque){
        $repetido =  DB::table('nicho')
                    ->where('id', '!=', $id)
                    ->where('nro_nicho', '=', ''.$codigo.'')
                    ->where('cuartel_id', '=', ''.$cuartel.'')
                    ->where('bloque_id', '=', ''.$bloque.'')
                    ->first();
            if($repetido==null){
                return $resp="no";
            }
            else{
               return $resp="si";
            }

    }
    public function repetidoins( $codigo,$cuartel,$bloque){
        $repetido =  DB::table('nicho')
                    ->where('nro_nicho', '=', ''.$codigo.'')
                    ->where('cuartel_id', '=', ''.$cuartel.'')
                    ->where('bloque_id', '=', ''.$bloque.'')
                    ->first();
            if($repetido==null){
                return $resp="no";
            }
            else{
               return $resp="si";
            }

    }
    public function getBloqueid(Request $request){

        $bloque = DB::table('bloque')
        ->select('bloque.id','bloque.codigo as codigo')
        //->select('bloque.id', DB::raw("CONCAT(codigo,' - ',nombre) as codigo"))
        ->where('estado', '=', 'ACTIVO')
        ->where('cuartel_id', '=', $request->cuartel)
        ->get();

               return response([
                'status'=> true,
                'response'=> $bloque
             ],200);

    }

    public function liberarNicho(Request $request){
        // dd("legaaaaaaaaaaaaaaa");
        $n=new Nicho;
        $n->liberarNicho($request);
        return redirect()->route('nicho');
    }

    public function liberarNichoServicio(Request $request){

        $nicho = DB::table('nicho')
        ->select('nicho.id')
        ->where('nicho.codigo', '=', $request->codigo_nicho)
        ->orderBy('id', 'desc')
        ->first();
        if ($nicho) {
            $nicho_id = $nicho->id;
            $data= Nicho::where('id',$nicho_id)->first();
            $data->estado_nicho="LIBRE";
            $data->cantidad_anterior=$data->cantidad_cuerpos;
            $data->cantidad_cuerpos=0;
            $data->save();
            $ni=New Nicho();
            $desv=$ni->desvincularDifuntoNicho($request);
            return response([
                'success' => true,
                'message' => 'El nicho se ha liberado correctamente',
                'data' => $desv
            ], 200);

        } else {
            // Manejar el caso en el que no se encontró ningún registro
            return response([
                'success' => false,
                'message' => 'Hubo un error al liberar el nicho, o el nicho se encuentra libre',
                'data' => null
            ], 201);


        }



    }
    public function formEstadoNicho(Request $request){
        return view('nicho.form_report');
    }
    // public function imprimirReporteNicho(Request $request){
    //     $nicho_estado= $request->estado_nicho;
    //     $nicho = DB::table('nicho')
    //     ->leftJoin('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
    //     ->leftJoin('bloque', 'bloque.id', '=', 'nicho.bloque_id')
    //     ->select('nicho.*', 'cuartel.codigo as cuartel', 'bloque.codigo as bloque')
    //     ->where('nicho.estado_nicho', '=', $request->estado_nicho)
    //     ->where('nicho.estado', 'ACTIVO')
    //     ->orderBy('id', 'asc')
    //     ->get();


    //     $pdf = new PDF();
    //     if($nicho_estado=="OCUPADO"){
    //         $pdf = PDF::loadView('nicho/reportNichoOcupado', compact('nicho', 'nicho_estado'))->setPaper('a4');
    //     }else{
    //         $pdf = PDF::loadView('nicho/reportNichoLibre', compact('nicho', 'nicho_estado'))->setPaper('a4');
    //     }

    //     return  $pdf-> stream("Lista_nichos".$request->estado_nicho.".pdf", array("Attachment" => false));
    // }


    public function imprimirReporteNicho(Request $request)
    {
        $nicho_estado = $request->estado_nicho;

        $query = DB::table('nicho')
            ->leftJoin('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
            ->leftJoin('bloque', 'bloque.id', '=', 'nicho.bloque_id')
            ->select('nicho.id', 'nicho.codigo','nicho.nro_nicho', 'nicho.fila','nicho.tipo','nicho.estado_nicho','nicho.codigo_anterior','nicho.cantidad_cuerpos', 'nicho.estado', 'cuartel.codigo as cuartel', 'bloque.codigo as bloque')
            ->where('nicho.estado_nicho', '=', $nicho_estado)
            ->where('nicho.estado', '=', 'ACTIVO')
            ->orderBy('nicho.id', 'asc');

        $nicho = $query->get();

        if($nicho_estado=="OCUPADO"){
             $html = view('nicho/reportNichoOcupado', compact('nicho'))->render();
         }else{
            $html = view('nicho/reportNichoLibre', compact('nicho'))->render();

                }




        // Crear una instancia de Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Devolver el PDF como respuesta
        return Response::make($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="reporte_nichos.pdf"',
        ]);
    }


}
