<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Standing;
use Illuminate\Http\Request;

class StandingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $standings = Standing::with(['team', 'league'])->get();
        return response()->json($standings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'team_id' => 'required|exists:teams,id',
            'league_id' => 'required|exists:leagues,id',
            'position' => 'required|integer',
            'played' => 'required|integer',
            'won' => 'required|integer',
            'drawn' => 'required|integer',
            'lost' => 'required|integer',
            'goals_for' => 'required|integer',
            'goals_against' => 'required|integer',
            'goal_difference' => 'required|integer',
            'points' => 'required|integer',
        ]);

        $standing = Standing::create($validated);
        return response()->json($standing, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $standing = Standing::with(['team', 'league'])->findOrFail($id);
        return response()->json($standing);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $standing = Standing::findOrFail($id);

        $validated = $request->validate([
            'team_id' => 'sometimes|required|exists:teams,id',
            'league_id' => 'sometimes|required|exists:leagues,id',
            'position' => 'sometimes|required|integer',
            'played' => 'sometimes|required|integer',
            'won' => 'sometimes|required|integer',
            'drawn' => 'sometimes|required|integer',
            'lost' => 'sometimes|required|integer',
            'goals_for' => 'sometimes|required|integer',
            'goals_against' => 'sometimes|required|integer',
            'goal_difference' => 'sometimes|required|integer',
            'points' => 'sometimes|required|integer',
        ]);

        $standing->update($validated);
        return response()->json($standing);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $standing = Standing::findOrFail($id);
        $standing->delete();
        return response()->json(null, 204);
    }
}
