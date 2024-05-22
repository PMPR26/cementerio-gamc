<?php

namespace App\Models\Deposito;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositoModel extends Model
{
    protected $table = 'deposito';
    protected $fillable = [
        'cuartel',
        'bloque',
        'nicho',
        'fila',
        'nombre_difunto',
        'impuesto',
        'lapida',
        'observacion',

        'fecha_salida_sitio',
        'fecha_ingreso_deposito',
        'cant_cuotas_adeudadas',
        'precio_unitario',
        'total_adeudado',
        'fur',
        'fecha_pago',
        'glosa',
        'nombre_pago',
        'primer_apellido_pago',
        'segundo_apellido_pago',
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
