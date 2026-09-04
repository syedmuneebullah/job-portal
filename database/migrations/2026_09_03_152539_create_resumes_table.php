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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();

            // Foreign key to users table
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            // Resume details
            $table->string('title')->nullable();
            $table->string('file_path');
            $table->string('original_name');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('file_extension', 10)->nullable();

            // Status flags
            $table->boolean('is_active')->default(true);
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_parsed')->default(false);

            // Parsed data from resume
            $table->json('parsed_data')->nullable();
            $table->timestamp('parsed_at')->nullable();

            // Additional metadata
            $table->json('metadata')->nullable();
            $table->text('notes')->nullable;

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['user_id', 'is_active']);
            $table->index(['user_id', 'is_primary']);
            $table->index('is_active');
            $table->index('is_primary');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
