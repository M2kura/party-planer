<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load guests and items to reduce database queries
        return Party::with(['guests', 'items'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'party_date' => 'required|date', // Matches your Party model $fillable
            'location' => 'required|string',
            'host_id' => 'required|exists:users,id', // Validates host exists
        ]);

        $party = Party::create($validated);

        return response()->json($party, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find specific party and show all details including relationships
        $party = Party::with(['guests.user', 'items'])->findOrFail($id);
        return response()->json($party);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $party = Party::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'party_date' => 'sometimes|date',
            'location' => 'sometimes|string',
            'host_id' => 'sometimes|exists:users,id',
        ]);

        $party->update($validated);

        return response()->json($party);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $party = Party::findOrFail($id);
        $party->delete();

        return response()->json(['message' => 'Party deleted successfully']);
    }
}
