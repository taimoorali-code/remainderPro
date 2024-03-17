<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordResetController extends Controller
{
    public function send_reset_password_email(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found'], 404);
        }

        // Generate 5-digit token
        $token = rand(10000, 99999);
        PasswordReset::create([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Mail send
        Mail::send('reset', ['token' => $token], function ($message) use ($email) {
            $message->subject('Reset Your Password');
            $message->to($email);
        });

        return response([
            'message' => 'Password Reset Email Sent. Check Your Email.',
            'status' => 'success',
        ], 200);
    }

    public function reset(Request $request, $token)
    {
        $formated= Carbon::now()->subMinutes(1)
        ->toDateString();
        PasswordReset::where('created_at', '<=',$formated)->delete();

        $request->validate([
            'password' => 'required',
        ]);
      

        $passwordReset = PasswordReset::where('token', $token)->first();

        if (!$passwordReset) {
            return response()->json(['message' => 'Invalid token'], 404);
        }

        $user = User::where('email', $passwordReset->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        PasswordReset::where('email', $user->email)->delete();


        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}
?>