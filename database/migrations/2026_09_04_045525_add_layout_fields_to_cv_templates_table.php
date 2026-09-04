<?php
// Create a new migration to add layout fields
// php artisan make:migration add_layout_fields_to_cv_templates_table

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            $table->string('layout_type')->default('classic_professional')->after('style');
            $table->string('layout_view_path')->nullable()->after('layout_type');
            $table->json('layout_config')->nullable()->after('layout_view_path');
        });
    }

    public function down()
    {
        Schema::table('cv_templates', function (Blueprint $table) {
            $table->dropColumn(['layout_type', 'layout_view_path', 'layout_config']);
        });
    }
};