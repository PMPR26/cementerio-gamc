<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class Tipo_notificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('tipo_notificacions')->insert([
            'nombre_notificacion' => 'LAPIDA ILEGAL',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);

        DB::table('tipo_notificacions')->insert([
            'nombre_notificacion' => 'NICHOS ANTIGUOS',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);

        DB::table('tipo_notificacions')->insert([
            'nombre_notificacion' => 'MAUSOLEOS PARA PAGO TASAS DE MANTENIMIENTO',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);

        DB::table('tipo_notificacions')->insert([
            'nombre_notificacion' => 'CONSERVACION MAUSOLEO CRIPTAS',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);

        DB::table('tipo_notificacions')->insert([
            'nombre_notificacion' => 'SUSPENCION DE TRABAJOS',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);

        DB::table('tipo_notificacions')->insert([
            'nombre_notificacion' => 'DOCUMENTOS',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);

        DB::table('tipo_notificacions')->insert([
            'nombre_notificacion' => 'ARREGLO MAUSOLEO',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);


        DB::table('tipo_notificacions')->insert([
            'nombre_notificacion' => 'REVERSION DE SITIOS',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);

    }
}
