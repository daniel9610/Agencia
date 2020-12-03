<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCampaniaEtapaMetodologiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campania_etapa_metodologias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('campania_etapa_id')->nullable();
            $table->string('metodologia')->nullable();
            $table->integer('autor_id')->nullable();
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
        Schema::dropIfExists('campania_etapa_metodologias');
    }
}
