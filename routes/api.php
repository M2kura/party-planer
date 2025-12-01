<?php

use App\Http\Controllers\PartyController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- Public Authentication Routes ---
// These routes do NOT require a token/session to access
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// --- Protected API Routes ---
// All routes within this group require a valid token/session ('auth:sanctum')
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('parties', PartyController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('guests', GuestController::class);

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
