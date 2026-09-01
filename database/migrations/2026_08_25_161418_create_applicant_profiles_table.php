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
        Schema::create('applicant_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('summary')->nullable();
            $table->string('current_job_title')->nullable();
            $table->string('current_company')->nullable();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            $table->json('interests')->nullable();
            $table->string('resume_path')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('website')->nullable();
            $table->json('education')->nullable();
            $table->json('experience')->nullable();
            $table->json('certifications')->nullable();
            $table->json('publications')->nullable();
            $table->enum('preferred_work_type', ['remote', 'onsite', 'hybrid', 'any'])->default('any');
            $table->json('preferred_locations')->nullable();
            $table->string('salary_expectation_min')->nullable();
            $table->string('salary_expectation_max')->nullable();
            $table->string('currency', 3)->default('USD');
            $table->boolean('is_visible')->default(true);
            $table->timestamp('last_active_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'is_visible']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicant_profiles');
    }
};
