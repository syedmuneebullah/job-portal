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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('requirements');
            $table->text('benefits')->nullable();
            $table->string('department')->nullable();
            $table->string('location');
            $table->enum('work_type', ['remote', 'onsite', 'hybrid']);
            $table->enum('employment_type', ['full_time', 'part_time', 'contract', 'internship', 'freelance']);
            $table->string('experience_level');
            $table->string('salary_min')->nullable();
            $table->string('salary_max')->nullable();
            $table->string('currency', 3)->default('USD');
            $table->json('required_skills')->nullable();
            $table->json('preferred_skills')->nullable();
            $table->string('education_requirement')->nullable();
            $table->foreignId('employer_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('recruiter_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('visibility', ['public', 'private', 'agency_only'])->default('public');
            $table->enum('status', ['draft', 'published', 'closed', 'paused'])->default('draft');
            $table->boolean('is_ai_generated')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamp('closing_at')->nullable();
            $table->integer('max_applications')->nullable();
            $table->json('application_questions')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Add indexes
            $table->index(['employer_id', 'status']);
            $table->index(['recruiter_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
