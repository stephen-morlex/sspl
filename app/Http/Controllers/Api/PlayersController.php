<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players = Player::with('team')->get();
        return response()->json($players);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'team_id' => 'required|exists:teams,id',
            'position' => 'required|string|in:GK,DEF,MID,FWD',
            'shirt_number' => 'required|integer|min:1|max:99',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:255',
            'height' => 'nullable|integer',
            'weight' => 'nullable|integer',
            'bio' => 'nullable|string',
            'photo_path' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $player = Player::create($validated);
        return response()->json($player, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $player = Player::with('team')->findOrFail($id);
        return response()->json($player);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $player = Player::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|max:255',
            'last_name' => 'sometimes|required|string|max:255',
            'team_id' => 'sometimes|required|exists:teams,id',
            'position' => 'sometimes|required|string|in:GK,DEF,MID,FWD',
            'shirt_number' => 'sometimes|required|integer|min:1|max:99',
            'date_of_birth' => 'nullable|date',
            'nationality' => 'nullable|string|max:255',
            'height' => 'nullable|integer',
            'weight' => 'nullable|integer',
            'bio' => 'nullable|string',
            'photo_path' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $player->update($validated);
        return response()->json($player);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $player = Player::findOrFail($id);
        $player->delete();
        return response()->json(null, 204);
    }
}
