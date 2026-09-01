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
        Schema::table('employers', function (Blueprint $table) {
            // Add company-related columns
            $table->string('company_name')->nullable();
            $table->string('company_logo')->nullable()->after('company_name');
            $table->text('company_description')->nullable()->after('company_logo');
            $table->string('website')->nullable()->after('company_description');
            $table->string('industry')->nullable()->after('website');
            $table->string('company_size')->nullable()->after('industry');
            $table->year('founded_year')->nullable()->after('company_size');
            $table->string('headquarters')->nullable()->after('founded_year');
            $table->string('linkedin_url')->nullable()->after('headquarters');
            $table->string('twitter_url')->nullable()->after('linkedin_url');
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending')->after('twitter_url');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employers', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'company_logo',
                'company_description',
                'website',
                'industry',
                'company_size',
                'founded_year',
                'headquarters',
                'linkedin_url',
                'twitter_url',
                'verification_status',
                'verified_at'
            ]);
        });
    }
};