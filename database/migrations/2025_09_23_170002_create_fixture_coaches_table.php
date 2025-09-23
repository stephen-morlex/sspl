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
        Schema::create('fixture_coaches', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('fixture_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('coach_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('team_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            // Ensure a coach can only be assigned to a team in a fixture once
            $table->unique(['fixture_id', 'coach_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixture_coaches');
    }
};
