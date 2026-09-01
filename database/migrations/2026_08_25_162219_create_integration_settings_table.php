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
        Schema::create('integration_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('service'); // ashby, workday, bamboohr, greenhouse
            $table->string('api_key')->nullable();
            $table->string('api_secret')->nullable();
            $table->json('settings')->nullable();
            $table->enum('status', ['active', 'inactive', 'error'])->default('inactive');
            $table->timestamp('last_sync_at')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'service']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('integration_settings');
    }
};
