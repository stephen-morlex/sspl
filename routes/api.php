<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TeamsController;
use App\Http\Controllers\Api\PlayersController;
use App\Http\Controllers\Api\LeaguesController;
use App\Http\Controllers\Api\FixturesController;
use App\Http\Controllers\Api\StandingsController;

Route::middleware('api')->group(function () {
    Route::apiResource('teams', TeamsController::class);
    Route::apiResource('players', PlayersController::class);
    Route::apiResource('leagues', LeaguesController::class);
    Route::apiResource('fixtures', FixturesController::class);
    Route::apiResource('standings', StandingsController::class);
});