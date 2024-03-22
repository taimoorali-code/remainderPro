<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use GuzzleHttp\Client;
use App\Models\User;
use App\Helpers\SocialLoginHelper;
use Carbon\Carbon;

class SocialAuthController extends Controller
{
    public function social_customer_login(Request $request): JsonResponse
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'unique_id' => 'required',
            'email' => 'required_if:medium,google,facebook',
            'medium' => 'required|in:google,facebook',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => SocialLoginHelper::handleLoginError($validator)], 403);
        }

        // Initialize Guzzle HTTP client
        $client = new Client();
        $token = $request['token'];
        $email = $request['email'];
        $unique_id = $request['unique_id'];

        try {
            // Make API request to Google or Facebook based on the medium
            if ($request['medium'] == 'google') {
                $res = $client->request('GET', 'https://www.googleapis.com/oauth2/v3/tokeninfo?id_token=' . $token);
                $data = json_decode($res->getBody()->getContents(), true);
            } elseif ($request['medium'] == 'facebook') {
                $res = $client->request('GET', 'https://graph.facebook.com/' . $unique_id . '?access_token=' . $token . '&&fields=name,email');
                $data = json_decode($res->getBody()->getContents(), true);
            }
        } catch (\Exception $exception) {
            $errors = [];
            $errors[] = ['code' => 'auth-001', 'message' => 'Invalid Token'];
            return response()->json(['errors' => $errors], 401);
        }

        // Check if email from token matches the provided email
        if (strcmp($email, $data['email']) != 0) {
            return response()->json(['error' => 'Email mismatch'], 403);
        }

        // Find or create user based on email
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            // Create a new user if not found
            $user = new User();
            $user->email = $data['email'];
            $user->name= $request['token'];
            // Add other user details as needed
            $user->save();
        }
        else{
            return response()->json(['error' => "User Already Exist"], 200);

        }

        // Generate access token for the user
        $token = $user->createToken('AuthToken')->accessToken;

        return response()->json(['token' => $token], 200);
    }
}
