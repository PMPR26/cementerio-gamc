<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cripta extends Model
{
    use HasFactory;

    protected $table = 'cripta_mausoleo';
    protected $fillable = [
        'cuartel_id',
        'bloque_id',
        'sitio',
        'codigo',
        'nombre',
        'superficie',
        'estado',
        'tipo_registro',
        'user_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];

}
