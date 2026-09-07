<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            // Add scheduled_at column for tracking when interview was scheduled
            $table->timestamp('scheduled_at')->nullable();
            
            // Add index for better performance on scheduled queries
            $table->index('scheduled_at');
        });

       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn('scheduled_at');
            $table->dropIndex(['scheduled_at']);
        });

        // Revert status back (optional)
        // Since we can't know which were originally 'interview' vs 'interviewing',
        // we'll just note that status changes were made
    }
};