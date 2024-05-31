<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class Nicho extends Model
{
    use HasFactory;

    protected $table = 'nicho';
    protected $fillable = [
        'codigo',
        'cuartel_id',
        'bloque_id',
        'fila',
        'columna',
        'nro_nicho',
        'cantidad_cuerpos',
        'codigo_anterior',

        'tipo',
        'user_id',
        'estado',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];

    public function InfoNicho($nro_nicho, $fila, $bloque){
        // dd(  $bloque);


        $bloque_cod=Bloque::where('codigo','=', $bloque)->select()->first();
                $sql=Nicho::whereRaw('nro_nicho=\''.trim($nro_nicho).'\'')
        ->whereRaw('fila=\''.trim($fila).'\'')
        ->whereRaw('bloque_id=\''.trim( $bloque_cod->id).'\'')
        ->leftJoin('cuartel', 'cuartel.id', '=', 'nicho.cuartel_id')
        ->select()->first();
        return $sql;
    }

    public function liberarNicho(Request $request){
        // dd($request->id);

        // $nicho=New Nicho;
        $data= Nicho::where('id', $request->id)->first();
        $data->estado_nicho="LIBRE";
        $data->cantidad_anterior=$data->cantidad_cuerpos;
        $data->cantidad_cuerpos=0;
        $data->save();
        //desvincular registro

       $desv= $this->desvincularDifuntoNicho($request);
        return $desv;

    }



     //desvincular responsable
     public function desvincularDifuntoNicho(Request $request){
        // dd( $request);

        $resp=New ResponsableDifunto;
        // buscar relacion del nicho con difunto y desvincular inactivando

        $rd=$resp::where('codigo_nicho', ''.trim((string)$request->codigo_nicho.''))
        ->where('estado', "ACTIVO")
        ->orderBy('id', "desc")
        ->first();
        // dd( $rd);

        if(!empty($rd)){
            $rd->estado="INACTIVO";
            $rd->fecha_liberacion=\Carbon\Carbon::now();
            $rd->gestion_renov=null;
            $rd->nro_renovacion=0;
            $rd->estado_nicho="LIBRE";
            $rd->monto_ultima_renov=0;
            $rd->user_id=Auth::user()->id;
            $rd->save();
        }

       return true;
    }
    public function liberarNichoAsignacion($id, $codigo_nicho){
        //  dd($id);

        // $nicho=New Nicho;
        $data= Nicho::where('id', $id)->first();
        $data->estado_nicho="LIBRE";
       // $data->cantidad_anterior=$data->cantidad_cuerpos;
       if($data->cantidad_cuerpos>0){
        $data->cantidad_cuerpos= $data->cantidad_cuerpos-1;
       }else{
        $data->cantidad_cuerpos=0;
       }

    //    dd( $data->cantidad_cuerpos);

        $data->save();
        //desvincular registro

       $desv= $this->desvincularDifuntoNichoAsignacion($codigo_nicho);
       //$desv_resp= $this->desvincularResponsableDifuntoNichoAsignacion($id,$codigo_nicho);

        return $desv;

    }

     //desvincular responsable
     public function desvincularDifuntoNichoAsignacion($codigo){
        // dd( $request);

        $resp=New ResponsableDifunto;
        // buscar relacion del nicho con difunto y desvincular inactivando

        $rd=$resp::where('codigo_nicho', ''.trim((string)$codigo.''))
        ->where('estado', "ACTIVO")
        ->orderBy('id', "desc")
        ->first();
        // dd( $rd);

        if(!empty($rd)){
            $rd->estado="INACTIVO";
            $rd->fecha_liberacion=\Carbon\Carbon::now();
            $rd->gestion_renov=null;
            $rd->nro_renovacion=0;
            $rd->estado_nicho="LIBRE";
            $rd->monto_ultima_renov=0;
            $rd->user_id=Auth::user()->id;
            $rd->save();
            $resp_dif=ResponsableDifunto::where('id', $rd->responsable_id)
            ->update(['estado'=>'INACTIVO']);
        }

       return true;
    }

    public function desvincularResponsableDifuntoNichoAsignacion($codigo){
        // dd( $request);

        $resp=New ResponsableDifunto;
        // buscar relacion del nicho con difunto y desvincular inactivando

        $rd=$resp::where('codigo_nicho', ''.trim((string)$codigo.''))
        ->where('estado', "ACTIVO")
        ->orderBy('id', "desc")
        ->first();
        // dd( $rd);

        if(!empty($rd)){
            $rd->estado="INACTIVO";
            $rd->fecha_liberacion=\Carbon\Carbon::now();
            $rd->gestion_renov=null;
            $rd->nro_renovacion=0;
            $rd->estado_nicho="LIBRE";
            $rd->monto_ultima_renov=0;
            $rd->user_id=Auth::user()->id;
            $rd->save();
        }

       return true;
    }

    public function generarCodigoAsignacion($cuartel, $bloque, $nro_nicho, $fila){

        $c=Cuartel::where('id', $cuartel)->first();
        $b=Bloque::where('id', $bloque)->first();
        $codigo_nuevo_nicho=$c->codigo.".".$b->codigo.".".$nro_nicho.".".$fila;


        $nicho= Nicho::where('codigo', $codigo_nuevo_nicho )->first();

        if(empty($nicho)|| $nicho=="" ||  $nicho==null){
            $ni=$this->InsertNichoPartial( $cuartel,  $bloque, $nro_nicho, $fila, 'PERPETUO','LIBRE', 0, 0, '');
            $nicho= Nicho::where('id', $ni )->first();
        }

        if($nicho){
            return response([
                'status'=> true,
                'nicho'=> $nicho,
             ],200);
        }
        else{
            return response([
                'status'=> false,
                'codigo_nuevo_nicho'=> null,
                'message'=> 'El nicho al que esta asignando aun no esta registrado, por favor dirijase a la ficha nichos y registre el nicho previamente.'
             ],201);

        }
    }

    public function CambiarEstadoNicho( $id,$est, $cantidad){
        $nicho=Nicho::where('id',$id)->first();
        $nicho->estado_nicho= $est;
        $nicho->cantidad_cuerpos=$cantidad;
        $nicho->save();
        return $nicho->estado_nicho;

    }

    public function restaurarRenov($id_nicho, $renov_ant,  $monto_renov_anterior){
        $nicho=Nicho::where('id',$id_nicho)->first();
        $nicho->renovacion= $renov_ant;
        $nicho->monto_renov= $monto_renov_anterior;
        $nicho->save();

    }
    public function InsertNichoPartial( $id_cuartel,  $id_bloque,  $nro_nicho, $fila, $tipo_nicho,$estado_nicho, $cant, $cant_ant, $anterior){
          // insertar nicho
          $cuartel=Cuartel::where('id', $id_cuartel)->first();
          $bloque=Bloque::where('id', $id_bloque)->first();


          $nicho = new Nicho;
          $nicho->cuartel_id = $id_cuartel;
          $nicho->bloque_id = $id_bloque;
          $nicho->nro_nicho = $nro_nicho;
          $nicho->fila = $fila;
          $nicho->codigo = $cuartel->codigo . "." . $bloque->codigo . "." . $nro_nicho . "." . $fila;
          $nicho->tipo = $tipo_nicho ?? '';
        //   $nicho->codigo = $cuartel . "." . $bloque . "." . $nro_nicho . "." . $fila;
          $nicho->codigo_anterior = $anterior ?? '';
          $nicho->estado_nicho =$estado_nicho;
          $nicho->estado ='ACTIVO';
          $nicho->cantidad_cuerpos =$cant ?? 0;
          $nicho->cantidad_anterior =$cant_ant?? 0 ;
          $nicho->user_id = auth()->id();
          $nicho->save();
          $nicho->id;
          $id_nicho = $nicho->id;
          return $id_nicho;
    }
          public function InsertNicho(Request $request){
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
        $id_nicho = $new_nicho->id;
        return $id_nicho;

    }


}
