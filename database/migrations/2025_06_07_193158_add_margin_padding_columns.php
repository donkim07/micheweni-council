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
        Schema::table('contents', function (Blueprint $table) {
            // Add margin and padding columns if they don't exist
            if (!Schema::hasColumn('contents', 'margin')) {
                $table->string('margin')->nullable();
            }
            
            if (!Schema::hasColumn('contents', 'padding')) {
                $table->string('padding')->nullable();
            }
            
            // Add column_width if it doesn't exist - ensure it's VARCHAR for Bootstrap classes
            if (!Schema::hasColumn('contents', 'column_width')) {
                $table->string('column_width')->nullable();
            } else {
                // Modify existing column to ensure it's string type
                $table->string('column_width')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn(['margin', 'padding', 'column_width']);
        });
    }
};
