<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mausoleo extends Model
{
    use HasFactory;
    protected $table = 'mausoleo';
    protected $fillable = [
        'cuartel_id',
        'codigo',
        'nombre',
        'superficie',
        'estado',
        'user_id',
        'created_at'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];
}
