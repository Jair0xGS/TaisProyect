<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParametrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parametros', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->boolean("is_numerador");
            $table->string("condicion")->nullable();
            $table->unsignedBigInteger('campo_id')->nullable();
            $table->foreign('campo_id')->references('id')->on('campos');
            $table->unsignedBigInteger('tabla_id');
            $table->foreign('tabla_id')->references('id')->on('tablas');
            $table->unsignedBigInteger('indicador_id');
            $table->foreign('indicador_id')->references('id')->on('indicadors');

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
        Schema::dropIfExists('parametros');
    }
}
