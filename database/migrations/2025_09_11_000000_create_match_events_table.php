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
        Schema::create('match_events', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('match_id')->constrained('fixtures')->onDelete('cascade');
            $table->foreignUlid('team_id')->nullable()->constrained('teams')->onDelete('cascade');
            $table->foreignUlid('player_id')->nullable()->constrained('players')->onDelete('cascade');
            $table->string('event_type');
            $table->unsignedSmallInteger('minute');
            $table->string('period')->default('1H'); // 1H|HT|2H|ET|FT|PENALTIES
            $table->json('details')->nullable();
            $table->json('pitch_position')->nullable(); // {x, y}
            $table->json('updated_score')->nullable(); // {home, away}
            $table->string('source')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
            
            // Indexes for performance
            $table->index('match_id');
            $table->index(['match_id', 'minute']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('match_events');
    }
};