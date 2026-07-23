<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        try {
            // Check if the sections table exists
            if (!Schema::hasTable('sections')) {
                // The original migration might have failed, create it now
                Schema::create('sections', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('page_id')->constrained()->onDelete('cascade');
                    $table->string('title')->nullable();
                    $table->string('identifier')->unique();
                    $table->string('type')->default('content');
                    $table->integer('order')->default(0);
                    $table->string('background_color')->nullable();
                    $table->string('text_color')->nullable();
                    $table->string('padding')->nullable();
                    $table->string('margin')->nullable();
                    $table->string('css_class')->nullable();
                    $table->text('css_style')->nullable();
                    $table->boolean('is_active')->default(true);
                    $table->json('meta_data')->nullable();
                    $table->timestamps();
                });
                
                Log::info('Created sections table successfully');
            } else {
                Log::info('Sections table already exists, checking for required columns');
                
                // If the table exists but some columns are missing, add them
                Schema::table('sections', function (Blueprint $table) {
                    if (!Schema::hasColumn('sections', 'background_color')) {
                        $table->string('background_color')->nullable();
                    }
                    if (!Schema::hasColumn('sections', 'text_color')) {
                        $table->string('text_color')->nullable();
                    }
                    if (!Schema::hasColumn('sections', 'padding')) {
                        $table->string('padding')->nullable();
                    }
                    if (!Schema::hasColumn('sections', 'margin')) {
                        $table->string('margin')->nullable();
                    }
                    if (!Schema::hasColumn('sections', 'css_class')) {
                        $table->string('css_class')->nullable();
                    }
                    if (!Schema::hasColumn('sections', 'css_style')) {
                        $table->text('css_style')->nullable();
                    }
                    if (!Schema::hasColumn('sections', 'meta_data')) {
                        $table->json('meta_data')->nullable();
                    }
                });
                
                Log::info('Updated sections table with any missing columns');
            }
            
            // Update the contents table to ensure the section column is the right type
            Schema::table('contents', function (Blueprint $table) {
                // First check if the column exists
                if (Schema::hasColumn('contents', 'section')) {
                    // Modify it to ensure it's the right type
                    $table->string('section')->change();
                } else {
                    // Add the column if it doesn't exist
                    $table->string('section')->nullable()->after('content');
                }
                
                // Add index on section column
                if (!Schema::hasIndex('contents', 'contents_section_index')) {
                    $table->index('section', 'contents_section_index');
                }
            });
            
            Log::info('Migration completed successfully');
        } catch (\Exception $e) {
            Log::error('Error in sections table migration: ' . $e->getMessage());
            throw $e; // Re-throw to indicate migration failure
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the sections table as it might be managed by the original migration
        // Just remove the added index from contents
        if (Schema::hasTable('contents') && Schema::hasIndex('contents', 'contents_section_index')) {
            Schema::table('contents', function (Blueprint $table) {
                $table->dropIndex('contents_section_index');
            });
        }
    }
};
