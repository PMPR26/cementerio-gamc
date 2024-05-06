<?php

namespace App\Models\Deposito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositoModel extends Model
{
    protected $table = 'deposito';
    protected $fillable = [
        'codigo_sitio',
        'nombre_difunto',
        'fecha_salida_sitio',
        'fecha_ingreso_deposito',
        'detalle_ingreso',
        'cant_cuotas_adeudadas',
        'precio_unitario',
        'total_adeudado',
        'fur',
        'fecha_pago',
        'glosa',
        'responsable_pago',
        'ci_responsable_pago',
        'estado_pago',
        'user_id',
        'estado',
        'created_at'
    ];

    protected $hidden = [ // Corregido 'hiden' a 'hidden'
        'id',
        'updated_at'
    ];
    public static function insertDeposito($data)
    {
        return self::create($data);
    }
}
