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
        // Skip if the templates table already exists (from our 2023 migration)
        if (Schema::hasTable('templates')) {
            return;
        }
        
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('identifier')->unique();
            $table->string('category');
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('animation')->nullable();
            $table->string('hover_effect')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable();
            $table->json('default_content')->nullable();
            $table->string('css_classes')->nullable();
            $table->timestamps();
        });
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn('template_identifier');
        });
        
        // Don't drop the table in the down method to avoid conflicts
        // with our 2023 migration
    }
}; 