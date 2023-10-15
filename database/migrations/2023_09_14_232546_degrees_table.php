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
        Schema::create('degrees', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('name');
            $table->integer('max_failed_subjects_to_pass')->default(0);
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
        Schema::dropIfExists('degrees');
    }
};
