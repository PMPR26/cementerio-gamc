<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMDifunto extends Model
{
    use HasFactory;

    protected $table = 'cripta_mausoleo_difunto';
    protected $fillable = [
        'responsable_id',
        'cripta_mausole_id',
        'estado',
        'ultima_gestion_pagada',       
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];
}
