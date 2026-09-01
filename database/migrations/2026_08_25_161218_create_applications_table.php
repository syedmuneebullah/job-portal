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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained()->onDelete('cascade');
            $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('recruiter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('status', [
                'applied',
                'under_review',
                'shortlisted',
                'interview',
                'offer',
                'hired',
                'rejected',
                'withdrawn'
            ])->default('applied');
            $table->decimal('ai_match_score', 5, 2)->nullable();
            $table->json('match_details')->nullable();
            $table->json('answers')->nullable();
            $table->text('cover_letter')->nullable();
            $table->boolean('is_referral')->default(false);
            $table->string('referral_code')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('shortlisted_at')->nullable();
            $table->timestamp('interview_at')->nullable();
            $table->timestamp('offered_at')->nullable();
            $table->timestamp('hired_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->unique(['job_post_id', 'applicant_id']);
            $table->index(['job_post_id', 'status']);
            $table->index(['applicant_id', 'status']);
            $table->index(['recruiter_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
