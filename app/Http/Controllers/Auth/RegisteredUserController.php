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
    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'country' => ['required', 'string', 'max:255'],
                'dial_code' => ['required', 'string'],
                'phone' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $request->name,
                'country' => $request->country,
                'phone' => $request->phone,
                'dial_code' => $request->dial_code,

                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
           
            return response()->json([
                'message' => 'User created successfully',
                'user' => $user,
            ]);
        } catch (ValidationException $e) {
            // Handle validation exception
            return response()->json([
                'error' => $e->validator->errors()->first(),
            ], JsonResponse::HTTP_CONFLICT);
        }
    }
}
