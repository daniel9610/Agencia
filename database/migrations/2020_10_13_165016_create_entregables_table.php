<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntregablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entregables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->integer('fase_id')->nullable();
            $table->integer('campania_id')->nullable();
            $table->integer('etapa_id')->nullable();
            $table->integer('estado_id')->nullable();
            $table->integer('autor_id')->nullable();
            $table->integer('responsable_id')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
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
        Schema::dropIfExists('entregables');
    }
}
