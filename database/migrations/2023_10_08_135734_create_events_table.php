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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enrollment_id')->nullable();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->time('hour_start')->nullable()->default(null);
            $table->time('hour_end')->nullable()->default(null);
            $table->boolean('all_day')->nullable()->default(false);
            $table->enum('type', ["availability"])->nullable();
            $table->enum('day', ["monday", "tuesday", "wednesday", "thursday", "friday", "saturday", "sunday"])->nullable();
            $table->timestamps();

            $table->foreign('enrollment_id')->references('id')->on('enrollments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
