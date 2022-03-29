<?php

namespace App\Models\Servicios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioNicho extends Model
{
    use HasFactory;


    protected $table = 'servicio_nicho';
     
    protected $fillable = [
        'codigo_nicho',
        'fecha_registro',
        'tipo_servicio_id',
        'servicio_id',
        'servicio',
        'responsable_difunto_id',
        'fur',
        'gestion_pagada',
        'fecha_pago',
        'estado_pago',
        'user_id',
        'estado',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];


}
