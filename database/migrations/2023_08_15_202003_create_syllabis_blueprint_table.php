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
        Schema::create('syllabis_blueprint', function (Blueprint $table) {
            $table->id();
            $table->string("name")->nullable();
            $table->foreignId('degree_id')->constrained('degrees_blueprint')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses_blueprint')->onDelete('cascade');
            $table->string('code')->nullable();
            $table->integer('max_failed_subjects_to_pass')->default(0);
            $table->integer('age');
            $table->string('hex_colour', 7)->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syllabis_blueprint');
    }
};
