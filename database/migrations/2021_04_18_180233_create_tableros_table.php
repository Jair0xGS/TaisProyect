<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablerosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tableros', function (Blueprint $table) {
            $table->id();
            $table->string("descripcion");
            $table->string("frecuencia");
            $table->text("iniciativas");
            $table->float("rojo");
            $table->float("amarillo");
            $table->float("verde");
            $table->string("verde_operador");
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
        Schema::dropIfExists('tableros');
    }
}
