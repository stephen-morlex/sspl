<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/we', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function (Request $request) {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Livewire component routes for testing
Route::get('/matches', function () {
    return view('components.matches');
})->name('matches');

Route::get('/teams/{id}', function ($id) {
    return view('components.team-profile', ['teamId' => $id]);
})->name('teams.show');

Route::get('/players/{id}', function ($id) {
    return view('components.player-profile', ['playerId' => $id]);
})->name('players.show');

Route::get('/standings', function () {
    return view('components.standings');
})->name('standings');
