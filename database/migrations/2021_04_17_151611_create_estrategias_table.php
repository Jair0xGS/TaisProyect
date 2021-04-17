<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstrategiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estrategias', function (Blueprint $table) {
            $table->id();
            $table->string("nombre");
            $table->unsignedBigInteger('mapa_estrategico_id');
            $table->foreign('mapa_estrategico_id')->references('id')->on('mapa_estrategicos');
            $table->unsignedBigInteger('perspectiva_id');
            $table->foreign('perspectiva_id')->references('id')->on('perspectivas');
            $table->unsignedBigInteger('relacion_id');
            $table->foreign('relacion_id')->references('id')->on('relacions');
            $table->unsignedBigInteger('estrategia_id')->nullable();
            $table->foreign('estrategia_id')->references('id')->on('estrategias');

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
        Schema::dropIfExists('estrategias');
    }
}
