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
        Schema::create('player_statistics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_id');
            $table->unsignedBigInteger('fixture_id');
            $table->integer('goals')->default(0);
            $table->integer('assists')->default(0);
            $table->integer('yellow_cards')->default(0);
            $table->integer('red_cards')->default(0);
            $table->integer('minutes_played')->default(0);
            $table->integer('saves')->default(0); // For goalkeepers
            $table->integer('clean_sheets')->default(0); // For defenders/midfielders/goalkeepers
            $table->decimal('fantasy_points', 10, 2)->default(0.00);
            $table->timestamps();
            
            $table->foreign('player_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('fixture_id')->references('id')->on('fixtures')->onDelete('cascade');
            
            // Ensure a player only has one statistics record per fixture
            $table->unique(['player_id', 'fixture_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_statistics');
    }
};
