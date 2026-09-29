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
        Schema::table('applications', function (Blueprint $table) {
            //
            $table->integer('screening_score')->default(0)->after('status');
            $table->json('screening_breakdown')->nullable()->after('screening_score');
            $table->string('screening_band')->nullable()->after('screening_breakdown'); // strong, good, average, weak
            $table->boolean('auto_knocked_out')->default(false)->after('screening_band');
            $table->string('knockout_reason')->nullable()->after('auto_knocked_out');
            $table->timestamp('screened_at')->nullable()->after('knockout_reason');
            $table->index('screening_score');
            $table->index('screening_band');
        });

        Schema::table('job_posts', function (Blueprint $table) {
            $table->json('screening_weights')->nullable()->after('status');
            $table->json('knockout_rules')->nullable()->after('screening_weights');
            $table->boolean('screening_enabled')->default(true)->after('knockout_rules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            //
        });
    }
};
