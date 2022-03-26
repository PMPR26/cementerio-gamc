<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDifuntoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('difunto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ci',10);           
            $table->string('nombres',10);
            $table->string('primer_apellido',10);
            $table->string('segundo_apellido',10);
            $table->date('fecha_nacimiento');
            $table->date('fecha_defuncion');
            $table->string('certificado_defuncion');           
            $table->string('causa');
            $table->string('tipo');         
            $table->integer('user_id');
            $table->string('estado',10)->default('ACTIVO');
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
        Schema::dropIfExists('difunto');
    }
}
