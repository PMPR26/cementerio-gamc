<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class CenizariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cenizarios')->insert([
            'bloque' => '61C',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);
        DB::table('cenizarios')->insert([
            'bloque' => '62C',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);
        DB::table('cenizarios')->insert([
            'bloque' => '64C',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);
        DB::table('cenizarios')->insert([
            'bloque' => '66C',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);
        DB::table('cenizarios')->insert([
            'bloque' => '60Y',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);
        DB::table('cenizarios')->insert([
            'bloque' => '60Z',
            'estado' => 'ACTIVO',
            'created_at' => now()
        ]);
    }
}
