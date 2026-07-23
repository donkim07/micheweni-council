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
        Schema::create('waste_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // collection point, recycling center, landfill, etc.
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('image')->nullable();
            $table->json('operating_hours')->nullable();
            $table->json('accepted_materials')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_locations');
    }
};
