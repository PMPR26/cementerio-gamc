<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
