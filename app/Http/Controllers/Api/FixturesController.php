<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fixture;
use Illuminate\Http\Request;

class FixturesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fixtures = Fixture::with(['homeTeam', 'awayTeam', 'league'])->get();
        return response()->json($fixtures);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'home_team_id' => 'required|exists:teams,id',
            'away_team_id' => 'required|exists:teams,id',
            'league_id' => 'required|exists:leagues,id',
            'kickoff_time' => 'required|date',
            'venue' => 'required|string|max:255',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'required|string|in:scheduled,live,finished,postponed',
            'match_summary' => 'nullable|string',
        ]);

        $fixture = Fixture::create($validated);
        return response()->json($fixture, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fixture = Fixture::with(['homeTeam', 'awayTeam', 'league'])->findOrFail($id);
        return response()->json($fixture);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $fixture = Fixture::findOrFail($id);

        $validated = $request->validate([
            'home_team_id' => 'sometimes|required|exists:teams,id',
            'away_team_id' => 'sometimes|required|exists:teams,id',
            'league_id' => 'sometimes|required|exists:leagues,id',
            'kickoff_time' => 'sometimes|required|date',
            'venue' => 'sometimes|required|string|max:255',
            'home_score' => 'nullable|integer|min:0',
            'away_score' => 'nullable|integer|min:0',
            'status' => 'sometimes|required|string|in:scheduled,live,finished,postponed',
            'match_summary' => 'nullable|string',
        ]);

        $fixture->update($validated);
        return response()->json($fixture);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fixture = Fixture::findOrFail($id);
        $fixture->delete();
        return response()->json(null, 204);
    }
}
