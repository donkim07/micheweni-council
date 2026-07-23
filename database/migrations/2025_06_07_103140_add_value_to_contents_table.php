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
            // Check if value column doesn't already exist
            if (!Schema::hasColumn('contents', 'value')) {
                // Add value column after content_sw
                $table->longText('value')->nullable()->after('content_sw')
                      ->comment('Content value for components (HTML, JSON, or plain text)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            // Check if value column exists
            if (Schema::hasColumn('contents', 'value')) {
                // Drop the column
                $table->dropColumn('value');
            }
        });
    }
};
