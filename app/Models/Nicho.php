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
        // dd($request->id);

        // $nicho=New Nicho;
        $data= Nicho::where('id', $id)->first();
        $data->estado_nicho="LIBRE";
        $data->cantidad_anterior=$data->cantidad_cuerpos;
        $data->cantidad_cuerpos=0;
        $data->save();
        //desvincular registro

       $desv= $this->desvincularDifuntoNichoAsignacion($codigo_nicho);
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
        }

       return true;
    }


    public function generarCodigoAsignacion($cuartel, $bloque, $nicho, $fila){
        $c=Cuartel::where('id', $cuartel)->first();
        $b=Bloque::where('id', $bloque)->first();
        $codigo_nuevo_nicho=$c->codigo.".".$b->codigo.".".$nicho.".".$fila;

        $nicho= Nicho::where('codigo', $codigo_nuevo_nicho )->first();
        return ($nicho);
    }



}
