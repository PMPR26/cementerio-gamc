<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriptaMausoleoResponsableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cripta_mausoleo_responsable', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('responsable_id');
            $table->integer('cripta_mausole_id');
            $table->integer('ultima_gestion_pagada')->nullable();
            $table->string('estado')->default('ACTIVO');
            $table->timestamps();
            $table->foreign('responsable_id')->references('id')->on('responsable');   
            $table->foreign('cripta_mausole_id')->references('id')->on('cripta_mausoleo'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cripta_mausoleo_responsable');
    }
}
