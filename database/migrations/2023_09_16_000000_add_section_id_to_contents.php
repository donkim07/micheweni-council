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
        if (Schema::hasTable('contents')) {
            Schema::table('contents', function (Blueprint $table) {
                if (!Schema::hasColumn('contents', 'section_id')) {
                    $table->unsignedBigInteger('section_id')->nullable()->after('page_id');
                    $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('contents')) {
            Schema::table('contents', function (Blueprint $table) {
                if (Schema::hasColumn('contents', 'section_id')) {
                    $table->dropForeign(['section_id']);
                    $table->dropColumn('section_id');
                }
            });
        }
    }
}; 