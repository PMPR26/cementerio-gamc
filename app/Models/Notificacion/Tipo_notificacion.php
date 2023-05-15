<?php

namespace App\Models\Notificacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_notificacion extends Model
{
    use HasFactory;
    protected $table = 'tipo_notificacions';
    protected $fillable = [
        'nombre_notificacion',
        'contenido',
        'gestion',
        'estado'
    ];
    protected $hiden = [
        'id',
        'updated_at'
    ];
}


