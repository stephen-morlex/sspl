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
        Schema::create('lineups', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('fixture_id')->constrained()->onDelete('cascade');
            $table->foreignUlid('team_id')->constrained()->onDelete('cascade');
            $table->string('formation')->nullable();
            $table->timestamps();

            // Ensure a team can only have one lineup per fixture
            $table->unique(['fixture_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lineups');
    }
};
