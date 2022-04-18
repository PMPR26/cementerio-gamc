<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioNichoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_nicho', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo_nicho',20);           
            $table->date('fecha_registro');     
            $table->string('tipo_servicio_id',30);           
            $table->string('tipo_servicio',200);           
            $table->string('servicio_id',30);           
            $table->string('servicio',200); 
            $table->unsignedBigInteger('responsable_difunto_id');
            $table->integer('fur');
            $table->timestamp('fecha_pago')->nullable();
            $table->integer('id_usuario_caja')->nullable(); 
            $table->integer('nro_renovacion')->nullable();
            $table->string('monto_renovacion')->nullable();
            $table->string('monto'); 
            $table->string('nombrepago');
            $table->string('paternopago');
            $table->string('maternopago')->nullable();
            $table->string('ci');
            $table->string('pago_por')->nullable();
            $table->string('observacion')->nullable();
            $table->boolean('estado_pago')->default(false);           
            $table->string('estado',10)->default('ACTIVO');
            $table->timestamps();     


            $table->foreign('responsable_difunto_id')->references('id')->on('responsable_difunto');
          
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio_nicho');
    }
}
