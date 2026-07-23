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
        Schema::table('contents', function (Blueprint $table) {
            // Add meta column if it doesn't exist
            if (!Schema::hasColumn('contents', 'meta')) {
                $table->json('meta')->nullable()->after('meta_data')->comment('Component settings and properties');
            }
            
            // Add column_width if it doesn't exist
            if (!Schema::hasColumn('contents', 'column_width')) {
                $table->string('column_width')->nullable()->after('template')->comment('Bootstrap grid column width (e.g. col-md-6)');
            }
            
            // Add page_id if it doesn't have a default value
            if (Schema::hasColumn('contents', 'page_id')) {
                try {
                    DB::statement('ALTER TABLE contents MODIFY page_id BIGINT UNSIGNED NULL');
                } catch (\Exception $e) {
                    // Already nullable, ignore
                }
            }
            
            // Add template if it doesn't exist
            if (!Schema::hasColumn('contents', 'template')) {
                $table->string('template')->nullable()->after('type')->comment('Component template style');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't remove columns in down() as they might be used elsewhere
    }
}; 