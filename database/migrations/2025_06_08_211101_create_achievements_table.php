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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_sw')->nullable();
            $table->text('description');
            $table->text('description_sw')->nullable();
            $table->string('icon')->default('fas fa-award');
            $table->foreignId('country_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('year')->nullable();
            $table->float('improvement')->nullable();
            $table->float('previous_score')->nullable();
            $table->float('current_score')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
