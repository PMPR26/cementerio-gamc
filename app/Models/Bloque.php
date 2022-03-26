<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloque extends Model
{
    use HasFactory;


    protected $fillable = [
        'codigo',
        'nombre',
        'user_id',
        'estado',
        'cuartel',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];
}
