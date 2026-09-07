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
        // 2. Job Requirements (skills and criteria)
        Schema::create('job_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained()->onDelete('cascade');
            $table->json('required_skills')->nullable();
            $table->json('preferred_skills')->nullable();
            $table->json('required_experience')->nullable(); // [{years: 5, domain: 'software'}]
            $table->json('required_education')->nullable(); // [{degree: 'BSc', field: 'Computer Science'}]
            $table->json('required_certifications')->nullable();
            $table->json('soft_skills')->nullable();
            $table->integer('min_experience_years')->nullable();
            $table->integer('max_experience_years')->nullable();
            $table->string('min_education_level')->nullable();
            $table->json('preferred_qualifications')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_requirements');
    }
};
