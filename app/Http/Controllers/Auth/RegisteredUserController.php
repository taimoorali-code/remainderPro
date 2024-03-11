<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'country' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'country' => $request->contact,
                'phone' => $request->phone,

                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
           
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
                // 'authorization' => [
                //     // 'token' => $user->createToken('ApiToken')->plainTextToken,
                //     'type' => 'bearer',
                // ]
            ]);
        } catch (ValidationException $e) {
            // Handle unique validation exception
            return response()->json([
                'error' => 'User with the provided email already exists.',
            ], JsonResponse::HTTP_CONFLICT);
        }
    }
}
