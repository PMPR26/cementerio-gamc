<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    use HasFactory;

    protected $table = 'responsable';
    protected $fillable = [
        'ci',
        'nombres',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'telefono',
        'celular',
        'estado_civil',
        'email',
        'domicilio',
        'estado',
        'user_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];

}
