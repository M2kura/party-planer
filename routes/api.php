<?php

use App\Http\Controllers\PartyController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\GuestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('parties', PartyController::class);
Route::apiResource('items', ItemController::class);
Route::apiResource('guests', GuestController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
