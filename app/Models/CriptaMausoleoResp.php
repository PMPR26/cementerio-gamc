<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CriptaMausoleoResp extends Model
{
    use HasFactory;
    protected $table = 'cripta_mausoleo_responsable';
    protected $fillable = [
        'responsable_id',
        'cripta_mausole_id',
        'estado',
        'created_at'
    ];
}
