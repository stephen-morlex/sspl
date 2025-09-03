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
        Schema::create('fantasy_player_selections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fantasy_team_id');
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('fixture_id')->nullable();
            $table->decimal('points', 10, 2)->default(0.00);
            $table->boolean('is_captain')->default(false);
            $table->boolean('is_vice_captain')->default(false);
            $table->timestamps();
            
            $table->foreign('fantasy_team_id')->references('id')->on('fantasy_teams')->onDelete('cascade');
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('cascade');
            
            // Ensure a player can only be selected once per fantasy team
            $table->unique(['fantasy_team_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fantasy_player_selections');
    }
};
