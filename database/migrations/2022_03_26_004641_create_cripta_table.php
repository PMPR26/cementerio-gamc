<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriptaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cripta_mausoleo', function (Blueprint $table)
         {
            $table->bigIncrements('id');
            $table->integer('cuartel_id');
            $table->integer('bloque_id')->nullable(); 
            $table->string('sitio'); 
            $table->string('codigo',10);
            $table->decimal('superficie', 8, 2);
            // $table->integer('responsable_id',150)->nullable();
            // $table->string('paterno',150);
            // $table->string('materno',150)->nullable();
            // $table->string('dni',150)->nullable();
            $table->text('foto')->nullable();
            $table->integer('ocupados')->nullable();
            $table->integer('perpetuos')->nullable();
            $table->integer('osarios')->nullable();
            $table->integer('total_cajones')->nullable();
            $table->string('estado_construccion')->nullable();
            $table->text('observaciones')->nullable();       
            $table->string('estado',10)->default('ACTIVO');
            $table->string('tipo_registro'); 
            $table->string('codigo_antiguo')->nullable(); 
            $table->integer('user_id');
            $table->timestamps();
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
        Schema::dropIfExists('cripta_mausoleo');
    }
}
