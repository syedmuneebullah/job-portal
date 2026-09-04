<?php
// database/migrations/2026_09_04_000002_create_job_seeker_cvs_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_seeker_cvs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('cv_template_id')->constrained()->onDelete('cascade');
            
            // CV content
            $table->json('content')->nullable();
            $table->json('customizations')->nullable();
            
            // CV specific settings
            $table->foreignId('cv_template_color_id')->nullable()->constrained('cv_template_colors')->onDelete('set null');
            $table->json('selected_sections')->nullable();
            
            // CV metadata
            $table->string('title')->nullable();
            $table->string('file_path')->nullable();
            $table->enum('status', ['draft', 'completed', 'published'])->default('draft');
            
            // Versioning
            $table->integer('version')->default(1);
            $table->timestamp('last_generated_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_seeker_cvs');
    }
};