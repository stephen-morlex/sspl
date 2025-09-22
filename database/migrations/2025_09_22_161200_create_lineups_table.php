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
            $table->foreignUlid('player_id')->constrained()->onDelete('cascade');
            $table->string('position')->nullable();
            $table->boolean('is_starting')->default(true);
            $table->timestamps();
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
