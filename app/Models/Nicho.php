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
}
