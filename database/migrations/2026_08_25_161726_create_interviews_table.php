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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('recruiter_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['phone', 'video', 'onsite', 'technical', 'hr', 'panel']);
            $table->datetime('scheduled_at');
            $table->string('duration_minutes')->nullable();
            $table->string('location')->nullable();
            $table->text('meeting_link')->nullable();
            $table->text('notes')->nullable();
            $table->json('participants')->nullable();
            $table->enum('status', ['scheduled', 'confirmed', 'completed', 'cancelled', 'rescheduled']);
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamps();

            $table->index(['application_id', 'status']);
            $table->index(['scheduled_at', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
