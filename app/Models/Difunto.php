<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Difunto extends Model
{
    use HasFactory;

    protected $table = 'difunto';
    protected $fillable = [
        'ci',
        'nombres',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'fecha_defuncion',
        'certificado_defuncion',
        'causa',
        'tipo',
        'genero',
        'certificado_file',
        'estado',
        'user_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];

}
