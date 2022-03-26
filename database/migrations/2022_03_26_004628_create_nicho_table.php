<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNichoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nicho', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cuartel_id');
            $table->integer('bloque_id');
            $table->string('nro_nicho',10);
            $table->integer('fila');
            $table->integer('columna');
            $table->string('codigo',10)->unique();
            $table->string('codigo_anterior',10);
            $table->integer('cantidad_cuerpos');
            $table->string('tipo',20);
            $table->enum('estado_nicho', ['LIBRE', 'OCUPADO'])->nullable(); //PREGUNTAR A RICKY
            $table->string('estado',10)->default('ACTIVO');
            $table->integer('user_id');
            $table->timestamps();

            $table->foreign('cuartel_id')->references('id')->on('cuartel');
            $table->foreign('bloque_id')->references('id')->on('bloque');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nicho');
    }
}
