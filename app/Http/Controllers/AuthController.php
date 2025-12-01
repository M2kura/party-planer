<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle an incoming user login request.
     * POST /api/login
     */
    public function login(Request $request): JsonResponse
    {
        // 1. Validate the incoming request data
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Attempt to authenticate the user
        if (! Auth::attempt($request->only('email', 'password'))) {
            // Fails if credentials don't match or user doesn't exist
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // 3. Retrieve the authenticated User model
        $user = User::where('email', $request->email)->firstOrFail();

        // 4. Generate a new Personal Access Token for the user
        // We use 'auth_token' as the name and grant all abilities ('*')
        $token = $user->createToken('auth_token', ['*'])->plainTextToken;

        // 5. Return the user data and the token
        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer', // Inform the client this is a Bearer token
        ]);
    }

    /**
     * Handle an incoming user registration request.
     * POST /api/register (Optional but highly recommended)
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token', ['*'])->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 201); // 201 Created status
    }

    /**
     * Handle user logout request.
     * POST /api/logout
     */
    public function logout(Request $request): JsonResponse
    {
        // Revoke the token that was used for the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
