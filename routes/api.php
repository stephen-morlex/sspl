<?php

use App\Http\Controllers\Api\FixturesController;
use App\Http\Controllers\Api\LeaguesController;
use App\Http\Controllers\Api\PlayersController;
use App\Http\Controllers\Api\StandingsController;
use App\Http\Controllers\Api\TeamsController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::apiResource('teams', TeamsController::class)->names([
        'index' => 'api.teams.index',
        'store' => 'api.teams.store',
        'show' => 'api.teams.show',
        'update' => 'api.teams.update',
        'destroy' => 'api.teams.destroy',
    ]);
    Route::apiResource('players', PlayersController::class)->names([
        'index' => 'api.players.index',
        'store' => 'api.players.store',
        'show' => 'api.players.show',
        'update' => 'api.players.update',
        'destroy' => 'api.players.destroy',
    ]);
    Route::apiResource('leagues', LeaguesController::class)->names([
        'index' => 'api.leagues.index',
        'store' => 'api.leagues.store',
        'show' => 'api.leagues.show',
        'update' => 'api.leagues.update',
        'destroy' => 'api.leagues.destroy',
    ]);
    Route::apiResource('fixtures', FixturesController::class)->names([
        'index' => 'api.fixtures.index',
        'store' => 'api.fixtures.store',
        'show' => 'api.fixtures.show',
        'update' => 'api.fixtures.update',
        'destroy' => 'api.fixtures.destroy',
    ]);
    Route::apiResource('standings', StandingsController::class)->names([
        'index' => 'api.standings.index',
        'store' => 'api.standings.store',
        'show' => 'api.standings.show',
        'update' => 'api.standings.update',
        'destroy' => 'api.standings.destroy',
    ]);
});
