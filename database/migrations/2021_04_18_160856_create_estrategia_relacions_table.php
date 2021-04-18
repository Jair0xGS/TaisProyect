<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstrategiaRelacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estrategia_relacions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estrategia_id')->nullable();
            $table->foreign('estrategia_id')->references('id')->on('estrategias');

            $table->unsignedBigInteger('estrategia_to_id')->nullable();
            $table->foreign('estrategia_to_id')->references('id')->on('estrategias');

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
        Schema::dropIfExists('estrategia_relacions');
    }
}
