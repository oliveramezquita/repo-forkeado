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
        Schema::create('metadata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('address')->nullable();
            $table->string('locality')->nullable();
            $table->string('province')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone1')->nullable();
            $table->string('phone2')->nullable();
            $table->enum('gender', ["m", "w", "o"])->nullable();
            $table->text('comments')->nullable();
            $table->string('diseases')->nullable();
            $table->bigInteger('student_murciaeduca_id')->unique()->nullable();
            $table->string('student_number')->unique()->nullable();
            $table->string('student_school_schedule')->nullable();
            $table->boolean('student_request_loans')->nullable();
            $table->boolean('student_grant')->nullable();
            $table->unsignedBigInteger('student_experience_speciality_id')->nullable();
            $table->string('student_experience_years')->nullable();
            $table->enum('guardian_type', ["father", "guardian"])->nullable();
            $table->string('professor_number')->unique()->nullable();
            $table->string('professor_qualification')->nullable();
            $table->string('professor_contract_type')->nullable();
            $table->float('professor_hourly_rate')->nullable();
            $table->string('professor_social_security')->unique()->nullable();
            $table->float('professor_irpf')->nullable();
            $table->string('professor_iban')->nullable();
            $table->string('professor_reference')->nullable();
            $table->string('professor_health_insurance')->nullable();
            $table->timestamp('professor_entry_date')->nullable()->default(null);
            $table->timestamp('professor_leaving_date')->nullable()->default(null);
            $table->string('member_number')->unique()->nullable();
            $table->string('member_profession')->nullable();
            $table->string('member_mediator')->nullable();
            $table->enum('member_type', ["Sponsor", "Founder", "Volunteer"])->nullable();
            $table->string('business')->nullable();
            $table->timestamps();

            $table->foreign('student_experience_speciality_id')->references('id')->on('specialities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metadata');
    }
};
