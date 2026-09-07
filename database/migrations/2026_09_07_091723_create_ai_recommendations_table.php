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
        // 4. AI Feedback & Recommendations
        Schema::create('ai_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_match_id')->constrained()->onDelete('cascade');
            $table->text('recommendation')->nullable();
            $table->json('strengths')->nullable();
            $table->json('weaknesses')->nullable();
            $table->json('interview_questions')->nullable();
            $table->text('ai_analysis')->nullable();
            $table->string('confidence_score')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_recommendations');
    }
};
