<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaniasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campanias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre')->nullable();
            $table->string('NIT')->nullable();
            $table->integer('porcentaje')->nullable();
            $table->integer('cliente_id')->nullable();
            $table->integer('fase_id')->nullable();
            $table->integer('categoria_id')->nullable();
            $table->string('encargado')->nullable();
            $table->string('numero_contacto')->nullable();
            $table->string('email')->nullable();
            $table->dateTime('fecha_entrega')->nullable();
            $table->boolean('activo')->nullable();
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
        Schema::dropIfExists('campanias');
    }
}
