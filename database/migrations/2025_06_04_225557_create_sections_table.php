<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * This migration must run after the pages table is created
     */
    public function up(): void
    {
        // First ensure the pages table exists
        if (!Schema::hasTable('pages')) {
            throw new \Exception('The pages table must be created before running this migration');
        }
        
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('identifier');
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
}; 