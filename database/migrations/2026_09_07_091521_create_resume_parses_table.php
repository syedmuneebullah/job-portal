<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Resume Parsing Results
        Schema::create('resume_parses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_name');
            $table->json('parsed_data')->nullable();
            $table->json('skills')->nullable();
            $table->json('experience')->nullable();
            $table->json('education')->nullable();
            $table->json('certifications')->nullable();
            $table->json('languages')->nullable();
            $table->text('summary')->nullable();
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->timestamp('parsed_at')->nullable();
            $table->timestamps();
            
            $table->index('user_id');
            $table->index('status');
        });

        
    }

    public function down()
    {
        
        Schema::dropIfExists('resume_parses');
    }
};