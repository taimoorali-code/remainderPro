<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function sendverifyemail($email)
    {
        if (auth()->user()) {
            return response()->json(['success' => 'User is authenticated']);

        }else{
            return response()->json(['error' => 'hello User is not authenticated']);
        }

    }
    public function getUserById($userId): JsonResponse
    {
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json(['user' => $user]);
    }
    public function update(Request $request, $userId): JsonResponse
    {
        $user = User::findOrFail($userId);
        
        $data = $request->validate([
            'name' => 'string|max:255',
            'dial_code' => 'string',
            'email' => 'email|unique:users,email,' . $userId,
            'country' => 'string|max:255',
            'phone' => 'string|max:255',
        ]);

        $user->updateUser($data);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    public function uploadProfileImage(Request $request, $userId): JsonResponse
    {
        $user = User::findOrFail($userId);
    
        $request->validate([
            'image' => 'required|image',
        ]);
    
        $imagePath = $request->file('image')->store('public/profile_images');
        $imageUrl = asset('storage/app/public/profile_images/' . basename($imagePath));

        $user->storeProfileImage($imageUrl);
    
    
        return response()->json(['message' => 'Profile image uploaded successfully', 'imageUrl' => $imageUrl]);
    }
    
}
