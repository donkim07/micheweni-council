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
        Schema::table('government_news', function (Blueprint $table) {
            $table->boolean('is_ticker')->default(false)->after('is_featured');
            $table->boolean('is_critical')->default(false)->after('is_ticker');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('government_news', function (Blueprint $table) {
            $table->dropColumn(['is_ticker', 'is_critical']);
        });
    }
}; 