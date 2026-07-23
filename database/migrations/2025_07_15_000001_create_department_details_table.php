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
        Schema::create('government_department_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('government_departments')->onDelete('cascade');
            $table->text('overview')->nullable();
            $table->text('responsibilities')->nullable();
            $table->json('statistics')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('government_department_details');
    }
}; 