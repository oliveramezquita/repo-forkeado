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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('in_charge')->nullable();
            $table->string('code')->nullable();
            $table->string('name');
            $table->string('desc')->nullable();
            $table->string('color')->default('#000000');
            $table->enum('meeting_day', ['1', '2', '3', '4', '5', '6', '7'])->nullable();
            $table->time('meeting_time')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();

            $table->foreign('in_charge')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
