<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Item::with('guest')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'party_id' => 'required|exists:parties,id',
            'name' => 'required|string|max:255',
            'quantity' => 'integer|min:1',
            'guest_id' => 'nullable|exists:guests,id', // Optional: assign to a guest immediately
        ]);

        $item = Item::create($validated);

        return response()->json($item, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Item::with('guest')->findOrFail($id);
        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Item::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'quantity' => 'sometimes|integer|min:1',
            'guest_id' => 'nullable|exists:guests,id', // Use this to claim an item
        ]);

        $item->update($validated);

        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }
}
