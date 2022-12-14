<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->increments('id');
            $table->string('email')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->string('codusr')->nullable();
            $table->dateTime('fecven')->nullable();
            $table->string('nivel', 15)->nullable();
            $table->string('aeropuerto')->nullable();
            $table->string('pin', 15)->nullable();
            $table->string('mgc', 2)->nullable();
            $table->string('mad', 2)->nullable();
            $table->string('mvv', 2)->nullable();
            $table->string('ins', 2)->nullable();
            $table->string('upd', 2)->nullable();
            $table->string('del', 2)->nullable();
            $table->string('fot', 2)->nullable();
            $table->string('cad', 2)->nullable();
            $table->string('imp', 2)->nullable();
            $table->dateTime('feching')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
