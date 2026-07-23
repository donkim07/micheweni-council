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
            // Add new content columns
            if (!Schema::hasColumn('contents', 'title_sw')) {
                $table->string('title_sw')->nullable()->after('title');
            }
            
            if (!Schema::hasColumn('contents', 'content_sw')) {
                $table->longText('content_sw')->nullable()->after('content');
            }
            
            if (!Schema::hasColumn('contents', 'template')) {
                $table->string('template')->nullable()->after('type');
            }
            
            if (!Schema::hasColumn('contents', 'css_class')) {
                $table->string('css_class')->nullable()->after('is_featured');
            }
            
            if (!Schema::hasColumn('contents', 'css_style')) {
                $table->text('css_style')->nullable()->after('css_class');
            }
            
            // Rename sort_order to order if it exists
            if (Schema::hasColumn('contents', 'sort_order') && !Schema::hasColumn('contents', 'order')) {
                $table->renameColumn('sort_order', 'order');
            } elseif (!Schema::hasColumn('contents', 'order')) {
                $table->integer('order')->default(0)->after('is_featured');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            // Revert the changes in reverse order
            if (Schema::hasColumn('contents', 'css_style')) {
                $table->dropColumn('css_style');
            }
            
            if (Schema::hasColumn('contents', 'css_class')) {
                $table->dropColumn('css_class');
            }
            
            if (Schema::hasColumn('contents', 'template')) {
                $table->dropColumn('template');
            }
            
            if (Schema::hasColumn('contents', 'content_sw')) {
                $table->dropColumn('content_sw');
            }
            
            if (Schema::hasColumn('contents', 'title_sw')) {
                $table->dropColumn('title_sw');
            }
            
            // Rename order back to sort_order if it exists
            if (Schema::hasColumn('contents', 'order') && !Schema::hasColumn('contents', 'sort_order')) {
                $table->renameColumn('order', 'sort_order');
            }
        });
    }
}; 