<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActividadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actividades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('prioridad')->nullable();
            $table->integer('campania_id')->nullable();
            $table->integer('etapa_id')->nullable();
            $table->integer('gant_id')->nullable();
            $table->integer('estado_id')->nullable();
            $table->integer('autor_id')->nullable();
            $table->integer('usuario_asignado')->nullable();
            $table->dateTime('fecha_asignacion')->nullable();
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
        Schema::dropIfExists('actividades');
    }
}
