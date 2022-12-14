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
        Schema::create('term_aeros', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('ta_nombre')->nullable();
            $table->string('ta_sigla')->nullable();
            $table->string('ta_depen_cod')->nullable();
            $table->longText('ta_data')->nullable();

            // * campos Auditoria
            $table->string('tipo');
            $table->boolean('estado');
            $table->string('codUsu');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_aeros');
    }
};
