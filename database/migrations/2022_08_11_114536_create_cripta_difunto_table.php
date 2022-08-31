<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriptaDifuntoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cripta_difunto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('difunto_id');
            $table->integer('cripta_mausoleo_id');
            $table->string('estado')->default('ACTIVO');
            $table->timestamps();
            $table->foreign('difunto_id')->references('id')->on('difunto');   
            $table->foreign('cripta_mausoleo_id')->references('id')->on('cripta_mausoleo'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cripta_difunto');
    }
}
