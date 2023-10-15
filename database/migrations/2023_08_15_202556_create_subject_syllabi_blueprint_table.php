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
        Schema::create('subject_syllabi_blueprint', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained('subjects_blueprint')->onDelete('cascade');
            $table->foreignId('syllabi_id')->constrained('syllabis_blueprint')->onDelete('cascade');
            $table->boolean('is_mandatory')->default(1);
            $table->float('school_hours', 4, 2);
            $table->float('price', 5, 2);
            $table->boolean('is_speciality')->default(0);
            $table->integer('student_ratio')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_syllabi_blueprint');
    }
};
