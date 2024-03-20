<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    // public function send_reset_password_email(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //     ]);

    //     $email = $request->email;
    //     $user = User::where('email', $email)->first();

    //     if (!$user) {
    //         return response()->json(['message' => 'Email not found'], 404);
    //     }

    //     // Generate 5-digit token
    //     $token = rand(10000, 99999);
    //     PasswordReset::create([
    //         'email' => $request->email,
    //         'token' => $token,
    //         'created_at' => Carbon::now(),
    //     ]);

    //     // Mail send
    //     Mail::send('reset', ['token' => $token], function ($message) use ($email) {
    //         $message->subject('Reset Your Password');
    //         $message->to($email);
    //     });

    //     return response([
    //         'message' => 'Password Reset Email Sent. Check Your Email.',
    //         'status' => 'success',
    //     ], 200);
    // }
    public function send_reset_password_email(Request $request)
{
    try {
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

        DB::beginTransaction();

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

        DB::commit();

        return response([
            'message' => 'Password Reset Email Sent. Check Your Email.',
            'status' => 'success',
        ], 200);
    } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['error' => 'An error occurred while sending the password reset email.'], 500);
    }
}


    // public function reset(Request $request, $token)
    // {
    //     $formated= Carbon::now()->subMinutes(1)
    //     ->toDateString();
    //     PasswordReset::where('created_at', '<=',$formated)->delete();

    //     $request->validate([
    //         'password' => 'required',
    //     ]);
      

    //     $passwordReset = PasswordReset::where('token', $token)->first();

    //     if (!$passwordReset) {
    //         return response()->json(['message' => 'Invalid token'], 404);
    //     }

    //     $user = User::where('email', $passwordReset->email)->first();

    //     if (!$user) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     $user->password = Hash::make($request->password);
    //     $user->save();

    //     PasswordReset::where('email', $user->email)->delete();


    //     return response()->json(['message' => 'Password reset successfully'], 200);
    // }
    public function reset(Request $request)
{

    $formated= Carbon::now()->subMinutes(1)
        ->toDateString();
        PasswordReset::where('created_at', '<=',$formated)->delete();
    
    $validator = Validator::make($request->all(), [
        'otp' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 400);
    }

    $otp = $request->otp;
    $passwordReset = PasswordReset::where('token', $otp);

    if (!$passwordReset) {
        return response()->json(['message' => 'Invalid OTP'], 404);
    }

    // Additional checks can be performed here

    // $passwordReset->delete(); // Delete the OTP record

    return response()->json(['message' => 'OTP verified successfully'], 200);
}

public function resetPassword(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 400);
    }

    $email = $request->email;
    $user = User::where('email', $email)->first();

    if (!$user) {
        return response()->json(['message' => 'User not found'], 404);
    }

    // Update the user's password
    $user->password = Hash::make($request->password);
    $user->save();

    // Optionally, you may want to delete the existing password reset record
      PasswordReset::where('email', $user->email)->delete();


    return response()->json(['message' => 'Password reset successfully'], 200);
}

}
?>