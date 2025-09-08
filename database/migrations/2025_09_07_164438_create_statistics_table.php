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
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained('players')->cascadeOnDelete();
            $table->foreignId('match_id')->constrained('fixtures')->cascadeOnDelete();
            
            // Performance stats
            $table->unsignedSmallInteger('goals')->default(0);
            $table->unsignedSmallInteger('assists')->default(0);
            $table->unsignedSmallInteger('penalties')->default(0);
            $table->unsignedSmallInteger('penalties_scored')->default(0);
            
            // In-game performance
            $table->unsignedSmallInteger('shots_on_goal')->default(0);
            $table->unsignedSmallInteger('woodwork_hits')->default(0);
            $table->unsignedSmallInteger('tackles_won')->default(0);
            $table->unsignedSmallInteger('aerial_duels_won')->default(0);
            $table->unsignedSmallInteger('fouls_committed')->default(0);
            $table->unsignedSmallInteger('yellow_cards')->default(0);
            
            // Physical/activity metrics
            $table->unsignedSmallInteger('sprints')->default(0);
            $table->unsignedSmallInteger('intensive_runs')->default(0);
            $table->decimal('distance_km', 5, 2)->default(0);
            $table->decimal('top_speed_kmh', 5, 2)->default(0);
            $table->unsignedSmallInteger('crosses')->default(0);
            
            // Recent-match details for flexible metrics
            $table->json('recent_match_details')->nullable();
            
            $table->timestamps();
            
            // Index for efficient querying
            $table->index(['player_id', 'match_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};