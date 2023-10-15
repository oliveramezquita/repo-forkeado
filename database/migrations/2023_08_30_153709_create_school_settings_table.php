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
        Schema::create('school_settings', function (Blueprint $table) {
            $table->id();

            // General information
            $table->string('school_name');
            $table->string('school_name_short')->nullable();
            $table->string('school_address');
            $table->string('school_phone');
            $table->string('school_cif');
            $table->string('school_email');
            $table->string('school_web')->nullable();
            $table->string('school_logo')->nullable();

            // Schooling
            $table->integer('subjects_to_pass');
            $table->boolean('previous_subject_passed');

            // Inventory
            $table->integer('max_loans');

            // Finance
            $table->integer('max_annual_instalments_fees');

            // Scholar year
            $table->date('current_enrollment');
            $table->date('end_current_enrollment')->nullable();
            $table->date('next_enrollment')->nullable();
            $table->date('end_next_enrollment')->nullable();
            $table->date('starting_time')->nullable();
            $table->date('ending_time')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_settings');
    }
};
