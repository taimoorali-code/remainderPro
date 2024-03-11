<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request)
    // {
    //     $request->authenticate();

    //     $request->session()->regenerate();

    //     return response()->noContent();
    // }

    public function store(LoginRequest $request): JsonResponse
    {
        try {
            $request->authenticate();
            $user = $request->user();
            // $user->tokens()->delete();
            // $request->user()->currentAccessToken()->delete();
            $token = $user->createToken('Api-token');
    
            return response()->json([
                'user' => $user,
                'token' => $token->plainTextToken,
            ]);
        } catch (ValidationException $e) {
            // Authentication failed, return a custom JSON response
            return response()->json([
                'error' => 'Invalid credentials. Please check your username and password.',
            ], 401);
        } catch (\Exception $e) {
            // Handle other exceptions if needed
            return response()->json([
                'error' => 'An unexpected error occurred.',
            ], 500);
        }
    }
    
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        $user->tokens()->delete();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
        
    }
}
