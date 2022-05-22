<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('idUsuario');            
            $table->string('email')->unique();
            $table->string('password');
            $table->string('tipo_usuario');
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_baja')->nullable();
            $table->integer('liquidacion')->default(0);
            $table->string('profesion')->nullable();
            $table->string('referencia')->nullable();
            $table->boolean('estado')->nullable()->default(false);
            $table->json('settings');
            $table->unsignedBigInteger('persona_id');
            $table->foreign('persona_id')->references('idPersona')->on('personas')->onDelete('cascade');
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
        Schema::dropIfExists('usuarios');
    }
}
