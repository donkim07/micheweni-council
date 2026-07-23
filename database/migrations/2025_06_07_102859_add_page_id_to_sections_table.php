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
        Schema::table('sections', function (Blueprint $table) {
            // Check if page_id column doesn't already exist
            if (!Schema::hasColumn('sections', 'page_id')) {
                // Add page_id column with nullable foreign key
                $table->unsignedBigInteger('page_id')->nullable()->after('id');
                
                // Add foreign key constraint
                $table->foreign('page_id')
                      ->references('id')
                      ->on('pages')
                      ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            // Check if page_id column exists
            if (Schema::hasColumn('sections', 'page_id')) {
                // Drop foreign key constraint first
                $table->dropForeign(['page_id']);
                
                // Then drop the column
                $table->dropColumn('page_id');
            }
        });
    }
};
