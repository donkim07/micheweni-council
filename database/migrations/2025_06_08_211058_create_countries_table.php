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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('flag')->nullable();
            $table->float('circularity_score')->default(0);
            $table->string('region')->nullable();
            $table->float('waste_per_capita')->nullable();
            $table->float('circular_material_use_rate')->nullable();
            $table->float('waste_properly_treated')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('ranking')->nullable();
            $table->boolean('is_local')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
