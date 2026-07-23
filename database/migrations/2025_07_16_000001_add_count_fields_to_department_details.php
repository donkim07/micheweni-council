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
        Schema::table('government_department_details', function (Blueprint $table) {
            $table->boolean('include_services_count')->default(false)->after('statistics');
            $table->boolean('include_projects_count')->default(false)->after('include_services_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('government_department_details', function (Blueprint $table) {
            $table->dropColumn('include_services_count');
            $table->dropColumn('include_projects_count');
        });
    }
}; 