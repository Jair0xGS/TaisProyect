<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndicadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicadors', function (Blueprint $table) {
            $table->id();
            $table->string("descripcion");
            $table->text("objeto_medicion");
            $table->text("mecanismo");
            $table->float("tolerancia");
            $table->text("objetivo");
            $table->string("unidad");
            $table->string("formula");
            $table->unsignedBigInteger('formula_id');
            $table->foreign('formula_id')->references('id')->on('formulas');
            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');
            $table->unsignedBigInteger('proceso_id')->nullable();
            $table->foreign('proceso_id')->references('id')->on('procesos');
            $table->unsignedBigInteger('personal_id')->nullable();
            $table->foreign('personal_id')->references('id')->on('personals');

            $table->string("numerador");
            $table->string("denominador");
            $table->string("condicion1")->nullable();
            $table->string("condicion2")->nullable();
            $table->string("condicion3")->nullable();
            $table->unsignedBigInteger('campo1_id')->nullable();
            $table->unsignedBigInteger('campo2_id')->nullable();
            $table->unsignedBigInteger('campo3_id')->nullable();

            $table->foreign('campo1_id')->references('id')->on('campos');
            $table->foreign('campo2_id')->references('id')->on('campos');
            $table->foreign('campo3_id')->references('id')->on('campos');

            $table->unsignedBigInteger('tabla1_id');
            $table->unsignedBigInteger('tabla2_id');

            $table->foreign('tabla1_id')->references('id')->on('tablas');
            $table->foreign('tabla2_id')->references('id')->on('tablas');
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
        Schema::dropIfExists('indicadors');
    }
}
