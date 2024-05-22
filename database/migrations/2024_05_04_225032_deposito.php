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
            $table->string('cuartel');
            $table->string('bloque');
            $table->string('nicho');
            $table->string('fila');
            $table->string('nombre_difunto');
            $table->string('impuesto');
            $table->string('lapida');
            $table->text('observacion');
            $table->date('fecha_salida_sitio')->nullable();
            $table->date('fecha_ingreso_deposito')->nullable();
            $table->integer('cant_cuotas_adeudadas')->nullable();
            $table->string('precio_unitario')->nullable();
            $table->string('total_adeudado')->nullable();
            $table->integer('fur')->nullable() ;
            $table->date('fecha_pago')->nullable();
            $table->text('glosa')->nullable();
            $table->string('nombre_pago')->nullable();
            $table->string('primer_apellido_pago')->nullable();
            $table->string('segundo_apellido_pago')->nullable();
            $table->string('ci_pago')->nullable();
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
