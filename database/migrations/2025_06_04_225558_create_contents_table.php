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
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('identifier')->unique()->comment('Unique identifier for this content block');
            $table->string('title')->nullable();
            $table->string('title_sw')->nullable();
            $table->text('content')->nullable();
            $table->text('content_sw')->nullable();
            $table->string('type')->default('text')->comment('text, html, image, etc.');
            $table->string('template')->nullable()->comment('Template system for this content');
            $table->string('template_identifier')->nullable()->comment('Template identifier for this content');
            $table->string('column_width')->nullable()->comment('Bootstrap grid column width (1-12)');
            $table->string('margin')->nullable()->comment('CSS margin property');
            $table->string('padding')->nullable()->comment('CSS padding property');
            $table->foreignId('page_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->string('section')->nullable()->comment('Section within the page');
            $table->integer('order')->default(0);
            $table->json('meta_data')->nullable()->comment('Additional metadata for this content');
            $table->json('meta')->nullable()->comment('Component settings and properties');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
