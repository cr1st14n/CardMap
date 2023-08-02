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
        Schema::create('punto_accesos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('p_nombre');
            $table->string('p_areas');
            $table->string('p_ipCod')->unique();
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
        Schema::dropIfExists('punto_accesos');
    }
};
