<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\HomePage;
use App\Livewire\MatchdayLive;
use App\Livewire\PlayerProfile;
use App\Livewire\TeamProfile;
use App\Livewire\Dashboard;
use App\Livewire\LeagueStandings;
use App\Livewire\WelcomePage;

Route::get('/we', WelcomePage::class);

Route::get('/', HomePage::class)->name('home');

Route::get('/dashboard', Dashboard::class)->middleware(['auth', 'verified'])->name('dashboard');

// Livewire component routes for testing
Route::get('/matches', MatchdayLive::class)->name('matches');

Route::get('/teams/{id}', TeamProfile::class)->name('teams.show');

Route::get('/players/{id}', PlayerProfile::class)->name('players.show');

Route::get('/standings', LeagueStandings::class)->name('standings');