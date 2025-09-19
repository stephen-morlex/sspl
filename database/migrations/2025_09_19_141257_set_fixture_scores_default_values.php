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
        // Update existing records with NULL values to 0
        DB::table('fixtures')->whereNull('home_score')->update(['home_score' => 0]);
        DB::table('fixtures')->whereNull('away_score')->update(['away_score' => 0]);
        
        // Since SQLite has limitations with changing column defaults,
        // we'll handle this at the application level in the model
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this migration
    }
};
