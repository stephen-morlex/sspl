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
        Schema::create('team_stats', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('team_id')->constrained('teams')->onDelete('cascade');
            
            // Goals
            $table->unsignedInteger('goals_for')->default(0);
            $table->unsignedInteger('goals_against')->default(0);
            $table->unsignedInteger('penalty_goals')->default(0);
            $table->unsignedInteger('own_goals')->default(0);
            
            // Cards
            $table->unsignedInteger('yellow_cards')->default(0);
            $table->unsignedInteger('red_cards')->default(0);
            
            // Other stats
            $table->unsignedInteger('assists')->default(0);
            $table->unsignedInteger('substitutions_in')->default(0);
            $table->unsignedInteger('substitutions_out')->default(0);
            $table->unsignedInteger('corners')->default(0);
            $table->unsignedInteger('offsides')->default(0);
            $table->unsignedInteger('fouls_committed')->default(0);
            $table->unsignedInteger('fouls_suffered')->default(0);
            $table->unsignedInteger('shots_on_target')->default(0);
            $table->unsignedInteger('shots_off_target')->default(0);
            $table->unsignedInteger('shots_blocked')->default(0);
            $table->unsignedInteger('passes_completed')->default(0);
            $table->unsignedInteger('passes_attempted')->default(0);
            $table->unsignedInteger('tackles_won')->default(0);
            $table->unsignedInteger('tackles_lost')->default(0);
            $table->unsignedInteger('interceptions')->default(0);
            $table->unsignedInteger('clearances')->default(0);
            $table->unsignedInteger('blocks')->default(0);
            $table->unsignedInteger('saves')->default(0);
            $table->unsignedInteger('penalties_saved')->default(0);
            $table->unsignedInteger('penalties_missed')->default(0);
            $table->unsignedInteger('duels_won')->default(0);
            $table->unsignedInteger('duels_lost')->default(0);
            $table->unsignedInteger('aerial_duels_won')->default(0);
            $table->unsignedInteger('aerial_duels_lost')->default(0);
            
            $table->unsignedInteger('matches_played')->default(0);
            $table->unsignedInteger('wins')->default(0);
            $table->unsignedInteger('draws')->default(0);
            $table->unsignedInteger('losses')->default(0);
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index('team_id');
            $table->unique('team_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_stats');
    }
};