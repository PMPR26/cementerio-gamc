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

    public function generateCiDifunto(){

        $ci = Difunto::select('ci')
                ->where('ci', 'ilike', "%SCD-0%")
                ->orderBy('ci', 'DESC')
                ->first();

         if($ci){
            $number = (int) str_replace('-','',filter_var($ci, FILTER_SANITIZE_NUMBER_INT)) + 1;
            return 'SCD-'.str_pad($number, 4, '0', STR_PAD_LEFT);
         }else{
             return 'SCD-0001';
         }   
    }

}
