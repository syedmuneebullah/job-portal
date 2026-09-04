<?php
// database/migrations/2026_09_04_000001_create_cv_templates_table.php

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
        Schema::create('cv_templates', function (Blueprint $table) {
            $table->id();
            
            // Basic template information
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            
            // Template design configuration (JSON)
            $table->json('design_config')->nullable();
            
            // Template structure (JSON)
            $table->json('structure')->nullable();
            
            // Template styling (CSS/JSON)
            $table->json('styling')->nullable();
            
            // Template type and category
            $table->enum('category', ['professional', 'modern', 'creative', 'minimalist', 'executive'])->default('professional');
            $table->enum('style', ['classic', 'modern', 'creative', 'compact', 'detailed'])->default('modern');
            
            // Template colors (primary, secondary, accent)
            $table->json('default_colors')->nullable();
            
            // Font settings
            $table->json('default_fonts')->nullable();
            
            // Template sections (ordered list of sections)
            $table->json('sections')->nullable();
            
            // Template features/flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_premium')->default(false);
            $table->boolean('is_default')->default(false);
            
            // Usage statistics
            $table->integer('usage_count')->default(0);
            $table->integer('download_count')->default(0);
            
            // Template preview HTML or view path
            $table->string('preview_view')->nullable();
            $table->string('template_view')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });

        // Pivot table for template sections (allowing custom ordering per template)
        Schema::create('cv_template_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_template_id')->constrained()->onDelete('cascade');
            $table->string('section_key');
            $table->string('section_name');
            $table->string('section_icon')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_required')->default(false);
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        // Pivot table for template color schemes
        Schema::create('cv_template_colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cv_template_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('primary_color');
            $table->string('secondary_color');
            $table->string('accent_color');
            $table->string('text_color')->default('#1a1a1a');
            $table->string('background_color')->default('#ffffff');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv_template_colors');
        Schema::dropIfExists('cv_template_sections');
        Schema::dropIfExists('cv_templates');
    }
};