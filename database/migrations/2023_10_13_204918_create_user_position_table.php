<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_position', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');   // clave foránea para usuarios
            $table->unsignedBigInteger('position_id'); // clave foránea para posiciones

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->timestamps();

            // Puedes agregar campos adicionales si es necesario.

            // Si deseas que la combinación de user_id y position_id sea única puedes agregar la siguiente línea:
            $table->unique(['user_id', 'position_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_position');
    }
};
