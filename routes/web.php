<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\MatchdayLive;
use App\Livewire\PlayerProfile;
use App\Livewire\TeamProfile;
use App\Livewire\Dashboard;
use App\Livewire\LeagueStandings;
use App\Livewire\WelcomePage;
use App\Livewire\TeamsIndex;
use App\Livewire\TeamShow;
use App\Livewire\PlayersIndex;
use App\Livewire\PlayerShow;
use App\Livewire\NewsIndex;
use App\Livewire\NewsShow;
use App\Livewire\FixtureShow;
use App\Models\News;


Route::get('/', HomePage::class)->name('home')->lazy();

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard')->lazy();

// Livewire component routes for testing
Route::get('/matches', MatchdayLive::class)->name('matches')->lazy();

Route::get('/standings', LeagueStandings::class)->name('standings')->lazy();

// Team routes
Route::get('/teams', TeamsIndex::class)->name('teams.index')->lazy();
Route::get('/teams/{id}', TeamShow::class)->name('teams.show')->lazy();

// Player routes
Route::get('/players', PlayersIndex::class)->name('players.index')->lazy();
Route::get('/players/{id}', PlayerShow::class)->name('players.show')->lazy();

// News routes
Route::get('/news', NewsIndex::class)->name('news.index')->lazy();
Route::get('/news/{news:slug}', NewsShow::class)->name('news.show')->lazy();

// Fixture routes
Route::get('/fixtures/{id}', FixtureShow::class)->name('fixtures.show')->lazy();