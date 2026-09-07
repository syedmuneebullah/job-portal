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
        Schema::create('schedule_interviews', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('employer_id')->constrained('employers')->onDelete('cascade');
            $table->foreignId('job_post_id')->constrained('job_posts')->onDelete('cascade');
            
            // Interview details
            $table->dateTime('interview_datetime');
            $table->integer('duration')->default(60); // Duration in minutes
            $table->string('timezone')->default('UTC');
            
            // Platform details
            $table->string('platform')->default('zoom'); // zoom, teams, google_meet, in_person, phone
            $table->string('meeting_id')->nullable();
            $table->string('meeting_link')->nullable();
            $table->string('meeting_password')->nullable();
            $table->string('meeting_join_url')->nullable();
            
            // Interviewer details
            $table->string('interviewer_name')->nullable();
            $table->string('interviewer_email')->nullable();
            
            // Status and notes
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'rescheduled'])->default('scheduled');
            $table->text('notes')->nullable();
            $table->text('feedback')->nullable();
            
            // Rescheduling
            $table->dateTime('original_datetime')->nullable();
            $table->text('reschedule_reason')->nullable();
            
            // Reminders
            $table->boolean('reminder_sent')->default(false);
            $table->timestamp('reminder_sent_at')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['application_id', 'status']);
            $table->index(['interview_datetime']);
            $table->index(['employer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_interviews');
    }
};