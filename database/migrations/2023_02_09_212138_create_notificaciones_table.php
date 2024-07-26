<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('ubicacion_id');
            $table->string('ubicacion_codigo');
            $table->string('ubicacion_tipo');
            $table->integer('tipo_notificacion_id');
            $table->integer('nro_notificacion');
            $table->date('fecha_notificacion');
            $table->text('contenido_notificacion');
            $table->text('adicional');
            $table->text('observacion');
            $table->string('foto_constancia')->nullable();
            $table->integer('gestion');
            $table->string('estado');
            $table->timestamps();
            $table->foreign('tipo_notificacion_id')->references('id')->on('tipo_notificacions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notificaciones');
    }
}
