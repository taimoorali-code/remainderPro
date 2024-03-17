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
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

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
            $email= $request->email;
            $token = rand(10000, 99999);


            $user = User::create([
                'name' => $request->name,
                'country' => $request->country,
                'verification_code' =>$token,
                'phone' => $request->phone,
                'dial_code' => $request->dial_code,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // $token = $user->createToken($request->email)->plainTextToken;
            Mail::send('reset', ['token' => $token], function ($message) use ($email) {
                $message->subject('Verify Your Email');
                $message->to($email);
            });
           
            return response()->json([
                'message' => 'User registered successfully. Please verify your email.',
                'user' => $user,
            ], 201);
        } catch (ValidationException $e) {
            // Handle validation exception
            return response()->json([
                'error' => $e->validator->errors()->first(),
            ], JsonResponse::HTTP_CONFLICT);
        }
    }
    public function login(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255'],
                'password' => ['required', 'string'],
            ]);
    
            $credentials = $request->only('email', 'password');
    
            if (!Auth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
            }
    
            $user = $request->user();
    
            if (!$user->hasVerifiedEmail()) {
                return response()->json(['error' => 'Email not verified'], JsonResponse::HTTP_FORBIDDEN);
            }
    
            $token = $user->createToken($user->email)->plainTextToken;
    
            return response()->json([
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()->first()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
    public function logout()
{
    $user = Auth::user();
    $user->tokens()->delete();
    
    return response()->json(['message' => 'Logout successful'], 200);
}
}
