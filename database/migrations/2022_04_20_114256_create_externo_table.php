<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExternoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('externo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('responsable_id'); 
            $table->integer('difunto_id');                   
            $table->string('tipo_servicio_id');                   
            $table->text('tipo_servicio');                   
            $table->string('servicio_id');                   
            $table->text('servicio');  
            $table->integer('fur');
            $table->string('nombre',100);
            $table->decimal('superficie', 8, 2);
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
        Schema::dropIfExists('externo');
    }
}
