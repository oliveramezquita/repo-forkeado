<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('speciality_syllabi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('speciality_id')->constrained()->onDelete('cascade'); // Apuntando a la tabla de especialidades archivadas
            $table->foreignId('syllabi_id')->constrained()->onDelete('cascade'); // Apuntando a la tabla de planes de estudio archivados
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speciality_syllabi');
    }
};
