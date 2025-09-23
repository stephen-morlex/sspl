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
        Schema::create('lineup_players', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('lineup_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('player_id')->constrained()->onDelete('cascade');
            $table->string('role')->comment('starting or bench');
            $table->string('position_on_pitch')->nullable();
            $table->integer('entered_at_minute')->nullable();
            $table->integer('substituted_out_minute')->nullable();
            $table->timestamps();

            // Ensure a player can only be in a lineup once
            $table->unique(['lineup_id', 'player_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineup_players');
    }
};
