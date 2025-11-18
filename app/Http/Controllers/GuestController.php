<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Guest::with(['user', 'party'])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'party_id' => 'required|exists:parties,id',
            'status' => 'nullable|string', // e.g., 'pending', 'attending'
        ]);

        // Prevent duplicate invites for the same user/party
        $guest = Guest::firstOrCreate(
            [
                'user_id' => $validated['user_id'],
                'party_id' => $validated['party_id']
            ],
            ['status' => $validated['status'] ?? 'pending']
        );

        return response()->json($guest, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $guest = Guest::with(['user', 'party'])->findOrFail($id);
        return response()->json($guest);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guest = Guest::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string', // e.g. Update RSVP to 'confirmed'
        ]);

        $guest->update($validated);

        return response()->json($guest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guest = Guest::findOrFail($id);
        $guest->delete();

        return response()->json(['message' => 'Guest removed from party']);
    }
}
