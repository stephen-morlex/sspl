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
        Schema::create('coaches', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('first_name');
            $table->string('last_name');
            $table->foreignUlid('team_id')->constrained()->onDelete('cascade');
            $table->date('date_of_birth')->nullable();
            $table->string('nationality')->nullable();
            $table->text('bio')->nullable();
            $table->string('photo_path')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coaches');
    }
};
