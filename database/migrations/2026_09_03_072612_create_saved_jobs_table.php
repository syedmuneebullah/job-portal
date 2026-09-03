<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('job_post_id')->constrained('job_posts')->onDelete('cascade');
            $table->text('notes')->nullable();
            $table->enum('status', ['saved', 'applied', 'archived'])->default('saved');
            $table->timestamp('applied_at')->nullable();
            $table->timestamps();
            
            // Prevent duplicate saves
            $table->unique(['user_id', 'job_post_id']);
            
            // Indexes for faster queries
            $table->index(['user_id', 'status']);
            $table->index('job_post_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_jobs');
    }
};