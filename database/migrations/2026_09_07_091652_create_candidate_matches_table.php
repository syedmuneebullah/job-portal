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
        // 3. Candidate Matching Results
        Schema::create('candidate_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->foreignId('resume_parse_id')->constrained()->onDelete('cascade');
            
            // Match scores
            $table->float('overall_score')->default(0); // 0-100
            $table->float('skills_match_score')->default(0);
            $table->float('experience_match_score')->default(0);
            $table->float('education_match_score')->default(0);
            $table->float('certifications_match_score')->default(0);
            
            // Match details
            $table->json('matched_skills')->nullable();
            $table->json('missing_skills')->nullable();
            $table->json('matching_experience')->nullable();
            $table->json('matching_education')->nullable();
            $table->json('match_details')->nullable();
            
            // Ranking
            $table->integer('rank')->nullable();
            $table->string('tier')->nullable(); // A, B, C, D
            
            $table->boolean('is_shortlisted')->default(false);
            $table->boolean('is_recommended')->default(false);
            $table->boolean('is_viewed')->default(false);
            $table->timestamp('matched_at')->nullable();
            $table->timestamps();
            
            $table->unique(['job_post_id', 'application_id']);
            $table->index(['job_post_id', 'overall_score']);
            $table->index('tier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_matches');
    }
};
