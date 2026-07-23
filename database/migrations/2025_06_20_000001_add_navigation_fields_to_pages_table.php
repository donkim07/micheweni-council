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
            if (!Schema::hasColumn('pages', 'show_in_navigation')) {
                $table->boolean('show_in_navigation')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('pages', 'navigation_order')) {
                $table->integer('navigation_order')->default(0)->after('show_in_navigation');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            if (Schema::hasColumn('pages', 'show_in_navigation')) {
                $table->dropColumn('show_in_navigation');
            }
            if (Schema::hasColumn('pages', 'navigation_order')) {
                $table->dropColumn('navigation_order');
            }
        });
    }
}; 