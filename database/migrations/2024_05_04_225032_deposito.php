<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Deposito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposito', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_sitio');
            $table->string('nombre_difunto');
            $table->date('fecha_salida_sitio');
            $table->date('fecha_ingreso_deposito');
            $table->text('detalle_ingreso');
            $table->integer('cant_cuotas_adeudadas');
            $table->string('precio_unitario');
            $table->string('total_adeudado');
            $table->integer('fur')->nullable() ;
            $table->date('fecha_pago')->nullable();
            $table->text('glosa')->nullable();
            $table->string('responsable_pago')->nullable();
            $table->string('ci_responsable_pago')->nullable();
            $table->string('estado_pago')->nullable();
            $table->integer('user_id')->default(auth()->id());
            $table->string('estado')->default('ACTIVO');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposito');
    }
}
