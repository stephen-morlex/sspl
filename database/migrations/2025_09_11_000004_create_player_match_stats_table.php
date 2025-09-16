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
        Schema::create('player_match_stats', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('player_id')->constrained('players')->onDelete('cascade');
            $table->foreignUlid('match_id')->constrained('fixtures')->onDelete('cascade');
            $table->foreignUlid('team_id')->constrained('teams')->onDelete('cascade');
            
            // Goals
            $table->unsignedSmallInteger('goals')->default(0);
            $table->unsignedSmallInteger('penalty_goals')->default(0);
            $table->unsignedSmallInteger('own_goals')->default(0);
            
            // Cards
            $table->unsignedSmallInteger('yellow_cards')->default(0);
            $table->unsignedSmallInteger('red_cards')->default(0);
            
            // Other stats
            $table->unsignedSmallInteger('assists')->default(0);
            $table->unsignedSmallInteger('substitutions_in')->default(0);
            $table->unsignedSmallInteger('substitutions_out')->default(0);
            $table->unsignedSmallInteger('corners')->default(0);
            $table->unsignedSmallInteger('offsides')->default(0);
            $table->unsignedSmallInteger('fouls_committed')->default(0);
            $table->unsignedSmallInteger('fouls_suffered')->default(0);
            $table->unsignedSmallInteger('shots_on_target')->default(0);
            $table->unsignedSmallInteger('shots_off_target')->default(0);
            $table->unsignedSmallInteger('shots_blocked')->default(0);
            $table->unsignedSmallInteger('passes_completed')->default(0);
            $table->unsignedSmallInteger('passes_attempted')->default(0);
            $table->unsignedSmallInteger('tackles_won')->default(0);
            $table->unsignedSmallInteger('tackles_lost')->default(0);
            $table->unsignedSmallInteger('interceptions')->default(0);
            $table->unsignedSmallInteger('clearances')->default(0);
            $table->unsignedSmallInteger('blocks')->default(0);
            $table->unsignedSmallInteger('saves')->default(0);
            $table->unsignedSmallInteger('penalties_saved')->default(0);
            $table->unsignedSmallInteger('penalties_missed')->default(0);
            $table->unsignedSmallInteger('duels_won')->default(0);
            $table->unsignedSmallInteger('duels_lost')->default(0);
            $table->unsignedSmallInteger('aerial_duels_won')->default(0);
            $table->unsignedSmallInteger('aerial_duels_lost')->default(0);
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['match_id', 'player_id']);
            $table->unique(['match_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_match_stats');
    }
};