<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\League;
use Illuminate\Http\Request;

class LeaguesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leagues = League::all();
        return response()->json($leagues);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'season_start_year' => 'required|integer',
            'season_end_year' => 'required|integer',
            'logo_path' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $league = League::create($validated);
        return response()->json($league, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $league = League::findOrFail($id);
        return response()->json($league);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $league = League::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'country' => 'sometimes|required|string|max:255',
            'season_start_year' => 'sometimes|required|integer',
            'season_end_year' => 'sometimes|required|integer',
            'logo_path' => 'nullable|string',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $league->update($validated);
        return response()->json($league);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $league = League::findOrFail($id);
        $league->delete();
        return response()->json(null, 204);
    }
}
