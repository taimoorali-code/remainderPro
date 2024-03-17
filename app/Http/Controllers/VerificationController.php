<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (! $user->hasVerifiedEmail()) {
            // Check if the provided code matches the user's verification code
            if ($user->verification_code === $request->verification_code) {
                $user->markEmailAsVerified();
                return response()->json(['message' => 'Email verified successfully'], 200);
            } else {
                return response()->json(['message' => 'Invalid verification code'], 400);
            }
        } else {
            return response()->json(['message' => 'Email already verified'], 201);
        }
    }

}
