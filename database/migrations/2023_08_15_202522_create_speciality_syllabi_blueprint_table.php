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
        Schema::create('speciality_syllabi_blueprint', function (Blueprint $table) {
            $table->id();
            $table->foreignId('speciality_id')->constrained('specialities_blueprint')->onDelete('cascade');
            $table->foreignId('syllabi_id')->constrained('syllabis_blueprint')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('speciality_syllabi_blueprint');
    }
};
