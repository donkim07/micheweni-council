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
        if (Schema::hasTable('form_submissions')) {
            Schema::table('form_submissions', function (Blueprint $table) {
                // Add meta_data column if it doesn't exist
                if (!Schema::hasColumn('form_submissions', 'meta_data')) {
                    $table->json('meta_data')->nullable();
                }
                
                // Add ip_address column if it doesn't exist
                if (!Schema::hasColumn('form_submissions', 'ip_address')) {
                    $table->string('ip_address')->nullable();
                }
                
                // Add user_agent column if it doesn't exist
                if (!Schema::hasColumn('form_submissions', 'user_agent')) {
                    $table->text('user_agent')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('form_submissions')) {
            Schema::table('form_submissions', function (Blueprint $table) {
                if (Schema::hasColumn('form_submissions', 'meta_data')) {
                    $table->dropColumn('meta_data');
                }
                
                if (Schema::hasColumn('form_submissions', 'ip_address')) {
                    $table->dropColumn('ip_address');
                }
                
                if (Schema::hasColumn('form_submissions', 'user_agent')) {
                    $table->dropColumn('user_agent');
                }
            });
        }
    }
}; 