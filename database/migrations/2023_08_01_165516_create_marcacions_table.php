<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcacions', function (Blueprint $table) {
            $table->id();
            $table->timestamps(1);
            $table->integer('id_puntoAcceso');
            $table->integer('id_empleado');
            $table->string('ac_codigo');
            $table->string('ac_codTarjeta');
            $table->string('ac_areaSolicitud');
            $table->string('ac_areaPermitidas');
            $table->string('ac_estadoAcceso');
            $table->string('p_regional');
            $table->string('p_aeroIata');

            $table->string('ca_usu');
            $table->integer('ca_est');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcacions');
    }
};
