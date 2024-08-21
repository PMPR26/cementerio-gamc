<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloqueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloque', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cuartel_id');
            $table->string('codigo',10);
            $table->string('nombre',100);
            $table->string('estado',10)->default('ACTIVO');
            $table->integer('user_id');
            $table->timestamps();

            $table->foreign('cuartel_id')->references('id')->on('cuartel');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bloque');
    }
}
