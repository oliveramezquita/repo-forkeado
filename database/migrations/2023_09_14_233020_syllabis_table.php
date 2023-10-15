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
        Schema::create('syllabis', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->foreignId('degree_id')->constrained()->onDelete('cascade'); // Nota: Aquí, apuntamos a la tabla de grados archivados
            $table->foreignId('course_id')->constrained()->onDelete('cascade'); // Nota: Aquí, apuntamos a la tabla de cursos archivados
            $table->string('code')->nullable();
            $table->integer('max_failed_subjects_to_pass')->default(0);
            $table->integer('age');
            $table->string('hex_colour', 7)->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->timestamp('archived_at')->nullable(); // Nuevo campo para la fecha de archivo
            $table->foreignId('school_year_id')->constrained()->onDelete('cascade'); // Nuevo campo para indicar el año escolar
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabis');
    }
};
