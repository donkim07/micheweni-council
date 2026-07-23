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
            // Make sure meta_data column exists for storing achievement progress
            if (!Schema::hasColumn('contents', 'meta_data')) {
                $table->json('meta_data')->nullable()->after('content');
            }
            
            // Make sure is_featured column exists
            if (!Schema::hasColumn('contents', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_active');
            }
            
            // Make sure sort_order column exists
            if (!Schema::hasColumn('contents', 'sort_order')) {
                $table->integer('sort_order')->default(0)->after('is_featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // We don't want to remove these columns in down() as they might be used elsewhere
        // So this is intentionally left empty
    }
};
