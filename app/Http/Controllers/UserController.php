<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
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
        $user->storeProfileImage($imagePath);
    
        $imageUrl = asset('storage/profile_images/' . basename($imagePath));
    
        return response()->json(['message' => 'Profile image uploaded successfully', 'imageUrl' => $imageUrl]);
    }
    
}
