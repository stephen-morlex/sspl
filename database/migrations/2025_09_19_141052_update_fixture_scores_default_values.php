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
        // First update existing records with NULL values to 0
        DB::table('fixtures')->whereNull('home_score')->update(['home_score' => 0]);
        DB::table('fixtures')->whereNull('away_score')->update(['away_score' => 0]);
        
        // Then modify the columns to have default values
        Schema::table('fixtures', function (Blueprint $table) {
            $table->integer('home_score')->default(0)->change();
            $table->integer('away_score')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fixtures', function (Blueprint $table) {
            $table->integer('home_score')->default(null)->change();
            $table->integer('away_score')->default(null)->change();
        });
    }
};
