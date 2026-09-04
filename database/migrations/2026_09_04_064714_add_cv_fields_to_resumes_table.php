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
        Schema::table('resumes', function (Blueprint $table) {
            //
            // Add CV-specific fields
            $table->foreignId('cv_template_id')->nullable()->constrained('cv_templates')->onDelete('set null');
            $table->foreignId('cv_template_color_id')->nullable()->constrained('cv_template_colors')->onDelete('set null');
            $table->json('content')->nullable();
            $table->json('customizations')->nullable();
            $table->json('selected_sections')->nullable();
            $table->enum('status', ['draft', 'completed', 'published'])->default('draft');
            $table->integer('version')->default(1);
            $table->timestamp('last_generated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            //
            $table->dropColumn([
                'cv_template_id',
                'cv_template_color_id',
                'content',
                'customizations',
                'selected_sections',
                'status',
                'version',
                'last_generated_at'
            ]);
        });
    }
};
