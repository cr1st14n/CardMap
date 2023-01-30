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
        Schema::create('cred_renovs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('idEmpleado')->nullable();
            $table->string('cr_tipo')->nullable();
            $table->string('cr_baja_CodigoTarjeta')->nullable();
            $table->string('cr_baja_CodMYFARE')->nullable();
            $table->string('cr_nueva_CodigoTarjeta')->nullable();
            $table->string('cr_nueva_CodMYFARE')->nullable();
            $table->string('cr_motivo')->nullable();
            $table->string('cr_estadoImp')->nullable();
            $table->longText('cr_data')->nullable();

            // * campos Auditoria
            $table->string('ca_tipo');
            $table->boolean('ca_estado');
            $table->string('ca_codUsu');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cred_renovs');
    }
};
