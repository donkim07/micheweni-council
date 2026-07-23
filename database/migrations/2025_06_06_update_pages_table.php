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
        Schema::table('pages', function (Blueprint $table) {
            // Add visibility_roles column if it doesn't exist
            if (!Schema::hasColumn('pages', 'visibility_roles')) {
                $table->json('visibility_roles')->nullable()->after('meta_data');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'visibility_roles')) {
                $table->dropColumn('visibility_roles');
            }
        });
    }
}; 