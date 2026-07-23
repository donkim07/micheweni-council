<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Simpler approach - remove the identifier column and add it back as nullable
        Schema::table('contents', function (Blueprint $table) {
            if (Schema::hasColumn('contents', 'identifier')) {
                // Remove the identifier column
                $table->dropColumn('identifier');
            }
        });
        
        Schema::table('contents', function (Blueprint $table) {
            // Add identifier column back as nullable
            $table->string('identifier')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            if (Schema::hasColumn('contents', 'identifier')) {
                // Fill in null identifiers with auto-generated values
                DB::table('contents')->whereNull('identifier')->update(['identifier' => DB::raw('CONCAT("content-", id)')]);
                
                // Remove the nullable identifier column
                $table->dropColumn('identifier');
            }
        });
        
        Schema::table('contents', function (Blueprint $table) {
            // Add back non-nullable unique identifier column
            $table->string('identifier')->unique()->after('id')->comment('Unique identifier for this content block');
        });
    }
};
