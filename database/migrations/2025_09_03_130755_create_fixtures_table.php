<?php

use App\Enums\FixtureStatus;
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
        Schema::create('fixtures', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('home_team_id');
            $table->ulid('away_team_id');
            $table->ulid('league_id');
            $table->dateTime('kickoff_time');
            $table->string('venue');
            $table->integer('home_score')->nullable();
            $table->integer('away_score')->nullable();
            $table->enum('status', FixtureStatus::values())->default(FixtureStatus::Scheduled->value);
            $table->text('match_summary')->nullable();
            $table->timestamps();
            
            $table->foreign('home_team_id')->references('id')->on('teams')->cascadeOnDelete();
            $table->foreign('away_team_id')->references('id')->on('teams')->cascadeOnDelete();
            $table->foreign('league_id')->references('id')->on('leagues')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
