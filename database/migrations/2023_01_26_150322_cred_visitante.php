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
        Schema::create('credVisitante',function (Blueprint $table)
        {
            $table->id();
            $table->timestamps();


           $table->integer('cv_Codigo')->nullable();
           $table->date('cv_fechaEmi')->nullable();
           $table->date('cv_FechaVenc')->nullable();
           $table->string('cv_areas')->nullable();
           $table->string('cv_tarjRfid')->nullable();
           $table->string('cv_tarjMyfare')->nullable();
           $table->string('cv_Aeropuerto')->nullable();
           $table->string('cv_Aeropuerto_2')->nullable();
           //    $table->integer(cv_OperadorEmi)->nullable();
           //    $table->string(cv_oficina)->nullable();
        //    $table->string(cv_estado)->nullable();
               
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
        Schema::dropIfExists('credVisitante');
    }
};
