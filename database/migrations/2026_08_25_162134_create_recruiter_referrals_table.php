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
        Schema::create('recruiter_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recruiter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_post_id')->nullable()->constrained()->onDelete('set null');
            $table->string('referral_code')->unique();
            $table->integer('click_count')->default(0);
            $table->integer('signup_count')->default(0);
            $table->integer('application_count')->default(0);
            $table->integer('hire_count')->default(0);
            $table->json('analytics')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['recruiter_id', 'referral_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruiter_referrals');
    }
};
