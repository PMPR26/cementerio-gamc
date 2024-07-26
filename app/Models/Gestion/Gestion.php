<?php

namespace App\Models\Gestion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;
    protected $table = 'gestion';
    protected $fillable = [
        'gestion',
        'estado'
    ];

    protected $hiden = [
        'id',
        'updated_at'
    ];

}
